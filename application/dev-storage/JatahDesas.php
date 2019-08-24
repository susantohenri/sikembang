<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JatahDesas extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = 'jatahdesa';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      (object) array('mData' => 'tanggal', 'sTitle' => 'Tanggal'),

    );
    $this->form = array (
        array (
		      'name' => 'tanggal',
		      'label'=> 'Tanggal',
		      'width' => 2,
		      'attributes' => array(
		        array('data-date' => 'datepicker')
			    )),
    );
    $this->childs = array (
        array (
				      'label' => 'Detail',
				      'controller' => 'JatahDesaDetail',
				      'model' => 'JatahDesaDetails'
					  ),
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      ->select('jatahdesa.tanggal');
    return parent::dt();
  }

  function create ($data)
  {
    $created = $jatahDesaUuid = parent::create($data);
    $this->generateStruk($jatahDesaUuid);
    return $created;
  }

  function update ($data)
  {
    $updated = parent::update($data);
    $this->cleanUpStruk($updated);
    $this->generateStruk($updated);
    return $updated;
  }

  function delete ($uuid)
  {
    $deleted = parent::delete($uuid);
    $this->cleanUpStruk($uuid);
    return $deleted;
  }

  function generateStruk ($jatahDesaUuid)
  {
    $this->load->model(array('Struks', 'JatahDesaDetails', 'StrukDetails'));
    $collectJamaah = $this->db->query("
      SELECT
        jamaah.uuid,
        jamaah.posisi,
        kemampuan.prosentase,
        (SELECT COUNT(`uuid`) FROM jamaah WHERE kemampuan = kemampuan.`uuid`) jamaah_sekemampuan,
        (SELECT COUNT(`uuid`) FROM jamaah WHERE posisi = 'Kepala Keluarga') jumlah_kk
      FROM jamaah
      LEFT JOIN kemampuan ON jamaah.kemampuan = kemampuan.uuid
    ")->result();
    foreach ($collectJamaah as $jamaah)
    {
      $strukUuid = $this->Struks->create(array(
        'jamaah' => $jamaah->uuid,
        'jatahdesa' => $jatahDesaUuid
      ));
      $jatahdesadetail = $this->db->query("
        SELECT
          jatahdesadetail.*
          , infaq.kk
        FROM jatahdesadetail
        LEFT JOIN infaq ON jatahdesadetail.infaq = infaq.`uuid`
        WHERE jatahdesa = '{$jatahDesaUuid}'
      ")->result();
      foreach ($jatahdesadetail as $detail) {
        if ('Ya' === $detail->kk)
        {
          if ('Kepala Keluarga' === $jamaah->posisi) $this->StrukDetails->create(array(
            'struk' => $strukUuid,
            'jatahdesadetail' => $detail->uuid,
            'dijatah' => $detail->nominal / $jamaah->jumlah_kk
          ));
          else continue;
        }
        else $this->StrukDetails->create(array(
          'struk' => $strukUuid,
          'jatahdesadetail' => $detail->uuid,
          'dijatah' => $jamaah->prosentase / 100 * $detail->nominal / $jamaah->jamaah_sekemampuan
        ));
      }
    }
  }

  function cleanUpStruk ($jatahDesaUuid)
  {
    $this->load->model('Struks');
    foreach ($this->Struks->find(array('jatahdesa' => $jatahDesaUuid)) as $struk)
    {
      $this->Struks->delete($struk->uuid);
    }
  }

}