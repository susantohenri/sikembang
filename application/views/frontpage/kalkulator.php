    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
    <form action="" method="POST" class="main-form col-sm-12" id="form_kalkulator">
        <div class="card card-warning card-outline">
            <div class="card-body">

                <div class="" data-controller="<?= $current['controller'] ?>">
                    <div class="form-horizontal form-groups">

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Jenis Perhitungan</label>
                            <div class="col-sm-9">
                                <select name="jenis_kalkulator" class="form-control">
                                    <option value="bb">Berat Badan / Usia</option>
                                    <option value="tb">Tinggi Badan / Usia</option>
                                    <option value="bbtb">Tinggi Badan / Tinggi Badan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
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
            <div class="card-footer text-right">
                <a id="submit" class="btn btn-info btn-save"><i class="fa fa-calculator"></i> &nbsp; Hitung</a>
            </div>
        </div>
    </form>
    <div class="col-sm-12">
        <div class="card card-warning card-outline">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h1><b>Hasil Perhitungan, </b><i style="color: #ffab00" id="result"></i></h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let bb = $('[name="bb"]').parent().parent()
            let tb = $('[name="tb"]').parent().parent()
            $('[name="jenis_kalkulator"]').change(function() {
                bb.hide().find('input').val('')
                tb.hide().find('input').val('')
                $('#result').html('belum tersedia')
                switch ($(this).val()) {
                    case 'bb':
                        bb.show();
                        break
                    case 'tb':
                        tb.show();
                        break
                    case 'bbtb':
                        bb.show()
                        tb.show();
                        break
                }
            }).val('bb').trigger('change')

            $('#submit').click(function() {
                var data = {}
                $('#form_kalkulator')
                    .find('input, select')
                    .each(function() {
                        data[$(this).attr('name')] = $(this).val()
                    })
                $.post('', data, function(result) {
                    $('#result').html(result)
                })
            })
        });
    </script>