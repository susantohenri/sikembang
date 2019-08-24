<?php foreach ($menu as $m) : ?>

<div class="col-sm-2">
	<a href="<?= site_url($m->url) ?>">
	  <div class="info-box">
	    <span class="info-box-icon bg-info"><i class="fas fa-<?= $m->icon ?>"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text"><?= $m->name ?></span>
	      <span class="info-box-number"></span>
	    </div>
	  </div>
	</a>
</div>

<?php endforeach; ?>