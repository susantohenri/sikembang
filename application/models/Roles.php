<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'role';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
    );
    $this->form = array (
        array (
		      'name' => 'name',
		      'label'=> 'Role Name',
			  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders");
    return parent::dt();
  }

}