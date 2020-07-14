<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posyandus extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'posyandu';
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
      ->select('posyandu.nama');
    return parent::dt();
  }

  function select2($field, $term)
  {
    return $this->db
      ->select("uuid as id", false)
      ->select("$field as text", false)
      ->limit(11)
      ->like($field, $term)->get($this->table)->result();
  }

}
