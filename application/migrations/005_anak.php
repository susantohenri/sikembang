<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_anak extends CI_Migration {

  function up () {

    $this->db->query("
      CREATE TABLE `anak` (
        `uuid` varchar(255) NOT NULL,
        `orders` INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
        `createdAt` datetime DEFAULT NULL,
        `updatedAt` datetime DEFAULT NULL,
        `no_kk` varchar(255) NOT NULL,
        `nik` varchar(255) NOT NULL,
        `anak_ke` varchar(255) NOT NULL,
        `nama` varchar(255) NOT NULL,
        `tgl_lahir` DATE NOT NULL,
        `jenis_kelamin` ENUM ('Lelaki', 'Perempuan'),
        `bb_lahir` int(11) NOT NULL,
        `tb_lahir` int(11) NOT NULL,
        `nama_ayah` varchar(255) NOT NULL,
        `nama_ibu` varchar(255) NOT NULL,
        `tlp_ortu` varchar(255) NOT NULL,
        `alamat` varchar(255) NOT NULL,
        `rt` varchar(255) NOT NULL,
        `rw` varchar(255) NOT NULL,
        `bpjs` ENUM ('Ya', 'Tidak'),
        `imd` ENUM ('Ya', 'Tidak'),
        `posyandu` varchar(255) NOT NULL,
        PRIMARY KEY (`uuid`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

  }

  function down () {
    $this->db->query("DROP TABLE IF EXISTS `anak`");
  }

}