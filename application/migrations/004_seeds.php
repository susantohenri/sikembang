<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_seeds extends CI_Migration {

  function up () {
  	$this->load->model(array('Users', 'Roles', 'Permissions'));
  	$admin = $this->Roles->create(array('name' => 'admin'));
    foreach (array('index', 'create', 'read', 'update', 'delete') as $action)
    {
      $this->Permissions->create(array(
        'role' => $admin,
        'action' => $action,
        'entity' => 'User'
      ));
    }
    $this->Users->create(array(
  		'username' => 'admin',
  		'password' => md5('admin'),
  		'role' => $admin
  	));
  }

  function down () {

  }

}