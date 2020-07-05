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
		return parent::create($record);
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
		return $this->db
			->select("{$this->table}.uuid")
			->select('anak.nama')
			->select("{$this->table}.hasil_bb")
			->select("{$this->table}.hasil_tb")
			->select("{$this->table}.hasil_gizi")
			->join('anak', "anak.uuid = {$this->table}.anak", 'left')
			->where('warning_sign', 1)
			->get($this->table)
			->result();
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
}
