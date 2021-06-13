<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Posyandudesa extends CI_Migration
{

    function up()
    {
        $this->db->query("
            CREATE TABLE `desa` (
            `uuid` varchar(255) NOT NULL,
            `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
            `createdAt` datetime DEFAULT NULL,
            `updatedAt` datetime DEFAULT NULL,
            `nama` varchar(255) NOT NULL,
            PRIMARY KEY (`uuid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ");
        $this->db->query("ALTER TABLE `posyandu` ADD `desa` VARCHAR(36) NOT NULL AFTER `createdAt`;");
        $this->db->query("ALTER TABLE `anak` ADD `desa` VARCHAR(36) NOT NULL AFTER `posyandu`;");
        $this->load->model(array('Roles', 'Menus', 'Permissions'));
        $bidan = $this->Roles->findOne(array('name' => 'Bidan'));
        $bidan = $bidan['uuid'];
        $this->Menus->create(array(
            'role' => $bidan,
            'name' => 'Desa',
            'url' => 'Desa',
            'icon' => 'map-marker-alt'
        ));
        foreach (array('index', 'create', 'read', 'update', 'delete') as $action) {
            $this->Permissions->create(array(
                'role' => $bidan,
                'entity' => 'Desa',
                'action' => $action
            ));
        }
    }

    function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `desa`");
        $this->db->query("ALTER TABLE `posyandu` DROP `desa`;");
        $this->db->query("ALTER TABLE `anak` DROP `desa`;");
        $this->db->query("DELETE FROM menu WHERE `url` = 'Desa'");
        $this->db->query("DELETE FROM permission WHERE `entity` = 'Desa'");
    }
}
