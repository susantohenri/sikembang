<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_pengukuran extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `pengukuran` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `anak` varchar(255) NOT NULL,
        `bb` float NOT NULL,
        `tb` float NOT NULL,
        `asi_eksklusif` varchar(255) NOT NULL,
        `garam_yodium` varchar(255) NOT NULL,
        `vit_a_feb` varchar(255) NOT NULL,
        `vit_a_aug` varchar(255) NOT NULL,
        `hasil_bb` varchar(255) NOT NULL,
        `hasil_tb` varchar(255) NOT NULL,
        `hasil_gizi` varchar(255) NOT NULL,
        `warning_sign` tinyint(1) DEFAULT 0,
        PRIMARY KEY (`uuid`),
        KEY `anak` (`anak`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `pengukuran`");
  }

}