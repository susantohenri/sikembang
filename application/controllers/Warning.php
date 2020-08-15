<?php defined('BASEPATH') or exit('No direct script access allowed');

class Warning extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Warnings';
		parent::__construct();
	}

	public function index()
	{
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
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
		$vars['submit_url'] = site_url('Warning');
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
}
