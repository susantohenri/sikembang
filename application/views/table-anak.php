<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
<style type="text/css">
    .select2-container {
        width: 100% !important;
        padding: 0;
    }
</style>
<div class="col-sm-12">
    <div class="card card-warning card-outline">
        <div class="card-header text-right">
            <?php if (in_array("create_{$current['controller']}", $permission)) : ?>
                <div class="col-sm-12 text-right">
                    <a href="<?= site_url($current['controller'] . '/download') ?>" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-download"></i> Download
                    </a>
                    <a href="<?= site_url($current['controller'] . '/create') ?>" class="btn btn-warning">
                        <i class="fa fa-plus"></i>&nbsp;Input <?= $page_title ?> Baru
                    </a>
                </div>
            <?php endif ?>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-striped datatable table-model">
                <tfoot>
                    <tr>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div><!-- /.card -->
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Desa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control" name="desa">
                    <option></option>
                    <?php foreach ($desas as $desa): ?>
                        <option value="<?= $desa->uuid ?>"><?= $desa->nama ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <a class="btn btn-info btn-download">
                    Download
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var thead = <?= json_encode($thead) ?>;
    var allow_read = <?= in_array("read_{$current['controller']}", $permission) ?>
</script>