<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct ()
	{
		$this->page_title = 'User Management';
		parent::__construct();
	}

}