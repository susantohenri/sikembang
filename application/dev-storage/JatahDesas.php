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
        kemampuan.prosentase,
        (SELECT COUNT(`uuid`) FROM jamaah WHERE kemampuan = kemampuan.`uuid`) jamaah_sekemampuan
      FROM jamaah
      LEFT JOIN kemampuan ON jamaah.kemampuan = kemampuan.uuid
    ")->result();
    foreach ($collectJamaah as $jamaah)
    {
      $strukUuid = $this->Struks->create(array(
        'jamaah' => $jamaah->uuid,
        'jatahdesa' => $jatahDesaUuid
      ));
      foreach ($this->JatahDesaDetails->find(array('jatahdesa' => $jatahDesaUuid)) as $detail) {
       $this->StrukDetails->create(array(
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