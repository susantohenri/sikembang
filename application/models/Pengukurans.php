<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengukurans extends MY_Model
{

	function __construct()
	{
		parent::__construct();
		$this->table = 'pengukuran';
		$this->thead = array(
			(object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false, 'searchable' => false),
			(object) array('mData' => 'createdAt', 'sTitle' => 'Waktu', 'searchable' => false),
			(object) array('mData' => 'anak', 'sTitle' => 'Anak', 'searchable' => false),
		);

		$createPengukuran = site_url('Pengukuran/create/');
		$this->form = array(
			array(
				'name' => 'createdAt',
				'width' => 2,
				'label' => 'Tanggal',
				'value' => date('Y-m-d'),
				'attributes' => array(
					array('data-date' => 'datepicker'),
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'anak',
				'label' => 'Anak',
				'options' => array(),
				'width' => 2,
				'attributes' => array(
					array('data-autocomplete' => 'true'),
					array('data-model' => 'Anaks'),
					array('data-field' => 'nama'),
					array('disabled' => 'disabled')
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
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'vit_a_aug',
				'label' => 'Vitamin A Agustus',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'bcg',
				'label' => 'Imunisasi BCG',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'polio_1',
				'label' => 'Imunisasi Polio 1',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'dpt_combo_1',
				'label' => 'Imunisasi DPT Combo 1',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'polio_2',
				'label' => 'Imunisasi Polio 2',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'dpt_combo_2',
				'label' => 'Imunisasi DPT Combo 2',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'polio_3',
				'label' => 'Imunisasi Polio 3',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'dpt_combo_3',
				'label' => 'Imunisasi DPT Combo 3',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'polio_4',
				'label' => 'Imunisasi Polio 4',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'ipv',
				'label' => 'Imunisasi IPV',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'campak',
				'label' => 'Imunisasi Campak',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'dpt_combo_booster',
				'label' => 'Imunisasi DPT Combo Booster',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'campak_booster',
				'label' => 'Imunisasi Campak Booster',
				'width' => 2,
				'options' => array(
					array('text' => 'Tidak', 'value' => 'Tidak'),
					array('text' => 'Ya', 'value' => 'Ya'),
				)
			),
			array(
				'name' => 'hasil_bb',
				'width' => 2,
				'label' => 'Status Gizi BB / U',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'hasil_tb',
				'width' => 2,
				'label' => 'Status Gizi TB / U',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'hasil_gizi',
				'width' => 2,
				'label' => 'Status Gizi BB / TB',
				'attributes' => array(
					array('disabled' => 'disabled')
				)
			),
			array(
				'name' => 'intervensi',
				'width' => 2,
				'label' => 'Intervensi',
				'type' => 'textarea'
			),
		);
		$this->childs = array();
	}

	function getFormFirstStep()
	{
		$form = array_values(array_filter(parent::getForm(), function ($field) {
			return $field['name'] === 'createdAt';
		}));
		$form[0]['attr'] = str_replace('disabled="disabled', '', $form[0]['attr']);
		return $form;
	}

	function getFormSecondStep($createdAt)
	{
		$form = array_values(array_filter(parent::getForm(), function ($field) {
			return in_array($field['name'], array('anak', 'createdAt'));
		}));
		$form[0]['value'] = $createdAt;
		$form[1]['attr'] = str_replace('disabled="disabled', '', $form[1]['attr']);
		return $form;
	}

	function getForm($uuid = false, $isSubform = false, $anak = null, $retrieveDate = null)
	{
		$form = parent::getForm($uuid, $isSubform);

		if (!is_null($retrieveDate)) {
			$form = array_map(function ($field) use ($retrieveDate) {
				if ('createdAt' === $field['name']) $field['value'] = $retrieveDate;
				return $field;
			}, $form);
		}

		if (false !== $uuid && is_null($anak) && is_null($retrieveDate)) {
			$field_anak = array_values(array_filter($form, function ($field) {
				return $field['name'] === 'anak';
			}))[0];
			$anak = $field_anak['value'];
			$field_createdAt = array_values(array_filter($form, function ($field) {
				return $field['name'] === 'createdAt';
			}))[0];
			$retrieveDate = $field_createdAt['value'];
		}

		if (null !== $anak) {
			$this->load->model('Anaks');
			$found = $this->Anaks->findOneWithUsia($anak, $retrieveDate);
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

			$form = array_filter($form, function ($field) use ($anak, $found, $retrieveDate) {
				$month = (int) date('m', strtotime($retrieveDate));
				if (2 !== $month && 'vit_a_feb' === $field['name']) return false;
				if (8 !== $month && 'vit_a_aug' === $field['name']) return false;
				if ($found['usia'] > 6  && 'asi_eksklusif' === $field['name']) return false;
				return true;
			});
		}

		$form = array_map(function ($field) {
			if (false === strpos($field['name'], 'hasil_')) return $field;
			if (!isset($field['value'])) return $field;
			switch ($field['name']) {
				case 'hasil_bb':
					switch ($field['value']) {
						case 'Sangat Kurang':
							$field['attributes'][] = array('style' => 'color:red');
							$field['attr'] .= ' style="color:red"';
							break;
						case 'Kurang':
						case 'Resiko Berlebih':
							$field['attributes'][] = array('style' => 'color:orange');
							$field['attr'] .= ' style="color:orange"';
							break;
						default:
							$field['attributes'][] = array('style' => 'color:green');
							$field['attr'] .= ' style="color:green"';
							break;
					}
					break;
				case 'hasil_tb':
					switch ($field['value']) {
						case 'Sangat Pendek':
							$field['attributes'][] = array('style' => 'color:red');
							$field['attr'] .= ' style="color:red"';
							break;
						case 'Pendek':
						case 'Tinggi':
							$field['attributes'][] = array('style' => 'color:orange');
							$field['attr'] .= ' style="color:orange"';
							break;
						default:
							$field['attributes'][] = array('style' => 'color:green');
							$field['attr'] .= ' style="color:green"';
							break;
					}
					break;
				case 'hasil_gizi':
					switch ($field['value']) {
						case 'Gizi Buruk':
						case 'Obesitas':
							$field['attributes'][] = array('style' => 'color:red');
							$field['attr'] .= ' style="color:red"';
							break;
						case 'Gizi Kurang':
						case 'Gizi Lebih':
							$field['attributes'][] = array('style' => 'color:orange');
							$field['attr'] .= ' style="color:orange"';
							break;
						default:
							$field['attributes'][] = array('style' => 'color:green');
							$field['attr'] .= ' style="color:green"';
							break;
					}
					break;
			}
			return $field;
		}, $form);

		$hide_intervensi = true;
		$this->load->model('Permissions');
		$permissions = $this->Permissions->getPermissions();
		if (false !== $uuid && in_array('delete_WarningSign', $permissions)) {
			$found = $this->Pengukurans->findOne($uuid);
			if ('1' === $found['warning_sign']) {
				$hide_intervensi = false;
			}
		}
		if ($hide_intervensi) $form = array_filter($form, function ($field) {
			return $field['name'] !== 'intervensi';
		});

		return $form;
	}

	function create($record)
	{
		$default = array(
			'asi_eksklusif', 'garam_yodium', 'vit_a_feb', 'vit_a_aug'
		);
		foreach ($default as $field) {
			if (!isset($record[$field])) $record[$field] = 'Tidak';
		}
		if (
			$record['hasil_bb'] !== 'Normal'
			||
			$record['hasil_tb'] !== 'Normal'
			||
			$record['hasil_gizi'] !== 'Gizi Baik'
		) $record['warning_sign'] = 1;
		$generate = $this->db->select('UUID() uuid', false)->get()->row_array();
		$record['uuid'] = $generate['uuid'];
		$record = $this->savechild($record);
		$record['updatedAt'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table, $record);
		return $record['uuid'];
	}

	function dt()
	{
		if ($term = $this->input->post('search')) {
			$this->datatables->like('anak.nama', $term['value']);
		}
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select("DATE_FORMAT (pengukuran.createdAt, '%d-%m-%Y %h:%i:%s') createdAt", false)
			->select("anak.nama anak", false)
			->join('anak', 'anak.uuid = pengukuran.anak', 'left');
		return parent::dt();
	}

	function getWarningSigns()
	{
		$result = $this->db
			->select("COUNT(uuid) total")
			->where('warning_sign', 1)
			->get($this->table)
			->row_array();
		return $result ? $result['total'] : 0;
	}

	function unsign($uuid)
	{
		return $this->db
			->where('uuid', $uuid)
			->set('warning_sign', 0)
			->update($this->table);
	}

	function grafik($jenis, $since, $until)
	{
		$query = $this->db
			->select("DATE_FORMAT(createdAt, '%b %Y') label", false)
			->select("COUNT(uuid) 'data'", false)
			->select("hasil_{$jenis} legend", false)
			->group_by("DATE_FORMAT(createdAt, '%b/%Y'), hasil_{$jenis} ")
			->order_by('createdAt');
		if (strlen($since) > 0) $query->where("createdAt >= '{$since}'");
		if (strlen($until) > 0) $query->where("createdAt <= '{$until}'");
		$result = $query->get($this->table)->result();

		$labels = array_values(array_unique(array_column($result, 'label')));
		$legends = array_values(array_unique(array_column($result, 'legend')));

		$data = array();
		foreach ($legends as $legend) {
			$data[] = array_map(function ($record) {
				return $record->data;
			}, array_values(array_filter($result, function ($record) use ($legend) {
				return $record->legend === $legend;
			})));
		}

		$chart = json_decode('{"type":"bar","data":{"labels":[],"datasets":[]},"options":{"responsive":true,"scales":{"yAxes":[{"id":"KIRI","type":"linear","position":"left"},{"id":"KANAN","type":"linear","position":"right"}]}}}');
		$chart->data->labels = $labels;
		$datasets = array();
		foreach ($legends as $index => $legend) {
			$ds = new stdClass();
			$ds->label = $legend;
			$ds->data = $data[$index];
			$datasets[] = $ds;
		}

		$chart->data->datasets[] = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Baik', 'Normal'));
		}))[0];

		$chart->data->datasets[] = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Buruk', 'Sangat Pendek', 'Sangat Kurang'));
		}))[0];
		$chart->data->datasets[] = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Kurang', 'Pendek', 'Kurang'));
		}))[0];
		$chart->data->datasets[] = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Lebih', 'Tinggi', 'Resiko Berlebih'));
		}))[0];
		$obesitas = array_values(array_filter($datasets, function ($ds) {
			return $ds->label === 'Obesitas';
		}));
		if (count($obesitas) > 0) $chart->data->datasets[] = $obesitas[0];

		foreach ($chart->data->datasets as $index => &$ds) {
			switch ($index) {
				case 0:
					$ds->borderColor = 'green';
					$ds->yAxisID = 'KANAN';
					$ds->type = 'line';
					$ds->fill = false;
					$ds->lineTension = 0;
					break;
				case 1:
					$ds->backgroundColor = 'lightblue';
					break;
				case 2:
					$ds->backgroundColor = 'orange';
					break;
				case 3:
					$ds->backgroundColor = 'yellow';
					break;
				case 4:
					$ds->backgroundColor = 'blue';
					break;
			}
		}

		return json_encode($chart);
	}

	function grafik_asi()
	{
		$result = json_decode('{"type":"pie","data":{"datasets":[{"data":[100,2],"backgroundColor":["lightblue","orange"]}],"labels":["Ya","Tidak"]},"options":{"responsive":true}}');

		$all = $this->db
			->distinct('anak')
			->group_by('anak')
			->get($this->table)
			->result();
		$all = count($all);

		$ekslusif = $this->db
			->select('anak')
			->group_by('anak')
			->having("GROUP_CONCAT(DISTINCT asi_eksklusif) = 'Ya'")
			->get($this->table)
			->result();
		$ekslusif = count($ekslusif);

		$result->data->datasets[0]->data = array($ekslusif, $all - $ekslusif);
		return json_encode($result);
	}

	function download($jenis, $since, $until)
	{
		$monthsQ = $this->db
			->select("DATE_FORMAT(createdAt, '%b %Y') monthYear", false)
			->group_by("DATE_FORMAT(createdAt, '%b %Y')")
			->order_by('createdAt');

		if (strlen($since) > 0) $monthsQ->where("createdAt >= '{$since}'");
		if (strlen($until) > 0) $monthsQ->where("createdAt <= '{$until}'");

		$months = $monthsQ->get($this->table)->result();

		$resultQ = $this->db
			->select("hasil_{$jenis} KATEGORI", false)
			->group_by("hasil_{$jenis}");

		foreach ($months as $month) {
			$resultQ->select("SUM(CASE WHEN DATE_FORMAT(createdAt, '%b %Y') = '{$month->monthYear}' THEN 1 ELSE 0 END) '{$month->monthYear}'", false);
		}

		$result = $resultQ->get($this->table)->result_array();
		return $result;
	}

	function findOne($param)
	{
		$this->db
			->select('*')
			->select("DATE_FORMAT(createdAt, '%Y-%m-%d') createdAt", false);
		return parent::findOne($param);
	}

	function warningDt()
	{
		if ($term = $this->input->post('search')) {
			$this->datatables->like('anak.nama', $term['value']);
		}
		$this->datatables
			->select("{$this->table}.uuid")
			->select("{$this->table}.orders")
			->select("DATE_FORMAT (pengukuran.createdAt, '%d-%m-%Y %h:%i:%s') createdAt", false)
			->select("anak.nama anak", false)
			->join('anak', 'anak.uuid = pengukuran.anak', 'left')
			->where('warning_sign', 1);
		return parent::dt();
	}
}
