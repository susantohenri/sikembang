<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
<form enctype='multipart/form-data' action="<?= site_url($current['controller']) ?>" method="POST" class="main-form col-sm-12">
    <div class="card card-warning card-outline">
        <div class="card-header text-right">
            <?php if ((empty($uuid) && in_array("create_{$current['controller']}", $permission)) || (!empty($uuid) && in_array("update_{$current['controller']}", $permission))) : ?>
                <button class="btn btn-info btn-save"><i class="fa fa-save"></i> &nbsp; Save</button>
            <?php endif ?>
            <?php if (!empty($uuid) && in_array("delete_{$current['controller']}", $permission)) : ?>
                <a href="<?= site_url($current['controller'] . "/delete/$uuid") ?>" class="btn btn-danger"><i class="fa fa-trash"></i> &nbsp; Delete</a>
            <?php endif ?>
            <a href="<?= site_url($current['controller']) ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Cancel</a>
        </div>

        <div class="card-body">

            <div class="" data-controller="<?= $current['controller'] ?>">
                <div class="form-horizontal form-groups">

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Upload Jadwal Imunisasi</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="file" name="imunisassi">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</form>