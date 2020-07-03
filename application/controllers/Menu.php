<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{
    function imunisasi()
    {
        if ($_FILES) {

        }
        $this->loadview('index', array(
            'page_name' => 'imunisasi'
        ));
    }
}
