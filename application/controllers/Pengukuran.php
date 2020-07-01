<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengukuran extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Pengukurans';
		parent::__construct();
	}

	function create ($anak = null) {
		$model= $this->model;
		$vars = array();
		$vars['page_name'] = 'form';
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

}