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
        `asi_eksklusif` ENUM ('Ya', 'Tidak'),
        `garam_yodium` ENUM ('Ya', 'Tidak'),
        `vit_a_feb` ENUM ('Ya', 'Tidak'),
        `vit_a_aug` ENUM ('Ya', 'Tidak'),
        `bcg` ENUM ('Ya', 'Tidak'),
        `polio_1` ENUM ('Ya', 'Tidak'),
        `dpt_combo_1` ENUM ('Ya', 'Tidak'),
        `polio_2` ENUM ('Ya', 'Tidak'),
        `dpt_combo_2` ENUM ('Ya', 'Tidak'),
        `polio_3` ENUM ('Ya', 'Tidak'),
        `dpt_combo_3` ENUM ('Ya', 'Tidak'),
        `polio_4` ENUM ('Ya', 'Tidak'),
        `ipv` ENUM ('Ya', 'Tidak'),
        `campak` ENUM ('Ya', 'Tidak'),
        `dpt_combo_booster` ENUM ('Ya', 'Tidak'),
        `campak_booster` ENUM ('Ya', 'Tidak'),
        `hasil_bb` ENUM('Resiko Berlebih', 'Sangat Kurang', 'Kurang', 'Normal'),
        `hasil_tb` ENUM('Sangat Pendek', 'Pendek', 'Normal', 'Tinggi'),
        `hasil_gizi` ENUM('Gizi Buruk', 'Gizi Kurang', 'Gizi Lebih', 'Gizi Baik', 'Obesitas'),
        `warning_sign` tinyint(1) DEFAULT 0,
        `intervensi` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`),
        KEY `anak` (`anak`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `pengukuran`");
  }

}