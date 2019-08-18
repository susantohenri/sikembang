<div class="col-sm-12">
    <div class="card card-primary card-outline">
      <div class="card-body">

        <form action="<?= site_url($current['controller']) ?>" class="form-horizontal form-groups" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="last_submit" value="<?= time() ?>">
            <input type="hidden" name="delete" value="<?= $uuid ?>">

            <div class="text-center">
              <h1>Are you sure ?</h1>
              <button class="btn btn-danger"><i class="fa fa-check"></i> &nbsp; Yes</button>
              <a href="<?= site_url($current['controller']) ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp; No</a>
            </div>
        </form>

      </div>
    </div><!-- /.card -->
</div>