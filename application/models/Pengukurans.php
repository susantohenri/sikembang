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

		$this->form = array(
			array(
				'name' => 'createdAt',
				'width' => 2,
				'label' => 'Tanggal',
				'value' => date('Y-m-d'),
				'attributes' => array(
					array('data-date' => 'datepicker'),
					// array('disabled' => 'disabled')
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
					// array('disabled' => 'disabled')
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
			)
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

			$hide_imunisasi = array('bcg', 'polio_1', 'dpt_combo_1', 'polio_2', 'dpt_combo_2', 'polio_3', 'dpt_combo_3', 'polio_4', 'ipv', 'campak', 'dpt_combo_booster', 'campak_booster');
			if (!$uuid) {
				if ($found['usia'] <= 24) {
					$imunisasi = $this->Pengukurans->getImunisasi($anak);

					if ($found['usia'] >= 18) {
						if (in_array('dpt_combo_booster', $imunisasi['belum'])) {
							$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_booster'));
						}
						if (in_array('campak_booster', $imunisasi['belum'])) {
							$hide_imunisasi = array_diff($hide_imunisasi, array('campak_booster'));
						}
					}

					if ($found['usia'] <= 11) {
						if ($found['usia'] >= 1) {
							if (in_array('bcg', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('bcg'));
							}
							if (in_array('polio_1', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('polio_1'));
							}
						}
						if ($found['usia'] >= 2) {
							if (in_array('dpt_combo_1', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_1'));
							}
							if (in_array('polio_2', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('polio_2'));
							}
						}
						if ($found['usia'] >= 3) {
							if (in_array('dpt_combo_2', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_2'));
							}
							if (in_array('polio_3', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('polio_3'));
							}
						}
						if ($found['usia'] >= 4) {
							if (in_array('dpt_combo_3', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_3'));
							}
							if (in_array('polio_4', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('polio_4'));
							}
							if (in_array('ipv', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('ipv'));
							}
						}
						if ($found['usia'] >= 9) {
							if (in_array('dpt_combo_booster', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_booster'));
							}
							if (in_array('campak_booster', $imunisasi['belum'])) {
								$hide_imunisasi = array_diff($hide_imunisasi, array('campak_booster'));
							}
						}
					}
				}
				$form = array_values(array_filter($form, function ($field) use ($hide_imunisasi) {
					return !in_array($field['name'], $hide_imunisasi);
				}));
			} else {
				foreach ($form as $field) {
					if (in_array($field['name'], $hide_imunisasi) && 'Ya' === $field['value']) {
						$hide_imunisasi = array_diff($hide_imunisasi, array($field['name']));
					}
				}
				switch ((int) $found['usia']) {
					case 1:
						$hide_imunisasi = array_diff($hide_imunisasi, array('bcg'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('polio_1'));
						break;
					case 2:
						$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_1'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('polio_2'));
						break;
					case 3:
						$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_2'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('polio_3'));
						break;
					case 4:
						$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_3'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('polio_4'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('ipv'));
						break;
					case 9:
						$hide_imunisasi = array_diff($hide_imunisasi, array('campak'));
						break;
					case 18:
						$hide_imunisasi = array_diff($hide_imunisasi, array('dpt_combo_booster'));
						$hide_imunisasi = array_diff($hide_imunisasi, array('campak_booster'));
						break;
				}
				$form = array_values(array_filter($form, function ($field) use ($hide_imunisasi) {
					return !in_array($field['name'], $hide_imunisasi);
				}));
			}
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
			->select("DATE_FORMAT(pengukuran.createdAt, '%d-%m-%Y %h:%i:%s') createdAt", false)
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

		$normal = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Baik', 'Normal'));
		}));
		if (count($normal) > 0) $chart->data->datasets[] = $normal[0];

		$buruk = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Buruk', 'Sangat Pendek', 'Sangat Kurang'));
		}));
		if (count($buruk) > 0) $chart->data->datasets[] = $buruk[0];

		$kurang = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Kurang', 'Pendek', 'Kurang'));
		}));
		if (count($kurang) > 0) $chart->data->datasets[] = $kurang[0];

		$lebih = array_values(array_filter($datasets, function ($ds) {
			return in_array($ds->label, array('Gizi Lebih', 'Tinggi', 'Resiko Berlebih'));
		}));
		if (count($lebih) > 0) $chart->data->datasets[] = $lebih[0];

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

	function download($type, $since, $until)
	{
		if (strlen($since) > 0) $this->db->where("{$this->table}.createdAt >= '{$since}'");
		if (strlen($until) > 0) $this->db->where("{$this->table}.createdAt <= '{$until}'");
		$no = 0;
		return array_map(function ($record) use (&$no, $type) {
			$all = array(
				'bcg' => 'BCG',
				'polio_1' => 'Polio 1',
				'dpt_combo_1' => 'DPT Combo 1',
				'polio_2' => 'Polio 2',
				'dpt_combo_2' => 'DPT Combo 2',
				'polio_3' => 'Polio 3',
				'dpt_combo_3' => 'DPT Combo 3',
				'polio_4' => 'Polio 4',
				'ipv' => 'IPV',
				'campak' => 'Campak',
				'dpt_combo_booster' => 'DPT Combo Booster',
				'campak_booster' => 'Campak Booster'
			);
			$imunisasi = array();
			foreach ($all as $key => $value) if ('Ya' === $record->$key) $imunisasi[] = $value;

			$no++;
			return 'balita' === $type ? array(
				'No' => $no,
				'NAMA ANAK' => $record->nama_anak,
				'NIK (Nomor Induk Kependudukan)' => $record->nik,
				'No. KK' => $record->no_kk,
				'ANAK KE' => $record->anak_ke,
				'TANGGAL LAHIR' => $record->tgl_lahir,
				'POSYANDU' => $record->nama_posyandu,
				'JENIS KELAMIN' => $record->jenis_kelamin,
				'Berat Badan Lahir (Kg)' => $record->bb_lahir,
				'Panjang Badan Lahir (Cm)' => $record->tb_lahir,
				'Nama Orang Tua' => "{$record->nama_ayah} / {$record->nama_ibu}",
				'No. Tlp/HP Orang Tua' => $record->tlp_ortu,
				'ALAMAT' => $record->alamat,
				'RT' => $record->rt,
				'RW' => $record->rw,
				'Kepemilikan BPJS Ya/Tidak' => $record->bpjs,
				'IMD YA/Tidak' => $record->imd,
				'Umur (bulan)' => $record->usia,
				'Tanggal Pengukuran' => $record->tanggal_pengukuran,
				'BB (Kg)' => $record->bb,
				'TB (Cm)' => $record->tb,
				'Cara Ukur Telentang/Berdiri' => $record->usia < 24 ? 'Telentang' : 'Berdiri',
				'ASI Eksklusif Ya/Tidak' => $record->asi_eksklusif,
				'Vitamin A Februari Ya/Tidak' => $record->vit_a_feb,
				'Vitamin A Agustus Ya/Tidak' => $record->vit_a_aug,
				'Status BB/U (sangat kurang/kurang/normal/risiko BB berlebih)' => $record->hasil_bb,
				'Status TB/U (sangat pendek/pendek/normal/tinggi)' => $record->hasil_tb,
				'Status BB/TB (gizi buruk/gizi kurang/gizi baik/risiko gizi lebih/gizi lebih/obesitas)' => $record->hasil_bb,
				'Imunisasi (BCG/Polio 1/Polio 2/Polio 3/Polio 4/DPT Combo 1/ DPT Combo 2/DPT Combo 3/IPV/Campak/DPT Combo Booster/Campak Booster)' => implode(', ', $imunisasi)
			) : array(
				'No' => $no,
				'NAMA ANAK' => $record->nama_anak,
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
				'Umur (bulan)' => $record->usia,
				'Tanggal Pengukuran' => $record->tanggal_pengukuran,
				'BB (Kg)' => $record->bb,
				'TB (Cm)' => $record->tb,
				'Cara Ukur Telentang/Berdiri' => $record->usia < 24 ? 'Telentang' : 'Berdiri',
				'ASI Eksklusif Ya/Tidak' => $record->asi_eksklusif,
				'Status BB/U (sangat kurang/kurang/normal/risiko BB berlebih)' => $record->hasil_bb,
				'Status TB/U (sangat pendek/pendek/normal/tinggi)' => $record->hasil_tb,
				'Status BB/TB (gizi buruk/gizi kurang/gizi baik/risiko gizi lebih/gizi lebih/obesitas)' => $record->hasil_bb,
				'Imunisasi (BCG/Polio 1/Polio 2/Polio 3/Polio 4/DPT Combo 1/ DPT Combo 2/DPT Combo 3/IPV/Campak/DPT Combo Booster/Campak Booster)' => implode(', ', $imunisasi),
				'Intervensi' => $record->intervensi
			);
		}, $this->db
			->select('*')
			->select('anak.nama nama_anak', false)
			->select("DATE_FORMAT(tgl_lahir, '%d-%m-%Y') AS tgl_lahir", false)
			->select("FLOOR(DATEDIFF({$this->table}.createdAt, tgl_lahir) / 30) AS usia", false)
			->select("DATE_FORMAT({$this->table}.createdAt, '%d-%m-%Y') AS tanggal_pengukuran", false)
			->select('posyandu.nama nama_posyandu', false)
			->join('anak', "anak.uuid = {$this->table}.anak", 'left')
			->join('posyandu', 'anak.posyandu = posyandu.uuid', 'left')
			->get($this->table)
			->result()
		);
	}

	function findOne($param)
	{
		$this->db
			->select('*')
			->select("DATE_FORMAT(createdAt, '%Y-%m-%d') createdAt", false);
		return parent::findOne($param);
	}

	function getImunisasi($anak)
	{
		$belum = $imuns = array('bcg', 'polio_1', 'dpt_combo_1', 'polio_2', 'dpt_combo_2', 'polio_3', 'dpt_combo_3', 'polio_4', 'ipv', 'campak', 'dpt_combo_booster', 'campak_booster');
		$sudah = array();
		foreach ($imuns as $im) $this->db->select($im);
		$result = $this->db->get_where($this->table, array('anak' => $anak))->result();
		foreach ($result as $record) {
			foreach ($imuns as $im) {
				if ($record->$im === 'Ya') {
					$sudah[] = $im;
					$belum = array_diff($belum, array($im));
				}
			}
		}
		return array('sudah' => $sudah, 'belum' => $belum);
	}
}
