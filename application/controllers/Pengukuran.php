<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengukuran extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Pengukurans';
		parent::__construct();
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

	function read ($id) {
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
}
