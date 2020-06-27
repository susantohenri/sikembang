<?php defined('BASEPATH') or exit('No direct script access allowed');

class Imunisasis extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'imunisasi';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tanggal', 'sTitle' => 'Tanggal'),

    );
    $this->form = array(
      array(
        'name' => 'tanggal',
        'label' => 'Tanggal',
        'width' => 2,
        'attributes' => array(
          array('data-date' => 'datepicker')
        )
      ),
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('imunisasi.tanggal');
    return parent::dt();
  }
}
