<?php if ('form' === $view_switch) : ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
    <form action="" method="POST" class="main-form col-sm-12">
        <div class="card card-warning card-outline">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button class="btn btn-info btn-save"><i class="fa fa-calculator"></i> &nbsp; Hitung</button>
                        <a href="<?= site_url('Frontpage') ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Batal</a>
                    </div>
                </div>
                <br>

                <div class="" data-controller="<?= $current['controller'] ?>">
                    <div class="form-horizontal form-groups">
                        <input type="hidden" name="last_submit" value="<?= time() ?>">

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="" name="nama">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="" name="tgl_lahir" data-date="datepicker" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Berat Badan</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="" name="bb">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Tinggi Badan</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="" name="tb">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>
<?php else : ?>
    <div class="col-sm-12">
        <div class="card card-warning card-outline">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h1><b>Nama Anak,</b><i style="color: #ffab00"> Gizi Baik</i></h1>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="" class="btn btn-info"><i class="fa fa-calculator"></i> &nbsp; Hitung Lagi</a>
                        <a href="<?= site_url('Frontpage') ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> &nbsp; Kembali</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif ?>