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
      (object) array('mData' => 'keterangan', 'sTitle' => 'Keterangan'),

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
        'name' => 'umur_kehamilan',
        'width' => 2,
        'label' => 'Umur Kehamilan',
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
        'name' => 'tensi',
        'width' => 2,
        'label' => 'Tensi',
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
      ->select('posyandubumil.keterangan')
      ->join('ibuhamil', 'posyandubumil.ibuhamil = ibuhamil.uuid', 'left');
    return parent::dt();
  }

  function save($record)
  {
    foreach ($record as $field => &$value) {
      if (is_array($value)) $value = implode(',', $value);
      else if (strpos($value, '[comma-replacement]') > -1) $value = str_replace('[comma-replacement]', ',', $value);
    }
    $record['keterangan'] = 'NORMAL';
    if ($record['lingkar_lengan_atas'] && $record['lingkar_lengan_atas'] < 23.5) $record['keterangan'] = 'KEK';
    if ($record['berat_badan'] && $record['berat_badan'] < 45) $record['keterangan'] = 'KEK';
    return isset($record['uuid']) ? $this->update($record) : $this->create($record);
  }

	function download()
	{
		$no = 0;
		return array_map(function ($record) use (&$no) {
			$no++;
			return array(
				'No' => $no,
				'Tanggal Pemeriksaan' => $record->tanggal_pemeriksaan,
				'Nama Ibu Hamil' => $record->nama_ibuhamil,
				'Keterangan' => $record->keterangan,
			);
		}, $this->db
			->select('posyandubumil.tanggal_pemeriksaan')
			->select('ibuhamil.nama_ibuhamil')
			->select('posyandubumil.keterangan')
			->join('ibuhamil', 'posyandubumil.ibuhamil = ibuhamil.uuid', 'left')
			->get('posyandubumil')
			->result());
	}
}
