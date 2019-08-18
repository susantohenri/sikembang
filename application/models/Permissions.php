<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'permission';
    $this->form = array();
    $this->thead = array();
  }

  function getPermissions () {
    $permission = array();
    foreach ($this->find(array('role' => $this->session->userdata('role'))) as $perm) $permission[] = "{$perm->action}_{$perm->entity}";
    return $permission;
  }

  function getPermittedMenus () {

  }
}