<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'permission';
    $this->thead = array();
    $this->form = array(
      array (
        'name' => 'entity',
        'label'=> 'Entity',
        'width' => 4
      ),
      array (
        'name' => 'action',
        'label'=> 'Action',
        'options' => array(
          array ('text' => 'index', 'value' => 'index'),
          array ('text' => 'create', 'value' => 'create'),
          array ('text' => 'read', 'value' => 'read'),
          array ('text' => 'update', 'value' => 'update'),
          array ('text' => 'delete', 'value' => 'delete')
        ),
        'width' => 4
      ),
    );
  }

  function getPermissions () {
    $permission = array();
    foreach ($this->find(array('role' => $this->session->userdata('role'))) as $perm) $permission[] = "{$perm->action}_{$perm->entity}";
    return $permission;
  }

  function getPermittedMenus () {

  }
}