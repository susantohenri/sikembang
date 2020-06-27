<?php defined('BASEPATH') or exit('No direct script access allowed');

class Antropometris extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'antropometri';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'item', 'sTitle' => 'Item'),

    );
    $this->form = array(
      array(
        'name' => 'item',
        'width' => 2,
        'label' => 'Item',
      ),
      array(
        'name' => 'usia',
        'width' => 2,
        'label' => 'Usia',
      ),
      array(
        'name' => 'minimal',
        'width' => 2,
        'label' => 'Minimal',
      ),
      array(
        'name' => 'maksimal',
        'width' => 2,
        'label' => 'Maksimal',
      ),
      array(
        'name' => 'hasil',
        'width' => 2,
        'label' => 'Hasil',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('antropometri.item');
    return parent::dt();
  }
}
