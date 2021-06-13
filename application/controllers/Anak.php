<?php defined('BASEPATH') or exit('No direct script access allowed');

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Anak extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Anaks';
		parent::__construct();
	}

	public function index()
	{
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
			if (isset($post['delete'])) $this->$model->delete($post['delete']);
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
		$vars['page_name'] = 'table-anak';
		$vars['js'] = array(
			'jquery.dataTables.min.js',
			'dataTables.bootstrap4.js',
			'table.js'
		);
		$vars['thead'] = $this->$model->thead;
		$this->loadview('index', $vars);
	}

	function create () {
	  $model= $this->model;
	  $vars = array();
	  $vars['page_name'] = 'form';
	  $vars['form']     = $this->$model->getForm();
	  $vars['subform'] = $this->$model->getFormChild();
	  $vars['uuid'] = '';
	  $vars['js'] = array(
		'moment.min.js',
		'bootstrap-datepicker.js',
		'daterangepicker.min.js',
		'select2.full.min.js',
		'form-anak.js'
	  );
	  $this->loadview('index', $vars);
	}

	function read ($id) {
	  $vars = array();
	  $vars['page_name'] = 'form';
	  $model = $this->model;
	  $vars['form'] = $this->$model->getForm($id);
	  $vars['subform'] = $this->$model->getFormChild($id);
	  $vars['uuid'] = $id;
	  $vars['js'] = array(
		'moment.min.js',
		'bootstrap-datepicker.js',
		'daterangepicker.min.js',
		'select2.full.min.js',
		'form-anak.js'
	  );
	  $this->loadview('index', $vars);
	}

	function download()
	{
		$rows = $this->Anaks->download();
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

		$merge_until = 'Q1';
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
	}

	function select2($model, $field)
	{
		$this->load->model($model);
		if ('Posyandus' === $model) echo '{"results":' . json_encode($this->$model->select2WithDesa($field, $this->input->post('term'), $this->input->post('desa'))) . '}';
		else echo '{"results":' . json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
	}
}
