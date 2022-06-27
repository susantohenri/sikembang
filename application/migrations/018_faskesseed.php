<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_faskesseed extends CI_Migration {

  var $faskes = array(
    array('nama' => 'Selo', 'alamat' => 'Jl. Ki Hajar Saloka RT.04 / RW.21, Ds.Samiran, Kec. Selo, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Cepogo', 'alamat' => 'Jl. Raya Cepogo Km. 11, RT.01 / RW.01, Kec. Cepogo, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Ampel', 'alamat' => 'Ds.Candi, RT.04 / RW.06, Kec. Ampel, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Gladaksari', 'alamat' => 'Jl. Ampel-Pantaran Km.5, Ds. Candisari, Kec. Gladagsari, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Musuk', 'alamat' => 'Dk. Drajidan, Ds. Sruni, RT.02 / RW.01, Kec. Musuk, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Tamansari', 'alamat' => 'Ds. Karanganyar RT.01 / RW.01, Kec. Tamansari, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Boyolali I', 'alamat' => 'Jl. Jambu No.11, Kel. Siswodipuran, Kec. Boyolali, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Boyolali II', 'alamat' => 'Jl. Tentara Pelajar Km.08, Ds. Mudal, Kec. Boyolali, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Mojosongo', 'alamat' => 'Boyolali-Solo KM.3, RT.04 / RW.01, Kec. Mojosongo, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Teras', 'alamat' => 'Jl. Raya Solo - Semarang, Ds. Nepen, Kec. Teras, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Sawit', 'alamat' => 'Dk. Gading RT.01/RW.02, Ds. Jenengan, Kec. Sawit, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Boyudono I', 'alamat' => 'Ds. Ketaon RT.21 / RW.03, Kec. Banyudono, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Boyudono II', 'alamat' => 'Dk. Jatisari, Ds. Sambon, RT.07 / RW.02, Kec. Banyudono, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Sambi', 'alamat' => 'Jl. Bangak - Simo Km.7, Ds. Tempursari, Kec. Sambi, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Simo', 'alamat' => 'Ds. Pelem, Kec. Simo, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Ngemplak', 'alamat' => ' Ds. Donohudan, Jl. Ngemplak RT.01 / RW.01, Kec. Ngemplak, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Nogosari', 'alamat' => 'Ds. Glonggong, Jl. Nogosari - Kartasura Km.1, Kec. Nogosari, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Klego I', 'alamat' => 'Ds. Klego RT.08 / RW.02, Kec. Klego, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Klego II', 'alamat' => 'Dk. Selorejo, Ds. Sumberagung RT.14 / RW.03, Kec. Klego, kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Andong', 'alamat' => 'Ds. Mojo RT.21 / RW.08, Kec. Andong, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Karanggede', 'alamat' => 'Dk. Trayon, Ds. Kebonan, Kec. Karanggede, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Wonosegoro', 'alamat' => 'RT.05 / RW.03, Kec. Wonosegoro, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Wonosamodro', 'alamat' => 'Dk. Traban RT.01 / RW.01, Ds. Repaking, Kec. Wonosamodro, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Kemusu', 'alamat' => 'Ds. Klewor, Jl. Klewor RT.04 / RW.01, Kec. Kemusu, Kab. Boyolali', 'telepon' => ''),
    array('nama' => 'Juwangi', 'alamat' => 'Jl. Juwangi - Kedung Ombo Km.01, Ds. Pilangrejo, Kec. Juwangi, Kab. Boyolali', 'telepon' => '')
  );

  function up () {
    $this->load->model('Faskess');
    foreach ($this->faskes as $puskesmas) $this->Faskess->create($puskesmas);
  }

  function down () {
    foreach ($this->faskes as $puskesmas) $this->db->where($puskesmas)->delete('faskes');
  }

}