<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends MY_Controller {

	function __construct ()
	{
		$this->model = 'Artikels';
		parent::__construct();
	}

}