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
      (object) array('mData' => 'no_tlp_ibuhamil', 'sTitle' => 'No. Telepon Ibu Hamil'),

    );

    $this->form = array(
      array(
        'name' => 'nama_ibuhamil',
        'width' => 2,
        'label' => 'Nama Ibu Hamil',
      ),
      array(
        'name' => 'nik_ibuhamil',
        'width' => 2,
        'label' => 'NIK Ibu Hamil',
      ),
      array(
        'name' => 'ttl_ibuhamil',
        'width' => 2,
        'label' => 'Tempat Tanggal Lahir Ibu Hamil',
      ),
      array(
        'name' => 'agama_ibuhamil',
        'width' => 2,
        'label' => 'Agama Ibu Hamil',
      ),
      array(
        'name' => 'pekerjaan_ibuhamil',
        'width' => 2,
        'label' => 'Pekerjaan Ibu Hamil',
      ),
      array(
        'name' => 'pendidikan_terakhir_ibuhamil',
        'width' => 2,
        'label' => 'Pendidikan Terakhir Ibu Hamil',
      ),
      array(
        'name' => 'no_tlp_ibuhamil',
        'width' => 2,
        'label' => 'Nomor Telepon Ibu Hamil',
      ),
      array(
        'name' => 'golongan_darah_ibuhamil',
        'width' => 2,
        'label' => 'Golongan Darah Ibu Hamil',
      ),
      array(
        'name' => 'no_bpjs',
        'width' => 2,
        'label' => 'Nomor BPJS',
      ),

      array(
        'name' => 'nama_suami',
        'width' => 2,
        'label' => 'Nama Suami',
      ),
      array(
        'name' => 'nik_suami',
        'width' => 2,
        'label' => 'NIK Suami',
      ),
      array(
        'name' => 'ttl_suami',
        'width' => 2,
        'label' => 'Tempat Tanggal Lahir Suami',
      ),
      array(
        'name' => 'agama_suami',
        'width' => 2,
        'label' => 'Agama Suami',
      ),
      array(
        'name' => 'pekerjaan_suami',
        'width' => 2,
        'label' => 'Pekerjaan Suami',
      ),
      array(
        'name' => 'pendidikan_terakhir_suami',
        'width' => 2,
        'label' => 'Pendidikan Terakhir Suami',
      ),
      array(
        'name' => 'no_tlp_suami',
        'width' => 2,
        'label' => 'Nomor Telepon Suami',
      ),
      array(
        'name' => 'golongan_darah_suami',
        'width' => 2,
        'label' => 'Golongan Darah Suami',
      ),

      array(
        'name' => 'alamat',
        'width' => 2,
        'label' => 'Alamat',
      ),
      array(
        'name' => 'dukuh',
        'width' => 2,
        'label' => 'Dukuh',
      ),
      array(
        'name' => 'rt',
        'width' => 2,
        'label' => 'RT',
      ),
      array(
        'name' => 'rw',
        'width' => 2,
        'label' => 'RW',
      ),
      array(
        'name' => 'nomor_kk',
        'width' => 2,
        'label' => 'Nomor KK',
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
        'name' => 'kb_terakhir',
        'width' => 2,
        'label' => 'KB Terakhir',
      ),
      array(
        'name' => 'penolong_kelahiran_sebelumnya',
        'width' => 2,
        'label' => 'Penolong Kelahiran Sebelumnya',
      ),
      array(
        'name' => 'tinggi_badan',
        'width' => 2,
        'label' => 'Tinggi Badan',
      ),
      array(
        'name' => 'berat_badan',
        'width' => 2,
        'label' => 'Berat Badan',
      ),
      array(
        'name' => 'lingkar_lengan_atas',
        'width' => 2,
        'label' => 'Lingkar Lengan Atas',
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
      ->select('ibuhamil.no_tlp_ibuhamil');
    return parent::dt();
  }
}
