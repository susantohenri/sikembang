<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_posyandu extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `posyandu` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `nama` varchar(255) NOT NULL,
        `alamat` varchar(255) NOT NULL,
        `telepon` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

    $this->load->model('Posyandus');
    foreach (array('Karangmojo', 'Maloan', 'Sidomulyo', 'Tegalrejo', 'Rejosari', 'Gupitsari', 'Tegalan', 'Teras', 'Banjarsari', 'Nglarangan', 'Perum') as $posyandu) {
        $this->Posyandus->create (array('nama' => $posyandu));
    }
  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `posyandu`");
  }

}