<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_bidan extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `bidan` (
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

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `bidan`");
  }

}