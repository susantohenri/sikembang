<?php defined('BASEPATH') or exit('No direct script access allowed');

class Faskess extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'faskes';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
      array(
        'name' => 'alamat',
        'width' => 2,
        'label' => 'Alamat',
      ),
      array(
        'name' => 'telepon',
        'width' => 2,
        'label' => 'Telepon',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('faskes.nama');
    return parent::dt();
  }
}
