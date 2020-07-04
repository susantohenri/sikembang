<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{
    function imunisasi()
    {
        if ($_FILES) {
            $dir = 'imunisasi';
            $this->Menus->fileupload($dir, $_FILES['imunisasi'], "{$dir}/{$this->Menus->getImunisasi()}");
            redirect(site_url());
        }
        $this->loadview('index', array(
            'page_name' => 'imunisasi'
        ));
    }
}
