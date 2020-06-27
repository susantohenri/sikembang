<?php defined('BASEPATH') or exit('No direct script access allowed');

class Frontpage extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $params = array(
            'page_title' => 'Selamat Datang',
            'page_name' => 'frontpage/welcome',
            'current' => array(
                'controller' => 'Frontpage'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function kalkulator()
    {
        $params = array(
            'page_title' => 'Kalkulator Gizi',
            'page_name' => 'frontpage/kalkulator',
            'current' => array(
                'controller' => 'Frontpage'
            ),
            'js' => array(
                'moment.min.js',
                'bootstrap-datepicker.js',
                'daterangepicker.min.js',
                'select2.full.min.js',
                'form.js'
            ),
            'view_switch' => 'form'
        );
        if ($this->input->post ()) $params['view_switch'] = 'result';
        $this->load->view('frontpage', $params);
    }

    function imunisasi()
    {
        $params = array(
            'page_title' => 'Jadwal Imunisasi',
            'page_name' => 'frontpage/imunisasi',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/imunisasi_dt'
            ),
            'js' => array(
                'jquery.dataTables.min.js',
                'dataTables.bootstrap4.js',
                'table.js'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function bidan()
    {
        $params = array(
            'page_title' => 'Daftar Bidan',
            'page_name' => 'frontpage/bidan',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/bidan_dt'
            ),
            'js' => array(
                'jquery.dataTables.min.js',
                'dataTables.bootstrap4.js',
                'table.js'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function faskes()
    {
        $params = array(
            'page_title' => 'Fasilitas Kesehatan',
            'page_name' => 'frontpage/faskes',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/faskes_dt'
            ),
            'js' => array(
                'jquery.dataTables.min.js',
                'dataTables.bootstrap4.js',
                'table.js'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function artikel()
    {
        $params = array(
            'page_title' => 'Artikel',
            'page_name' => 'frontpage/artikel',
            'current' => array(
                'controller' => 'Frontpage'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function bidan_dt()
    {
        $this->load->model('Bidans');
        echo $this->Bidans->dt();
    }

    function faskes_dt()
    {
        $this->load->model('Faskess');
        echo $this->Faskess->dt();
    }

    function imunisasi_dt()
    {
        $this->load->model('Imunisasis');
        echo $this->Imunisasis->dt();
    }
}
