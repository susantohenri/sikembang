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
      if (isset($record['uuid'])) {
        $artikel = self::findOne($record['uuid']);
        self::deleteFile($artikel['gambar']);
      }
      $record['gambar'] = self::saveFile('gambar', time());
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
    self::deleteFile($artikel['gambar']);
    return $this->db->where('uuid', $uuid)->delete($this->table);
  }

  private function fileIsPhoto($field_name)
  {
    if (getimagesize($_FILES[$field_name]['tmp_name'])) return true;
    else return false;
  }

  private function saveFile($field_name, $unique)
  {
    if (!$this->fileIsPhoto($field_name)) return false;
    $extension = strtolower(pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION));
    $new_file_location = "carousel/{$field_name}_{$unique}.{$extension}";
    self::deleteFile($new_file_location);
    move_uploaded_file($_FILES[$field_name]['tmp_name'], $new_file_location);
    return $new_file_location;
  }

  private function deleteFile($path)
  {
    if (file_exists($path)) unlink($path);
  }
}
