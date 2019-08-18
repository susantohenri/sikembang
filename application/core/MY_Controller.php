<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  var $controller, $model, $page_title, $subformlabel;

  function __construct () {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    if (empty ($this->session->userdata['uuid'])) redirect (site_url('Login'), 'refresh');
    $this->controller = $this->router->class;

    $page_title = preg_split('#([A-Z][^A-Z]*)#', $this->controller, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $page_title = implode(' ', $page_title);
    $this->subformlabel = $page_title;

    if (!isset ($this->model)) $this->model = $this->controller . 's';
    $this->load->model($this->model);
  }

  public function loadview ($view, $vars = array()) {
    $vars['error'] = $this->session->flashdata('model_error');
    $vars['account_type'] = $this->session->userdata('role');

    $page_title = preg_split('#([A-Z][^A-Z]*)#', $this->controller, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $page_title = implode(' ', $page_title);
    $vars['page_title']   = isset($this->page_title) ? $this->page_title: $page_title;

    if (!isset ($vars['form_action'])) $vars['form_action'] = site_url($this->controller);
    $vars['current'] = array (
      'model' => $this->model,
      'controller' => $this->controller
    );

    $this->load->model('Permissions');
    if (!isset ($vars['permission'])) $vars['permission'] = $this->Permissions->getPermissions();
    $this->load->view($view, $vars);
  }

  public function index () {
    $model = $this->model;
    if ($post = $this->$model->lastSubmit($this->input->post())) {
      if (isset ($post['delete'])) $this->$model->delete($post['delete']);
      else {
          $db_debug = $this->db->db_debug;
          $this->db->db_debug = FALSE;

          $result = $this->$model->save($post);

          $error = $this->db->error();
          $this->db->db_debug = $db_debug;
          if (isset ($result['error'])) $error = $result['error'];
          if(count($error)){
              $this->session->set_flashdata('model_error', $error['message']);
              redirect($this->controller);
          }
      }
    }
    $vars = array();
    $vars['page_name'] = 'table';
    $vars['js'] = array(
      'jquery.dataTables.min.js',
      'dataTables.bootstrap4.js',
      'table.js'
    );
    $vars['thead'] = $this->$model->thead;
    $this->loadview('index', $vars);
  }

  function create () {
    $model= $this->model;
    $vars = array();
    $vars['page_name'] = 'form';
    $vars['form']     = $this->$model->getForm();
    $vars['subform'] = $this->$model->getFormChild();
    $vars['uuid'] = '';
    $vars['js'] = array(
      'moment.min.js',
      'bootstrap-datepicker.js',
      'daterangepicker.min.js',
      'select2.full.min.js',
      'form.js'
    );
    $this->loadview('index', $vars);
  }

  function subformcreate () {
    $model= $this->model;
    $vars = array();
    $vars['form'] = $this->$model->getForm(false, true);
    $vars['subformlabel'] = $this->subformlabel;
    $vars['controller'] = $this->controller;
    $vars['uuid'] = '';
    $this->loadview('subform', $vars);
  }

  function read ($id) {
    $vars = array();
    $vars['page_name'] = 'form';
    $model = $this->model;
    $vars['form'] = $this->$model->getForm($id);
    $vars['subform'] = $this->$model->getFormChild($id);
    $vars['uuid'] = $id;
    $vars['js'] = array(
      'moment.min.js',
      'bootstrap-datepicker.js',
      'daterangepicker.min.js',
      'select2.full.min.js',
      'form.js'
    );
    $this->loadview('index', $vars);
  }

  function subformread ($uuid) {
    $data = array();
    $model = $this->model;
    $data['form'] = $this->$model->getForm($uuid, true);
    $data['subformlabel'] = $this->subformlabel;
    $data['controller'] = $this->controller;
    $data['uuid'] = $uuid;
    $data['item'] = $this->{$this->model}->findOne($uuid);
    $this->loadview('subform', $data);
  }

  function delete ($uuid) {
    $vars = array();
    $vars['page_name'] = 'confirm';
    $vars['uuid'] = $uuid;
    $this->loadview('index', $vars);
  }

  function select2 ($model, $field) {
    $this->load->model($model);
    echo '{"results":'. json_encode($this->$model->select2($field, $this->input->post('term'))) . '}';
  }

  function dt () {
    echo $this->{$this->model}->dt();
  }

}