<?php defined('BASEPATH') OR exit('No direct script access allowed');

class {{modelName}} extends MY_Model {

  function __construct () {
    parent::__construct();
    $this->table = '{{tableName}}';
    $this->thead = array(
      (object) array('mData' => 'orders', 'sTitle' => 'No', 'visible' => false),
      {{theads}}
    );
    $this->form = array ({{fields}}
    );
  }

  function dt () {
    $this->datatables
      ->select("{$this->table}.uuid")
      ->select("{$this->table}.orders")
      {{dtField}};
    return parent::dt();
  }

}