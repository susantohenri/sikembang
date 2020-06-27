<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anak extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Anaks';
		parent::__construct();
	}

}