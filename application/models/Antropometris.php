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

  function bb($jenis_kelamin, $tgl_lahir, $bb, $tb)
  {
    $found = $this->db->query("
        SELECT hasil
        FROM antropometri
        WHERE nama = 'Berat Badan {$jenis_kelamin}'
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 <= usia_max
        AND {$bb} >= bb_min
        AND {$bb} <= bb_max
      ")
      ->row_array();
    return $found ? $found['hasil'] : 'Formula tidak ditemukan';
  }

  function tb($jenis_kelamin, $tgl_lahir, $bb, $tb)
  {
    $found = $this->db->query("
        SELECT hasil
        FROM antropometri
        WHERE nama = 'Tinggi Badan {$jenis_kelamin}'
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 <= usia_max
        AND FLOOR(({$tb} / 0.5) * 0.5) >= tb_min
        AND FLOOR(({$tb} / 0.5) * 0.5) <= tb_max
      ")
      ->row_array();
    return $found ? $found['hasil'] : 'Formula tidak ditemukan';
  }

  function gizi($jenis_kelamin, $tgl_lahir, $bb, $tb)
  {
    $found = $this->db->query("
        SELECT hasil
        FROM antropometri
        WHERE nama = 'Gizi {$jenis_kelamin}'
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF(CURRENT_DATE, '{$tgl_lahir}') / 30 <= usia_max
        AND FLOOR(({$tb} / 0.5) * 0.5) >= tb_min
        AND FLOOR(({$tb} / 0.5) * 0.5) <= tb_max
        AND {$bb} >= bb_min
        AND {$bb} <= bb_max
      ")
      ->row_array();
    return $found ? $found['hasil'] : 'Formula tidak ditemukan';
  }
}
