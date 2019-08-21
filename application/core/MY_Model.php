<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

  var $table, $thead, $childs;

  function __construct () {
    // parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->database();
    $this->load->library('datatables');
    $this->table = strtolower($this->router->class);
    $this->thead = array(
      (object) array('mData' => 'name', 'sTitle' => 'Name'),
    );
    $this->childs = array();
  }

  function lastSubmit ($post) {
    if (!$post) return false;
    if ($post['last_submit'] === $this->session->userdata('last_submit')) return false;
    $this->session->set_userdata('last_submit', $post['last_submit']);
    unset($post['last_submit']);
    return $post;
  }

  function save ($record) {
    foreach ($record as $field => &$value) {
      if (is_array($value)) $value = implode(',', $value);
      else if (strpos($value, '[comma-replacement]') > -1) $value = str_replace('[comma-replacement]', ',', $value);
    }
    return isset ($record['uuid']) ? $this->update($record) : $this->create($record);
  }

  function create ($record) {
    $generate = $this->db->select('UUID() uuid', false)->get()->row_array();
    $record['uuid'] = $generate['uuid'];
    $record = $this->savechild($record);
    $record['createdAt'] = date('Y-m-d H:i:s');
    $record['updatedAt'] = date('Y-m-d H:i:s');
    $this->db->insert($this->table, $record);
    return $record['uuid'];
  }

  function update ($record) {
    $record = $this->savechild($record);
    $record['updatedAt'] = date('Y-m-d H:i:s');
    $this->db->where('uuid', $record['uuid'])->update($this->table, $record);
    return $record['uuid'];
  }

  function findOne ($param) {
    if (!is_array($param)) $param = array('uuid' => $param);
    return $this->db->get_where($this->table, $param)->row_array();
  }

  function dt () {
    return $this->datatables->from($this->table)->generate();
  }

  function find ($param = array()) {
    return $this->db->get_where($this->table, $param)->result();
  }

  function findOrCreate ($data) {
    if ($found = $this->findOne (array('kode' => $data['kode'], 'uraian' => $data['uraian']))) return $found['uuid'];
    else return $this->create($data);
  }

  function findIn ($field, $value) {
    return $this->db->where_in($field, $value)->get($this->table)->result();
  }

  function select2 ($field, $term) {
    return $this->db
      ->select("uuid as id", false)
      ->select("$field as text", false)
      ->limit(10)
      ->like($field, $term)->get($this->table)->result();
  }

  function delete ($uuid) {
    foreach ($this->childs as $child) {
      $childmodel = $child['model'];
      $this->load->model($childmodel);
      foreach ($this->$childmodel->find(array($this->table => $uuid)) as $childrecord)
        $this->$childmodel->delete($childrecord->uuid);
    }
    return $this->db->where('uuid', $uuid)->delete($this->table);
  }

  function getForm ($uuid = false, $isSubform = false) {
    $form = $uuid ? $this->prepopulate($uuid) : $this->form;

    if ($uuid) $form[] = array(
      'name' => 'uuid',
      'type' => 'hidden',
      'value'=> $uuid,
      'label'=> 'UUID'
    );

    foreach ($form as &$f) {
      if (!isset ($f['attributes'])) $f['attributes']   = array();
      if (isset ($f['options'])) $f['type'] = 'select';
      if (isset ($f['multiple'])) {
        $f['name']= $f['name'] . '[]';
        $f['attributes'][] = array('multiple' => 'true');
      }
      if (!isset ($f['type'])) $f['type']   = 'text';
      if (!isset ($f['width'])) $f['width'] = 2;
      if (!isset ($f['value'])) $f['value']       = '';
      if (!isset ($f['required'])) $f['required'] = '';
      else $f['required'] = 'required="required"';

      $f['disabled'] = !isset($f['disabled']) ? '' : 'disabled="disabled"';

      if (in_array(array('data-suggestion' => true), $f['attributes'])) {
        $fname = str_replace('[]', '', $f['name']);
        if (isset ($f['multiple'])) {
          $alloptions = array();
          $f['options'] = array();
          foreach ($this->db->select($fname)->get($this->table)->result() as $record)
            if (strlen($record->$fname) > 0) foreach (explode(',', $record->$fname) as $option) $alloptions[] = $option;
          foreach (array_unique ($alloptions) as $distinct) $f['options'][] = array('text' => $distinct, 'value' => $distinct);
        } else {
          $f['options'] = array();
          foreach ($this->db->select($fname)->distinct()->get($this->table)->result() as $record)
            if (strlen($record->$fname) > 0) $f['options'][] = array('text' => $record->$fname, 'value' => $record->$fname);
        }
      }

      $f['attr'] = '';
      foreach ($f['attributes'] as $attribute) foreach ($attribute as $key => $value) $f['attr'] .= " $key=\"$value\"";
    }
    return $form;
  }

  function prepopulate ($uuid) {
    $record = $this->findOne($uuid);
    foreach ($this->form as &$f) {
      if (isset ($f['attributes']) && in_array(array('data-autocomplete' => 'true'), $f['attributes'])) {
        $model = '';
        $field = '';
        foreach ($f['attributes'] as $attr) foreach ($attr as $key => $value) switch ($key) {
          case 'data-model': $model = $value; break;
          case 'data-field': $field = $value; break;
        }
        $this->load->model($model);
        foreach ($this->$model->findIn('uuid', explode(',', $record[$f['name']])) as $option)
          $f['options'][] = array('text' => $option->$field, 'value' => $option->uuid);
      }
      if (isset ($f['multiple'])) $f['value'] = explode(',', $record[$f['name']]);
      else if ($f['name'] === 'password') $f['value'] = '';
      else $f['value'] = $record[$f['name']];
    }
    return $this->form;
  }

  function getFormChild ($uuid = null) {
    foreach ($this->childs as &$child) {
      $childmodel = $child['model'];
      $this->load->model($childmodel);
      $child['uuids'] = array();
      if (!is_null($uuid)) {
        $this->db->order_by('uuid', 'ASC');
        foreach ($this->$childmodel->find(array($this->table => $uuid)) as $childrecord)
          $child['uuids'][] = $childrecord->uuid;
      }
    }
    return $this->childs;
  }

  function savechild ($record) {
    $childrecords = array();
    $savedchilds  = array();

    foreach ($this->childs as $child) {
      $child_controller = $child['controller'];
      $child_model = $child['model'];
      $childrecords[$child_model]= array();
      $savedchilds[$child_model]  = array('');
      foreach ($record as $key => $value) if (strpos($key, $child_controller) > -1) {
        unset ($record[$key]);
        $childrecords[$child_model][str_replace("{$child_controller}_", '', $key)] = $value;
      }
    }

    foreach ($childrecords as $childmodel => $values) {
      if (empty ($values)) continue;
      $this->load->model($childmodel);
      $fields = array_keys($values);
      for ($index =0; $index < count(explode(',', $childrecords[$childmodel][$fields[0]])); $index++) {
        $child_record = array();
        foreach ($fields as $field) {
          $childinput = explode(',', $childrecords[$childmodel][$field]);
          if (isset ($childinput[$index])) $child_record[$field] = $childinput[$index];
        }
        $child_record[$this->table] = $record['uuid'];
        $savedchilds[$childmodel][] = $this->$childmodel->save($child_record);
      }
    }

    foreach ($this->childs as $child) {
      $childxmodel = $child['model'];
      $this->load->model($childxmodel);
      $this->db
        ->where(array($this->table => $record['uuid']))
        ->where_not_in('uuid', $savedchilds[$childxmodel])
        ->delete($this->$childxmodel->table);
    }

    return $record;
  }

}