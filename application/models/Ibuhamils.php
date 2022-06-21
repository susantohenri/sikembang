<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ibuhamils extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'ibuhamil';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'nama_ibuhamil', 'sTitle' => 'Nama'),
      (object) array('mData' => 'alamat', 'sTitle' => 'Alamat'),
      (object) array('mData' => 'nomor_telepon', 'sTitle' => 'No. Telepon'),

    );
    $this->form = array(
      array(
        'name' => 'nama_ibuhamil',
        'width' => 2,
        'label' => 'Nama Ibu Hamil',
      ),
      array(
        'name' => 'nama_suami',
        'width' => 2,
        'label' => 'Nama Suami',
      ),
      array(
        'name' => 'tanggal_lahir',
        'width' => 2,
        'label' => 'Tanggal Lahir',
        'attributes' => array(
            array('data-date' => 'datepicker')
        )
      ),
      array(
        'name' => 'pekerjaan',
        'width' => 2,
        'label' => 'Pekerjaan',
      ),
      array(
        'name' => 'pendidikan_terakhir',
        'width' => 2,
        'label' => 'Pendidikan Terakhir',
      ),
      array(
        'name' => 'agama',
        'width' => 2,
        'label' => 'Agama',
      ),
      array(
        'name' => 'nomor_bpjs',
        'width' => 2,
        'label' => 'Nomor BPJS',
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
        'name' => 'nik_ibuhamil',
        'width' => 2,
        'label' => 'NIK Ibu Hamil',
      ),
      array(
        'name' => 'nik_suami',
        'width' => 2,
        'label' => 'NIK Suami',
      ),
      array(
        'name' => 'nomor_telepon',
        'width' => 2,
        'label' => 'Nomor Telepon',
      ),
      array(
        'name' => 'golongan_darah',
        'width' => 2,
        'label' => 'Golongan Darah',
      ),
      array(
        'name' => 'hamil_ke',
        'width' => 2,
        'label' => 'Hamil Ke',
      ),
      array(
        'name' => 'usia_anak_terakhir',
        'width' => 2,
        'label' => 'Usia Anak Terakhir',
      ),
      array(
        'name' => 'hpht',
        'width' => 2,
        'label' => 'HPHT',
      ),
      array(
        'name' => 'umur_kehamilan',
        'width' => 2,
        'label' => 'Umur Kehamilan',
      ),
      array(
        'name' => 'tinggi_badan',
        'width' => 2,
        'label' => 'Tinggi Badan',
      ),
    );
    $this->childs = array();
  }

  function dt()
  {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('ibuhamil.nama_ibuhamil')
      ->select('ibuhamil.alamat')
      ->select('ibuhamil.nomor_telepon');
    return parent::dt();
  }
}
