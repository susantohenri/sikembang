<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_posyandubumil extends CI_Migration
{

    function up()
    {
        $this->db->query("
            CREATE TABLE `posyandubumil` (
            `uuid` varchar(255) NOT NULL,
            `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
            `createdAt` datetime DEFAULT NULL,
            `updatedAt` datetime DEFAULT NULL,
            `tanggal_pemeriksaan` DATE NOT NULL,
            `ibuhamil` varchar(255) NOT NULL,
            `umur_kehamilan` float NOT NULL,
            `lingkar_lengan_atas` float NOT NULL,
            `berat_badan` float NOT NULL,
            `tensi` varchar(255) NOT NULL,
            `checklist_tablet_tambah_darah` float NOT NULL,
            `keterangan` varchar(255) NOT NULL,
            PRIMARY KEY (`uuid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
        $this->load->model(array('Roles', 'Menus', 'Permissions'));
        $bidan = $this->Roles->findOne(array('name' => 'Bidan'));
        $bidan = $bidan['uuid'];
        $this->Menus->create(array(
            'role' => $bidan,
            'name' => 'Posyandu Bumil',
            'url' => 'posyandubumil',
            'icon' => 'pills'
        ));
        foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
            $this->Permissions->create(array(
                'role' => $bidan,
                'entity' => 'posyandubumil',
                'action' => $action
            ));
        }
    }

    function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `posyandubumil`");
        $this->db->query("DELETE FROM menu WHERE `url` = 'posyandubumil'");
        $this->db->query("DELETE FROM permission WHERE `entity` = 'posyandubumil'");
    }
}
