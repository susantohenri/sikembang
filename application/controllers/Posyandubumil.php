<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posyandubumil extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Posyandubumils';
		$this->page_title = 'Posyandu Ibu Hamil';
		parent::__construct();
	}
}
