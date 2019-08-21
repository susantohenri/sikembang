<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_{{migrationName}} extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `{{tableName}}` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,{{fields}}
        PRIMARY KEY (`uuid`){{indexes}}
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `{{tableName}}`");
  }

}