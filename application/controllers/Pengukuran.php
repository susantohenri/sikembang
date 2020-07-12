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

	function create()
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

		$found = $this->Pengukurans->findOne($id);
		$vars['warningSignExists'] = 1 === (int) $found['warning_sign'];

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

		$found = $this->Anaks->findOneWithUsia($anak, $retrieveDate);
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
			$since = $this->input->post('since');
			$until = $this->input->post('until');
			$rows = $this->Pengukurans->download($since, $until);
			$colnames = array_keys($rows[0]);

			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=sikembang.csv');

			$output = fopen('php://output', 'w');
			fputcsv($output, $colnames);
			foreach ($rows as $row) fputcsv($output, $row);
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

	function warning()
	{
		$params = array(
			'page_title' => 'Warning Signs',
			'page_name' => 'table_warning',
			'current' => array(
				'controller' => 'Pengukuran',
				'controller_url' => 'Pengukuran/warning_dt'
			),
			'js' => array(
				'jquery.dataTables.min.js',
				'dataTables.bootstrap4.js',
				'table.js'
			)
		);
		$this->loadview('index', $params);
	}

	function dt()
	{
		echo strpos($_SERVER['HTTP_REFERER'], 'warning') > -1 ?
			$this->{$this->model}->warningDt() :
			$this->{$this->model}->dt();
	}
}
