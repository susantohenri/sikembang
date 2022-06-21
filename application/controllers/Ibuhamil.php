<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ibuhamil extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Ibuhamils';
		$this->page_title = 'Ibu Hamil';
		parent::__construct();
	}
}
