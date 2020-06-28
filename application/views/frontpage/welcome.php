<div class="col-sm-12">
	<div class="card card-warning card-outline">
		<div class="card-body">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<?php foreach ($artikels as $index => $artikel) : ?>
						<div class="carousel-item <?= 0 === $index ? 'active' : '' ?>">
							<a href="<?= site_url("Frontpage/artikel/{$artikel->uuid}") ?>">
								<img class="d-block w-100" src="<?= base_url($artikel->gambar) ?>">
								<div style="position: absolute; top: 25%; color: #fff; width: 100%; text-align: center; padding: 0 10% 0 10%">
									<h1><?= $artikel->judul ?></h1>
									<p><?= substr($artikel->konten, 0, 490) ?>, selengkapnya ...</p>
								</div>
							</a>
						</div>
					<?php endforeach ?>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="col-sm-3">
	<a href="<?= site_url('Frontpage/kalkulator') ?>">
		<div class="info-box">
			<span class="info-box-icon bg-warning"><i class="fas fa-calculator"></i></span>
			<div class="info-box-content">
				<span class="info-box-text" style="color: #000">Kalkulator Gizi</span>
				<span class="info-box-number"></span>
			</div>
		</div>
	</a>
</div>

<div class="col-sm-3">
	<a href="<?= site_url('Frontpage/imunisasi') ?>">
		<div class="info-box">
			<span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
			<div class="info-box-content">
				<span class="info-box-text" style="color: #000">Jadwal Imunisasi</span>
				<span class="info-box-number"></span>
			</div>
		</div>
	</a>
</div>

<div class="col-sm-3">
	<a href="<?= site_url('Frontpage/bidan') ?>">
		<div class="info-box">
			<span class="info-box-icon bg-warning"><i class="fas fa-user-md"></i></span>
			<div class="info-box-content">
				<span class="info-box-text" style="color: #000">Daftar Bidan</span>
				<span class="info-box-number"></span>
			</div>
		</div>
	</a>
</div>

<div class="col-sm-3">
	<a href="<?= site_url('Frontpage/faskes') ?>">
		<div class="info-box">
			<span class="info-box-icon bg-warning"><i class="fas fa-hospital"></i></span>
			<div class="info-box-content">
				<span class="info-box-text" style="color: #000">Fasilitas Kesehatan</span>
				<span class="info-box-number"></span>
			</div>
		</div>
	</a>
</div>