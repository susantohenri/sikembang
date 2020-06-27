<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_imunisasi extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `imunisasi` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `tanggal` DATE NOT NULL,
        `nama` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `imunisasi`");
  }

}