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

  function bb($jenis_kelamin, $tgl_lahir, $bb, $retrieveDate)
  {
    $retrieveDate = is_null($retrieveDate) ? 'CURRENT_DATE' : "'{$retrieveDate}'";
    $bb = str_replace(',', '.', $bb);
    $found = $this->db->query("
        SELECT
          hasil,
          CASE
            WHEN hasil = 'Sangat Kurang' THEN 'red'
            WHEN hasil = 'Kurang' OR hasil = 'Resiko Berlebih' THEN 'orange'
            ELSE 'green'
          END color
        FROM antropometri
        WHERE nama = 'Berat Badan {$jenis_kelamin}'
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 <= usia_max
        AND {$bb} >= bb_min
        AND {$bb} <= bb_max
      ")
      ->row_array();
    return $found ? json_encode($found) : '{"hasil": "Formula tidak ditemukan", "color": "black"}';
  }

  function tb($jenis_kelamin, $tgl_lahir, $tb, $retrieveDate)
  {
    $retrieveDate = is_null($retrieveDate) ? 'CURRENT_DATE' : "'{$retrieveDate}'";
    $tb = str_replace(',', '.', $tb);
    $found = $this->db->query("
        SELECT 
          hasil,
          CASE
            WHEN hasil = 'Sangat Pendek' THEN 'red'
            WHEN hasil = 'Pendek' OR hasil = 'Tinggi' THEN 'orange'
            ELSE 'green'
          END color
        FROM antropometri
        WHERE nama = 'Tinggi Badan {$jenis_kelamin}'
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 <= usia_max
        AND FLOOR(({$tb} / 0.5) * 0.5) >= tb_min
        AND FLOOR(({$tb} / 0.5) * 0.5) <= tb_max
      ")
      ->row_array();
    return $found ? json_encode($found) : '{"hasil": "Formula tidak ditemukan", "color": "black"}';
  }

  function gizi($jenis_kelamin, $tgl_lahir, $bb, $tb, $retrieveDate)
  {
    $retrieveDate = is_null($retrieveDate) ? 'CURRENT_DATE' : "'{$retrieveDate}'";
    $bb = str_replace(',', '.', $bb);
    $tb = str_replace(',', '.', $tb);
    $found = $this->db->query("
        SELECT
          hasil,
          CASE
            WHEN hasil = 'Gizi Buruk' OR hasil = 'Obesitas' THEN 'red'
            WHEN hasil = 'Gizi Kurang' OR hasil = 'Gizi Lebih' THEN 'orange'
            ELSE 'green'
          END color
        FROM antropometri
        WHERE nama = 'Gizi {$jenis_kelamin}'
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 >= usia_min
        AND DATEDIFF({$retrieveDate}, '{$tgl_lahir}') / 30 <= usia_max
        AND FLOOR(({$tb} / 0.5) * 0.5) >= tb_min
        AND FLOOR(({$tb} / 0.5) * 0.5) <= tb_max
        AND {$bb} >= bb_min
        AND {$bb} <= bb_max
      ")
      ->row_array();
    return $found ? json_encode($found) : '{"hasil": "Formula tidak ditemukan", "color": "black"}';
  }
}
