<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bidan extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Bidans';
		parent::__construct();
	}

}