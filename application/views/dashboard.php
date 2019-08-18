<?php foreach (array('User', 'Role') as $controller) : ?>

<div class="col-md-2">
  <a href="<?= site_url($controller) ?>">
    <div class="card card-primary collapsed-card">
      <div class="card-header">
        <h3 class="card-title"><?= $controller ?></h3>
      </div>
    </div>
  </a>
</div>

<?php endforeach; ?>