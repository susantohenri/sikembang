<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboards extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = '';
    $this->form = array();
  }
}
