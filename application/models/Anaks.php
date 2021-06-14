<?php defined('BASEPATH') or exit('No direct script access allowed');

class Anaks extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'anak';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'anak', 'sTitle' => 'Anak'),
			(object) array('mData' => 'desa', 'sTitle' => 'Desa'),
			(object) array('mData' => 'posyandu', 'sTitle' => 'Posyandu'),
		);
		$this->form = array(
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
				'name' => 'posyandu',
				'label' => 'Posyandu',
				'width' => 2,
				'options' => array(),
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Posyandus'),
					array('data-field' => 'nama')
				)
			),
			array(
				'name' => 'no_kk',
				'width' => 2,
				'label' => 'No KK',
			),
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
				'name' => 'tb_lahir',
				'width' => 2,
				'label' => 'Panjang Badan Lahir',
			),
			array(
				'name' => 'nama_ayah',
				'width' => 2,
				'label' => 'Nama Ayah',
			),
			array(
				'name' => 'nama_ibu',
				'width' => 2,
				'label' => 'Nama Ibu',
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
				'name' => 'bpjs',
				'label' => 'Kepemilikan BPJS',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
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

	function findOneWithUsia($uuid, $retrieveDate)
	{
		return $this
			->db
			->select('*')
			->select("DATEDIFF('{$retrieveDate}', tgl_lahir) / 30 AS usia", false)
			->where('uuid', $uuid)
			->get($this->table)
			->row_array();
	}

	function select2($field, $term)
	{
		$this->load->model('Roles');
		$role = $this->Roles->findOne($this->session->userdata('role'));
		if ('Kader' === $role['name']) {
			$this->db->where('posyandu', $this->session->userdata('posyandu'));
		}

		$retrieveDate = $this->input->post('createdAt');

		return $this->db
			->select("uuid as id", false)
			->select("$field as text", false)
			->where("DATEDIFF('{$retrieveDate}', tgl_lahir) / 30 <= ", 60, false)
			->where("DATEDIFF('{$retrieveDate}', tgl_lahir) / 30 >= ", 0, false)
			->where("uuid NOT IN (SELECT anak FROM pengukuran WHERE DATE_FORMAT(pengukuran.createdAt, '%m-%Y') = DATE_FORMAT('{$retrieveDate}', '%m-%Y'))")
			->limit(10)
			->like($field, $term)->get($this->table)->result();
	}

	function dt()
	{
		return $this->datatables
		->select('uuid')
		->select('orders')
		->select('anak')
		->select('desa')
		->select('posyandu')
		->from("(
			SELECT
				{$this->table}.uuid,
				{$this->table}.orders,
				{$this->table}.nama anak,
				desa.nama desa,
				posyandu.nama posyandu
			FROM {$this->table}
			LEFT JOIN desa ON {$this->table}.desa = desa.uuid
			LEFT JOIN posyandu ON {$this->table}.posyandu = posyandu.uuid
		) anakDesaPosyandu")
		->generate();
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

	function download($desa)
	{
		$no = 0;
		return array_map(function ($record) use (&$no) {
			$no++;
			return array(
				'No' => $no,
				'NAMA ANAK' => $record->nama,
				'NIK (Nomor Induk Kependudukan)' => $record->nik,
				'No. KK' => $record->no_kk,
				'ANAK KE' => $record->anak_ke,
				'TANGGAL LAHIR' => $record->tgl_lahir,
				'POSYANDU' => $record->nama_posyandu,
				'JENIS KELAMIN' => $record->jenis_kelamin,
				'Berat Badan Lahir (Kg)' => $record->bb_lahir,
				'Panjang Badan Lahir (Cm)' => $record->tb_lahir,
				'Nama Ayah' => $record->nama_ayah,
				'Nama Ibu' => $record->nama_ibu,
				'ALAMAT' => $record->alamat,
				'RT' => $record->rt,
				'RW' => $record->rw,
				'Umur (bulan)' => $record->usia
			);
		}, $this->db
			->select('anak.*')
			->select('posyandu.nama nama_posyandu', false)
			->select("FLOOR(DATEDIFF({$this->table}.createdAt, tgl_lahir) / 30) AS usia", false)
			->join('posyandu', 'anak.posyandu = posyandu.uuid', 'left')
			->where('anak.desa', $desa)
			->get('anak')
			->result());
	}
}
