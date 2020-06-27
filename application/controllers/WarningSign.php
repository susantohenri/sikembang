<?php defined('BASEPATH') OR exit('No direct script access allowed');

class WarningSign extends MY_Controller {

	function __construct ()
	{
		$this->model = 'WarningSigns';
		parent::__construct();
	}

}