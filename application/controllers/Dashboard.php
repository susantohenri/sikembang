<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct ()
	{
		$this->page_title = '';
		parent::__construct();
	}

	function index ()
	{
	    $vars = array();
	    $this->load->model('Menus');
	    $vars['menu'] = $this->Menus->find(array('role' => $this->session->userdata('role')));
	    $vars['page_name'] = 'dashboard';

		$this->load->model ('Pengukurans');
		$vars['warning_signs'] = $this->Pengukurans->getWarningSigns ();

		$this->loadview('index', $vars);
	}

}