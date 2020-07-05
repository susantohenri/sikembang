<?php defined('BASEPATH') or exit('No direct script access allowed');

class Anaks extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'anak';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'nama', 'sTitle' => 'Nama Anak'),
			(object) array('mData' => 'nama_ortu', 'sTitle' => 'Orang Tua'),
		);
		$this->form = array(
			array(
				'name' => 'nik',
				'width' => 2,
				'label' => 'NIK',
			),
			array(
				'name' => 'anak_ke',
				'width' => 2,
				'label' => 'Anak Ke',
			),
			array(
				'name' => 'nama',
				'width' => 2,
				'label' => 'Nama',
			),
			array(
				'name' => 'tgl_lahir',
				'label' => 'Tanggal Lahir',
				'width' => 2,
				'attributes' => array(
					array('data-date' => 'datepicker')
				)
			),
			array(
				'name' => 'jenis_kelamin',
				'label' => 'Jenis Kelamin',
				'width' => 2,
				'options' => array(
					array('text' => 'Lelaki', 'value' => 'Lelaki'),
					array('text' => 'Perempuan', 'value' => 'Perempuan'),
				)
			),
			array(
				'name' => 'bb_lahir',
				'width' => 2,
				'label' => 'Berat Badan Lahir',
			),
			array(
				'name' => 'nama_ortu',
				'width' => 2,
				'label' => 'Nama Orang Tua',
			),
			array(
				'name' => 'tlp_ortu',
				'width' => 2,
				'label' => 'Telepon Orang Tua',
			),
			array(
				'name' => 'alamat',
				'width' => 2,
				'label' => 'Alamat',
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
				'name' => 'imd',
				'label' => 'Inisiasi Menyusu Dini',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
		);
		$this->childs = array();
	}

	function findOne($param)
	{
		if (!is_array($param)) $param = array('uuid' => $param);
		return $this
			->db
			->select('*')
			->select("DATEDIFF(CURRENT_DATE, tgl_lahir) / 30 AS usia", false)
			->where($param)
			->get($this->table)
			->row_array();
	}

	function select2($field, $term)
	{
		return $this->db
			->select("uuid as id", false)
			->select("$field as text", false)
			->where('DATEDIFF(CURRENT_DATE, tgl_lahir) / 30 <= ', 60, false)
			->where("uuid NOT IN (SELECT anak FROM pengukuran WHERE DATE_FORMAT(pengukuran.createdAt, '%m-%Y') = DATE_FORMAT(CURRENT_DATE, '%m-%Y'))")
			->limit(10)
			->like($field, $term)->get($this->table)->result();
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select('anak.nama')
			->select('anak.nama_ortu');
		return parent::dt();
	}

	function imd()
	{
		$result = json_decode('{"type":"pie","data":{"datasets":[{"data":[100,2],"backgroundColor":["orange","lightblue"]}],"labels":["Ya","Tidak"]},"options":{"responsive":true}}');
		$records = $this->db
			->select('imd label', false)
			->select('COUNT(uuid) total', false)
			->group_by('imd')
			->get($this->table)
			->result();

		$result->data->datasets[0]->data = array_map(function ($record) {
			return $record->total;
		}, $records);

		$result->data->labels = array_map(function ($record) {
			return $record->label;
		}, $records);

		return json_encode($result);
	}
}
