<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posyandubumils extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'posyandubumil';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tanggal_pemeriksaan', 'sTitle' => 'Tanggal Pemeriksaan'),
      (object) array('mData' => 'nama_ibuhamil', 'sTitle' => 'Nama Ibu Hamil'),

    );

    $this->form = array(
      array(
        'name' => 'tanggal_pemeriksaan',
        'width' => 2,
        'label' => 'Tanggal Pemeriksaan',
        'value' => date('Y-m-d'),
        'attributes' => array(
            array('data-date' => 'datepicker'),
        )
      ),
      array(
        'name' => 'ibuhamil',
        'label' => 'Ibu Hamil',
        'options' => array(),
        'width' => 2,
        'attributes' => array(
            array('data-autocomplete' => 'true'),
            array('data-model' => 'Ibuhamils'),
            array('data-field' => 'nama_ibuhamil'),
        )
      ),
      array(
        'name' => 'lingkar_lengan_atas',
        'width' => 2,
        'label' => 'Lingkar Lengan Atas',
      ),
      array(
        'name' => 'berat_badan',
        'width' => 2,
        'label' => 'Berat Badan',
      ),
      array(
        'name' => 'checklist_tablet_tambah_darah',
        'width' => 2,
        'label' => 'Checklist Tablet Penambah Darah',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('posyandubumil.tanggal_pemeriksaan')
      ->select('ibuhamil.nama_ibuhamil')
      ->join('ibuhamil', 'posyandubumil.ibuhamil = ibuhamil.uuid', 'left');
    return parent::dt();
  }
}
