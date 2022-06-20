<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pendonor extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Pendonors';
		parent::__construct();
	}
}
