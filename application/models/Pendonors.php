<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pendonors extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'pendonor';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama', 'sTitle' => 'Nama'),
      (object) array('mData' => 'alamat', 'sTitle' => 'Alamat'),
      (object) array('mData' => 'nomor_telepon', 'sTitle' => 'No. Telepon'),

    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
      array(
        'name' => 'golongan_darah',
        'width' => 2,
        'label' => 'Golongan Darah',
      ),
      array(
        'name' => 'alamat',
        'width' => 2,
        'label' => 'Alamat',
      ),
      array(
        'name' => 'nomor_kk',
        'width' => 2,
        'label' => 'No. KK',
      ),
      array(
        'name' => 'NIK',
        'width' => 2,
        'label' => 'NIK',
      ),
      array(
        'name' => 'nomor_telepon',
        'width' => 2,
        'label' => 'No. Telepon',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('pendonor.nama')
      ->select('pendonor.alamat')
      ->select('pendonor.nomor_telepon');
    return parent::dt();
  }
}
