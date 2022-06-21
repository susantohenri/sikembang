<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_posyanduprovkabkec extends CI_Migration {

  function up () {
    $this->db->query("ALTER TABLE `posyandu`  ADD `provinsi` VARCHAR(255) NOT NULL  AFTER `alamat`,  ADD `kabupaten_kota` VARCHAR(255) NOT NULL  AFTER `provinsi`,  ADD `puskesmas_kecamatan` VARCHAR(255) NOT NULL  AFTER `kabupaten_kota`;");
  }

  function down () {
    $this->db->query("ALTER TABLE `posyandu` DROP `provinsi`, DROP `kabupaten_kota`, DROP `puskesmas_kecamatan`;");
  }

}