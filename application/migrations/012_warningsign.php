<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_warningsign extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `warningsign` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `pengukuran` varchar(255) NOT NULL,
        `done` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `warningsign`");
  }

}