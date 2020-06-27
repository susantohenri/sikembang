<?php defined('BASEPATH') or exit('No direct script access allowed');

class Artikels extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'artikel';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'gambar', 'sTitle' => 'Gambar'),

    );
    $this->form = array(
      array(
        'name' => 'gambar',
        'width' => 2,
        'label' => 'Gambar',
      ),
      array(
        'name' => 'judul',
        'width' => 2,
        'label' => 'Judul',
      ),
      array(
        'name' => 'konten',
        'width' => 2,
        'label' => 'Konten',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('artikel.gambar');
    return parent::dt();
  }
}
