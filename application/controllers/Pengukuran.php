<?php defined('BASEPATH') or exit('No direct script access allowed');

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

	function create($anak = null)
	{
		$model = $this->model;
		$vars = array();
		$vars['page_name'] = 'form_pengukuran';
		$vars['form']     = $this->$model->getForm(false, false, $anak);
		$vars['subform'] = $this->$model->getFormChild();
		$vars['uuid'] = '';
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'form.js'
		);
		$this->loadview('index', $vars);
	}

	function read($id)
	{
		$vars = array();
		$vars['page_name'] = 'form_pengukuran';
		$model = $this->model;
		$vars['form'] = $this->$model->getForm($id);
		$vars['subform'] = $this->$model->getFormChild($id);

		$found = $this->Pengukurans->findOne($id);
		$vars['warningSignExists'] = 1 === (int) $found['warning_sign'];

		$vars['uuid'] = $id;
		$vars['js'] = array(
			'moment.min.js',
			'bootstrap-datepicker.js',
			'daterangepicker.min.js',
			'select2.full.min.js',
			'form.js'
		);
		$this->loadview('index', $vars);
	}

	function validasi()
	{
		$this->load->model(array('Anaks', 'Antropometris'));
		$anak = $this->input->post('anak');
		$bb = $this->input->post('bb');
		$tb = $this->input->post('tb');

		$found = $this->Anaks->findOne($anak);
		echo json_encode(array(
			'hasil_bb' => $this->Antropometris->bb($found['jenis_kelamin'], $found['tgl_lahir'], $bb),
			'hasil_tb' => $this->Antropometris->tb($found['jenis_kelamin'], $found['tgl_lahir'], $tb),
			'hasil_gizi' => $this->Antropometris->gizi($found['jenis_kelamin'], $found['tgl_lahir'], $bb, $tb),
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
			$jenis = $this->input->post('jenis');
			$since = $this->input->post('since');
			$until = $this->input->post('until');
			$rows = $this->Pengukurans->download($jenis, $since, $until);
			$colnames = array_keys($rows[0]);

			$sum = array();
			foreach ($colnames as $colname) {
				$sum[$colname] = array_sum(array_map(function ($row) use ($colname) {
					return $row[$colname];
				}, $rows));
			}
			$sum['KATEGORI'] = 'TOTAL ANAK';

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=sikembang.csv');

			$output = fopen('php://output', 'w');
			fputcsv($output, $colnames);
			foreach ($rows as $row) fputcsv($output, $row);
			fputcsv($output, $sum);
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
}
