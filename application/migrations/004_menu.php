<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_menu extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `menu` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `role` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `url` varchar(255) NOT NULL,
        `icon` varchar(255) NOT NULL,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `menu`");
  }

}