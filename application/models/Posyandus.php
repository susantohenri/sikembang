<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posyandus extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'posyandu';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'posyandu', 'sTitle' => 'Posyandu'),
      (object) array('mData' => 'desa', 'sTitle' => 'Desa'),
    );
    $this->form = array(
      array(
        'name' => 'nama',
        'width' => 2,
        'label' => 'Nama',
      ),
      array(
        'name' => 'desa',
        'label' => 'Desa',
        'width' => 2,
        'options' => array(),
        'attributes' => array(
          array('data-autocomplete' => 'true'),
          array('data-model' => 'Desas'),
          array('data-field' => 'nama')
        )
      ),
      array(
        'name' => 'alamat',
        'width' => 2,
        'label' => 'Alamat',
      ),
      array(
        'name' => 'provinsi',
        'width' => 2,
        'label' => 'Provinsi',
      ),
      array(
        'name' => 'kabupaten_kota',
        'width' => 2,
        'label' => 'Kabupaten / Kota',
      ),
      array(
        'name' => 'puskesmas_kecamatan',
        'width' => 2,
        'label' => 'Puskesmas / Kecamatan',
				'options' => array(
          array('value' => '', 'text' => ''),
          array('value' => 'Ampel', 'text' => 'Ampel'),
          array('value' => 'Banyudono', 'text' => 'Banyudono'),
          array('value' => 'Cepogo', 'text' => 'Cepogo'),
        ),
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
    return $this->datatables
      ->select('uuid')
      ->select('orders')
      ->select('posyandu')
      ->select('desa')
      ->from("
      (
        SELECT
          posyandu.uuid
          , posyandu.orders
          , posyandu.nama posyandu
          , desa.nama desa
        FROM posyandu
        LEFT JOIN desa ON posyandu.desa = desa.uuid
      ) posyanduDesa
      ")
      ->generate();
  }

  function select2($field, $term)
  {
    return $this->db
      ->select("uuid as id", false)
      ->select("$field as text", false)
      ->limit(11)
      ->like($field, $term)->get($this->table)->result();
  }

  function select2WithDesa($field, $term, $desa)
  {
    return $this->db
      ->select("uuid as id", false)
      ->select("$field as text", false)
      ->limit(11)
      ->where('desa', $desa)
      ->like($field, $term)->get($this->table)->result();
  }
}
