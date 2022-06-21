<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Pendonor extends CI_Migration
{

    function up()
    {
        $this->db->query("
            CREATE TABLE `pendonor` (
            `uuid` varchar(255) NOT NULL,
            `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
            `createdAt` datetime DEFAULT NULL,
            `updatedAt` datetime DEFAULT NULL,
            `nama` varchar(255) NOT NULL,
            `golongan_darah` varchar(255) NOT NULL,
            `alamat` varchar(255) NOT NULL,
            `nomor_kk` varchar(255) NOT NULL,
            `NIK` varchar(255) NOT NULL,
            `nomor_telepon` varchar(255) NOT NULL,
            PRIMARY KEY (`uuid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
        $this->load->model(array('Roles', 'Menus', 'Permissions'));
        $bidan = $this->Roles->findOne(array('name' => 'Bidan'));
        $bidan = $bidan['uuid'];
        $this->Menus->create(array(
            'role' => $bidan,
            'name' => 'Bank Darah Hidup',
            'url' => 'Pendonor',
            'icon' => 'burn'
        ));
        foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
            $this->Permissions->create(array(
                'role' => $bidan,
                'entity' => 'Pendonor',
                'action' => $action
            ));
        }
    }

    function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `pendonor`");
        $this->db->query("DELETE FROM menu WHERE `url` = 'Pendonor'");
        $this->db->query("DELETE FROM permission WHERE `entity` = 'Pendonor'");
    }
}
