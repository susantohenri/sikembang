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
	    $vars['page_name'] = 'dashboard';
	    $this->loadview('index', $vars);
	}

}