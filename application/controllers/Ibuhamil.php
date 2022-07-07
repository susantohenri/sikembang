<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ibuhamil extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Ibuhamils';
		$this->page_title = 'Ibu Hamil Baru';
		parent::__construct();
	}

	public function index () {
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
		  if (isset ($post['delete'])) $this->$model->delete($post['delete']);
		  else {
			  $db_debug = $this->db->db_debug;
			  $this->db->db_debug = FALSE;
	
			  $result = $this->$model->save($post);
	
			  $error = $this->db->error();
			  $this->db->db_debug = $db_debug;
			  if (isset ($result['error'])) $error = $result['error'];
			  if(count($error)){
				  $this->session->set_flashdata('model_error', $error['message']);
				  redirect($this->controller);
			  }
		  }
		}
		$vars = array();
		$vars['page_name'] = 'table-ibuhamil';
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
	  $vars['page_name'] = 'form-ibuhamil';
	  $vars['form']     = $this->$model->getForm();
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
	  $vars['page_name'] = 'form-ibuhamil';
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
}
