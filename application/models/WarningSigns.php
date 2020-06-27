<?php defined('BASEPATH') or exit('No direct script access allowed');

class WarningSigns extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'warningsign';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'pengukuran', 'sTitle' => 'Pengukuran'),

    );
    $this->form = array(
      array(
        'name' => 'pengukuran',
        'width' => 2,
        'label' => 'Pengukuran',
      ),
      array(
        'name' => 'done',
        'width' => 2,
        'label' => 'Done',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('warningsign.pengukuran');
    return parent::dt();
  }
}
