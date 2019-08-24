<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'role';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'name', 'sTitle' => 'Role'),
    );
    $this->form = array (
      array (
	      'name' => 'name',
	      'label'=> 'Role Name',
		  ),
    );

    $this->childs[] = array('label' => 'Role Menu', 'controller' => 'Menu', 'model' => 'Menus');
    $this->childs[] = array('label' => 'Role Permission', 'controller' => 'Permission', 'model' => 'Permissions');

  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select("{$this->table}.name");
    return parent::dt();
  }

}