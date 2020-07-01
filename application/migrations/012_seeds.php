<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_seeds extends CI_Migration
{

  function up()
  {
    $this->load->model(array('Users', 'Roles', 'Permissions', 'Menus'));
    $fas = array('database', 'desktop', 'download', 'ethernet', 'hdd', 'hdd', 'headphones', 'keyboard', 'keyboard', 'laptop', 'memory', 'microchip', 'mobile', 'mobile-alt', 'plug', 'power-off', 'print', 'satellite', 'satellite-dish', 'save', 'save', 'sd-card', 'server', 'sim-card', 'stream', 'tablet', 'tablet-alt', 'tv', 'upload');
    $admin = $this->Roles->create(array('name' => 'Bidan'));
    $kader = $this->Roles->create(array('name' => 'Kader'));

    $menu_icon = array(
      'User' => 'user-circle',
      'Anak' => 'child',
      'Pengukuran' => 'balance-scale',
      'Artikel' => 'copy',
      'Imunisasi' => 'calendar',
      'Bidan' => 'user-md',
      'Faskes' => 'hospital'
    );

    // BIDAN BEGIN
    foreach (array('User', 'Role', 'Permission', 'Menu', 'Anak', 'Pengukuran', 'Artikel', 'Antropometri', 'Imunisasi', 'Bidan', 'Faskes'/*additionalEntity*/) as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
        $this->Permissions->create(array(
          'role' => $admin,
          'action' => $action,
          'entity' => $entity
        ));
      }

      if (in_array($entity, array_keys($menu_icon))) {
        $this->Menus->create(array(
          'role' => $admin,
          'name' => $entity,
          'url' => $entity,
          'icon' => $menu_icon[$entity]
        ));
      }
    }

    $this->Users->create(array(
      'username' => 'admin',
      'password' => md5('admin'),
      'role' => $admin
    ));

    $this->Permissions->create(array(
      'role' => $admin,
      'action' => 'index',
      'entity' => 'WarningSign'
    ));
    $this->Permissions->create(array(
      'role' => $admin,
      'action' => 'delete',
      'entity' => 'WarningSign'
    ));
    // BIDAN END

    // KADER BEGIN
    $this->Users->create(array(
      'username' => 'kader',
      'password' => md5('kader'),
      'role' => $kader
    ));

    foreach (array('Anak', 'Pengukuran') as $entity) {
      foreach (array('index', 'create', 'read', 'update', 'delete')  as $action) {
        $this->Permissions->create(array(
          'role' => $kader,
          'action' => $action,
          'entity' => $entity
        ));
      }

      if (in_array($entity, array_keys($menu_icon))) {
        $this->Menus->create(array(
          'role' => $kader,
          'name' => $entity,
          'url' => $entity,
          'icon' => $menu_icon[$entity]
        ));
      }
    }
    // KADER END
  }

  function down()
  {
  }
}
