<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<form action="" method="POST" class="main-form col-sm-12" id="form_kalkulator_bumil">
    <div class="card card-warning card-outline">
        <div class="card-body">

            <div class="" data-controller="<?= $current['controller'] ?>">
                <div class="form-horizontal form-groups">

                    <!-- <div class="form-group row">
                        <label class="col-sm-3 control-label">Umur Kehamilan Anda</label>
                        <div class="col-sm-9">
                            <select name="umur_kehamilan" class="form-control">
                                <?php for ($umur = 1; $umur <= 40; $umur++) : ?>
                                    <option value="<?= $umur ?>"><?= $umur ?> Minggu</option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Berat Badan Anda Sebelum Hamil</label>
                        <div class="col-sm-9 input-group">
                            <input class="form-control" type="text" value="" name="berat_badan_sebelum_hamil">
                            <div class="input-group-append">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Tinggi Badan Anda</label>
                        <div class="col-sm-9 input-group">
                            <input class="form-control" type="text" value="" name="tinggi_badan">
                            <div class="input-group-append">
                                <span class="input-group-text">Cm</span>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label class="col-sm-3 control-label">Berat Badan Anda Sekarang</label>
                        <div class="col-sm-9 input-group">
                            <input class="form-control" type="text" value="" name="berat_badan_sekarang">
                            <div class="input-group-append">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            <a id="submit" class="btn btn-info btn-save"><i class="fa fa-calculator"></i> &nbsp; Hitung</a>
        </div>
    </div>
</form>
<div class="col-sm-12 hasil_perhitungan">
    <div class="card card-warning card-outline">
        <div class="card-body">

            <div class="form-horizontal form-groups">

                <div class="form-group row">
                    <label class="col-sm-4 control-label">IMT atau BMI</label>
                    <div class="col-sm-3" id="bmi"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label">IMT Sebelum Kehamilan</label>
                    <div class="col-sm-3" id="imt_sebelum_kehamilan"></div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-sm-4 control-label">Total Kenaikan Berat Badan Anda</label>
                    <div class="col-sm-6" id="total_kenaikan_berat_badan"></div>
                </div> -->

                <!-- <div class="form-group row">
                    <label class="col-sm-4 control-label">Rata-rata Kenaikan Berat Badan Anda</label>
                    <div class="col-sm-6" id="rata2_kenaikan_berat_badan_per_minggu"></div>
                </div> -->

                <div class="form-group row">
                    <div class="col-sm-12" id="penjelasan"></div>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        $('.hasil_perhitungan').hide()
        $('#submit').click(function() {
            var data = {}
            $('#form_kalkulator_bumil')
                .find('input, select')
                .each(function() {
                    data[$(this).attr('name')] = $(this).val()
                })
            $.post('', data, function(result) {
                result = JSON.parse(result)
                for (var index in result) $(`#${index}`).html(result[index])
                $('.hasil_perhitungan').show()
            })
        })
    });
</script>