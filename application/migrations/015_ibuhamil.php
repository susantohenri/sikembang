<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_ibuhamil extends CI_Migration
{

    function up()
    {
        $this->db->query("
            CREATE TABLE `ibuhamil` (
            `uuid` varchar(255) NOT NULL,
            `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
            `createdAt` datetime DEFAULT NULL,
            `updatedAt` datetime DEFAULT NULL,

            `nama_ibuhamil` varchar(255) NOT NULL,
            `nik_ibuhamil` varchar(255) NOT NULL,
            `ttl_ibuhamil` varchar(255) NOT NULL,
            `agama_ibuhamil` varchar(255) NOT NULL,
            `pekerjaan_ibuhamil` varchar(255) NOT NULL,
            `pendidikan_terakhir_ibuhamil` varchar(255) NOT NULL,
            `no_tlp_ibuhamil` varchar(255) NOT NULL,
            `golongan_darah_ibuhamil` varchar(255) NOT NULL,
            `no_bpjs` varchar(255) NOT NULL,

            `nama_suami` varchar(255) NOT NULL,
            `nik_suami` varchar(255) NOT NULL,
            `ttl_suami` varchar(255) NOT NULL,
            `agama_suami` varchar(255) NOT NULL,
            `pekerjaan_suami` varchar(255) NOT NULL,
            `pendidikan_terakhir_suami` varchar(255) NOT NULL,
            `no_tlp_suami` varchar(255) NOT NULL,
            `golongan_darah_suami` varchar(255) NOT NULL,

            `alamat` varchar(255) NOT NULL,
            `dukuh` varchar(255) NOT NULL,
            `rt` varchar(255) NOT NULL,
            `rw` varchar(255) NOT NULL,
            `nomor_kk` varchar(255) NOT NULL,
            `hamil_ke` varchar(255) NOT NULL,
            `usia_anak_terakhir` varchar(255) NOT NULL,
            `hpht` varchar(255) NOT NULL,
            `kb_terakhir` varchar(255) NOT NULL,
            `penolong_kelahiran_sebelumnya` varchar(255) NOT NULL,
            `tinggi_badan` varchar(255) NOT NULL,
            PRIMARY KEY (`uuid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
        $this->load->model(array('Roles', 'Menus', 'Permissions'));
        $bidan = $this->Roles->findOne(array('name' => 'Bidan'));
        $bidan = $bidan['uuid'];
        $this->Menus->create(array(
            'role' => $bidan,
            'name' => 'Ibu Hamil',
            'url' => 'ibuhamil',
            'icon' => 'female'
        ));
        foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
            $this->Permissions->create(array(
                'role' => $bidan,
                'entity' => 'ibuhamil',
                'action' => $action
            ));
        }
    }

    function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `ibuhamil`");
        $this->db->query("DELETE FROM menu WHERE `url` = 'ibuhamil'");
        $this->db->query("DELETE FROM permission WHERE `entity` = 'ibuhamil'");
    }
}
