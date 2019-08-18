<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function index () {
		if ($post = $this->input->post()) {
			$this->load->model('Users');
			$login = $this->Users->findOne(array(
				'username' => $post['username'],
				'password' => md5($post['password'])
			));
			if (isset ($login['uuid'])) {
				$this->load->library('session');
				$this->session->set_userdata($login);
				redirect(base_url());
			}
		}
		$this->load->view('login');
	}

	function Migrate ($version = null) {
		$this->load->library('migration');
	    $success = !is_null ($version) ? $this->migration->version($version) : $this->migration->latest();
	    if (!$success) show_error($this->migration->error_string());
	}

	function Logout() {
	  	$this->load->library('session');
	    $this->session->sess_destroy();
	    redirect(base_url());
	}

}