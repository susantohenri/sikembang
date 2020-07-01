<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengukurans extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'pengukuran';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
			(object) array('mData' => 'createdAt', 'sTitle' => 'Waktu'),
			(object) array('mData' => 'anak', 'sTitle' => 'Anak'),
		);

		$createPengukuran = site_url('Pengukuran/create/');
		$this->form = array(
			array(
				'name' => 'anak',
				'label' => 'Anak',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Anaks'),
					array('data-field' => 'nama'),
					array('onchange' => "window.location = '{$createPengukuran}' + $(this).val() ")
				)
			),
			array(
				'name' => 'bb',
				'width' => 2,
				'label' => 'Berat Badan',
			),
			array(
				'name' => 'tb',
				'width' => 2,
				'label' => 'Tinggi Badan',
			),
			array(
				'name' => 'asi_eksklusif',
				'label' => 'ASI Eksklusif',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'garam_yodium',
				'label' => 'Garam Yodium',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'vit_a_feb',
				'label' => 'Vitamin A Februari',
				'width' => 2,
				'options' => array(
					array('text' => 'Ya', 'value' => 'Ya'),
					array('text' => 'Tidak', 'value' => 'Tidak'),
				)
			),
			array(
				'name' => 'vit_a_aug',
				'label' => 'Vitamin A Agustus',
				'width' => 2,
				'options' => array(
					array('text' => 'Ya', 'value' => 'Ya'),
					array('text' => 'Tidak', 'value' => 'Tidak'),
				)
			),
			array(
				'name' => 'hasil_bb',
				'width' => 2,
				'label' => 'Hasil Berat Badan',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'hasil_tb',
				'width' => 2,
				'label' => 'Hasil Tinggi Badan',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'hasil_gizi',
				'width' => 2,
				'label' => 'Hasil Gizi',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
		);
		$this->childs = array();
	}

	function getForm($uuid = false, $isSubform = false, $anak = null)
	{
		$form = parent::getForm($uuid, $isSubform);
		if (null !== $anak) {
			$this->load->model('Anaks');
			$found = $this->Anaks->findOne($anak);
			$form = array_map(function ($field) use ($anak, $found) {
				if ('anak' === $field['name']) {
					$field['value'] = $anak;
					$field['options'][0] = array(
						'value' => $anak,
						'text' => $found['nama']
					);
				}

				return $field;
			}, $form);

			$form = array_filter($form, function ($field) use ($anak, $found) {
				if (2 !== (int) date('m') && 'vit_a_feb' === $field['name']) return false;
				if (8 !== (int) date('m') && 'vit_a_aug' === $field['name']) return false;
				if ($found['usia'] > 6  && 'asi_eksklusif' === $field['name']) return false;
				return true;
			});
		} elseif (false === $uuid)  $form = array_filter($form, function ($field) {
			return $field['name'] === 'anak';
		});
		return $form;
	}

	function create($record)
	{
		$default = array (
			'asi_eksklusif'
			, 'garam_yodium'
			, 'vit_a_feb'
			, 'vit_a_aug'
		);
		foreach ($default as $field) {
			if (!isset ($record[$field])) $record[$field] = 'Tidak';
		}
		return parent::create ($record);
	}

	function dt()
	{
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select("DATE_FORMAT (pengukuran.createdAt, '%d-%m-%Y %h:%i:%s') createdAt", false)
			->select("anak.nama anak", false)
			->join('anak', 'anak.uuid = pengukuran.anak', 'left');
		return parent::dt();
	}
}
