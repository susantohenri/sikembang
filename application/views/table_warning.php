<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.css') ?>">
<div class="col-sm-12">
    <div class="card card-warning card-outline">
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
<script type="text/javascript">
    var thead = [{
        "mData": "orders",
        "sTitle": "No",
        "visible": false,
        "searchable": false
    }, {
        "mData": "createdAt",
        "sTitle": "Waktu",
        "searchable": false
    }, {
        "mData": "anak",
        "sTitle": "Anak",
        "searchable": false
    }];
    var allow_read = 1
</script>