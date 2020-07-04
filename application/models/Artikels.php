<?php defined('BASEPATH') or exit('No direct script access allowed');

class Artikels extends MY_Model
{

  function __construct()
  {
    parent::__construct();
    $this->table = 'artikel';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'judul', 'sTitle' => 'Judul'),

    );
    $this->form = array(
      array(
        'name' => 'gambar',
        'type' => 'file',
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
        'type' => 'textarea',
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
      ->select('artikel.judul');
    return parent::dt();
  }


  function save($record)
  {
    foreach ($record as $field => &$value) {
      if (is_array($value)) $value = implode(',', $value);
      else if (strpos($value, '[comma-replacement]') > -1) $value = str_replace('[comma-replacement]', ',', $value);
    }
    if (strlen($_FILES['gambar']['name']) > 0) {
      $oldfile = null;
      if (isset($record['uuid'])) {
        $artikel = self::findOne($record['uuid']);
        $oldfile = $artikel['gambar'];
      }
      $record['gambar'] = $this->fileupload ('carousel', $_FILES['gambar'], $oldfile);
    }
    return isset($record['uuid']) ? $this->update($record) : $this->create($record);
  }

  function delete($uuid)
  {
    foreach ($this->childs as $child) {
      $childmodel = $child['model'];
      $this->load->model($childmodel);
      foreach ($this->$childmodel->find(array($this->table => $uuid)) as $childrecord)
        $this->$childmodel->delete($childrecord->uuid);
    }
    $artikel = self::findOne($uuid);
    $this->fileupload ('', null, $artikel['gambar']);
    return $this->db->where('uuid', $uuid)->delete($this->table);
  }
}
