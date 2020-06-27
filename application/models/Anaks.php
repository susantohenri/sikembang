<?php defined('BASEPATH') or exit('No direct script access allowed');

class Anaks extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'anak';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'nik', 'sTitle' => 'NIK'),

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
					array('text' => 'Ya', 'value' => 'Ya'),
					array('text' => 'Tidak', 'value' => 'Tidak'),
				)
			),
		);
		$this->childs = array();
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select('anak.nik');
		return parent::dt();
	}
}