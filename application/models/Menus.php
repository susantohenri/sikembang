<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menus extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'menu';
    $this->form = array(
      array(
        'name' => 'name',
        'width' => 3,
        'label' => 'Name',
      ),
      array(
        'name' => 'url',
        'width' => 2,
        'label' => 'URL',
      ),
      array(
        'name' => 'icon',
        'width' => 2,
        'label' => 'Icon',
      ),
    );
  }

  function getImunisasi () {
    $files = scandir ('imunisasi');
    $images = array_filter ($files, function ($file) {
      return !in_array ($file, array ('.', '..'));
    });
    return $images[0] || '';
  }

}
