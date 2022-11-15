<?php defined('BASEPATH') or exit('No direct script access allowed');

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Pengukuran extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Pengukurans';
		parent::__construct();
	}

	public function index()
	{
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
			if (isset($post['delete'])) $this->$model->delete($post['delete']);
			else if (isset($post['unsign'])) $this->$model->unsign($post['unsign']);
			else {
				$db_debug = $this->db->db_debug;
				$this->db->db_debug = FALSE;

				$result = $this->$model->save($post);

				$error = $this->db->error();
				$this->db->db_debug = $db_debug;
				if (isset($result['error'])) $error = $result['error'];
				if (count($error)) {
					$this->session->set_flashdata('model_error', $error['message']);
					redirect($this->controller);
				}
			}
		}
		$vars = array();
		$vars['page_name'] = 'table';
		$vars['js'] = array(
			'jquery.dataTables.min.js',
			'dataTables.bootstrap4.js',
			'table.js'
		);
		$vars['thead'] = $this->$model->thead;
		$this->loadview('index', $vars);
	}

	function _create()
	{
		$model = $this->model;
		$vars = array(
			'page_name' => 'form_pengukuran',
			'uuid' => '',
			'submit_url' => '',
			'js' => array(
				'moment.min.js',
				'bootstrap-datepicker.js',
				'daterangepicker.min.js',
				'select2.full.min.js',
				'form_pengukuran.js',
			)
		);

		if (!$this->input->post()) {
			$vars['form'] = $this->$model->getFormFirstStep();
		} else if (!$this->input->post('anak')) {
			$createdAt = $this->input->post('createdAt');
			$vars['form'] = $this->$model->getFormSecondStep($createdAt);
		} else {
			$createdAt = $this->input->post('createdAt');
			$anak = $this->input->post('anak');
			$vars['form'] = $this->$model->getForm(false, false, $anak, $createdAt);
			$vars['submit_url'] = site_url('Pengukuran');
		}

		$this->loadview('index', $vars);
	}

	function read($id)
	{
		$vars = array();
		$vars['page_name'] = 'form_pengukuran';
		$model = $this->model;
		$vars['form'] = $this->$model->getForm($id);
		$vars['subform'] = $this->$model->getFormChild($id);

		$vars['uuid'] = $id;
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'form_pengukuran.js'
		);
		$vars['submit_url'] = site_url('Pengukuran');
		$this->loadview('index', $vars);
	}

	function validasi()
	{
		$this->load->model(array('Anaks', 'Antropometris'));
		$anak = $this->input->post('anak');
		$bb = $this->input->post('bb');
		$tb = $this->input->post('tb');
		$retrieveDate = $this->input->post('createdAt');

		$found = $this->Anaks->findOne($anak, $retrieveDate);
		echo json_encode(array(
			'hasil_bb' => $this->Antropometris->bb($found['jenis_kelamin'], $found['tgl_lahir'], $bb, $retrieveDate),
			'hasil_tb' => $this->Antropometris->tb($found['jenis_kelamin'], $found['tgl_lahir'], $tb, $retrieveDate),
			'hasil_gizi' => $this->Antropometris->gizi($found['jenis_kelamin'], $found['tgl_lahir'], $bb, $tb, $retrieveDate),
		));
	}

	function unsign($uuid)
	{
		$vars = array();
		$vars['page_name'] = 'confirm_unsign';
		$vars['uuid'] = $uuid;
		$this->loadview('index', $vars);
	}

	function grafik()
	{
		if ($this->input->post()) {
			$jenis = $this->input->post('jenis');
			$since = $this->input->post('since');
			$until = $this->input->post('until');
			if ('imd' === $jenis) {
				$this->load->model('Anaks');
				echo $this->Anaks->imd();
			} else if ('asi' === $jenis) {
				echo $this->Pengukurans->grafik_asi();
			} else echo $this->Pengukurans->grafik($jenis, $since, $until);
		} else {
			$vars = array(
				'js' => array(
					'moment.min.js',
					'bootstrap-datepicker.js',
					'daterangepicker.min.js',
					'select2.full.min.js',
					'form.js',
					'Chart.min.js'
				),
				'page_name' => 'grafik',
			);
			$this->loadview('index', $vars);
		}
	}

	function download()
	{
		if ($this->input->post()) {
			$since = $this->input->post('since');
			$until = $this->input->post('until');
			$type = $this->input->post('type');
			$rows = $this->Pengukurans->download($type, $since, $until);
			$colnames = array_keys($rows[0]);

			$spreadsheet = new Spreadsheet();
			$spreadsheet->getProperties()
				->setTitle('Office 2007 XLSX Test Document')
				->setSubject('Office 2007 XLSX Test Document')
				->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
				->setKeywords('office 2007 openxml php')
				->setCategory('Test result file');

			// $spreadsheet->getActiveSheet()->setTitle(date('d-m-Y H'));
			$spreadsheet->setActiveSheetIndex(0);
			$spreadsheet->getDefaultStyle()->applyFromArray(array(
				'font'  => array(
					'size'  => 10,
				)
			));

			$alphabet = range('A', 'Z');
			$alphabet[] = 'AA';
			$alphabet[] = 'AB';
			$alphabet[] = 'AC';

			$merge_until = 'balita' === $type ? 'X1' : 'Q1';
			$spreadsheet->getActiveSheet()->mergeCells("A1:{$merge_until}");
			$spreadsheet->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal('center');
			$spreadsheet->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(16);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'DATA SASARAN BALITA');

			$spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'Kabupaten    : Boyolali');
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', 'Kecamatan    : Teras');
			$spreadsheet->setActiveSheetIndex(0)->getStyle('A3:A4')->getFont()->setSize(11);

			$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:A6')->getFont()->setBold(true);

			$rownum = 6;
			foreach ($colnames as $index => $content) {
				$spreadsheet->setActiveSheetIndex(0)
					->setCellValue("{$alphabet[$index]}$rownum", $content);
			}
			$spreadsheet->getActiveSheet()->getStyle("A6:{$alphabet[count($alphabet) - 1]}6")->getFont()->setBold(true);

			$rownum = 7;
			foreach ($rows as $row) {
				foreach ($colnames as $index => $colname) {
					$spreadsheet->setActiveSheetIndex(0)
						->setCellValue("{$alphabet[$index]}{$rownum}", $row[$colname]);
				}
				$rownum++;
			}

			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Sikembang.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
			exit;
		} else {
			$vars = array();
			$vars['page_name'] = 'download';
			$this->loadview('index', array(
				'js' => array(
					'moment.min.js',
					'bootstrap-datepicker.js',
					'daterangepicker.min.js',
					'select2.full.min.js',
					'form.js',
				),
				'page_name' => 'download',
			));
		}
	}

	function bulkCreate()
	{
		foreach ($this->input->post('records') as $record) {
			unset($record['last_submit']);
			$this->{$this->model}->create($record);
		}
		return true;
	}

	function bulkUpdate()
	{
		foreach ($this->input->post('records') as $record) {
			unset($record['last_submit']);
			$this->{$this->model}->update($record);
		}
		return true;
	}

	function bulkDelete()
	{
		foreach ($this->input->post('records') as $record) {
			unset($record['last_submit']);
			$this->{$this->model}->delete($record['delete']);
		}
		return true;
	}
}
