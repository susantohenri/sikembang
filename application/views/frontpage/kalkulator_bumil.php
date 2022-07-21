<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<form action="" method="POST" class="main-form col-sm-12" id="form_kalkulator_bumil">
    <div class="card card-warning card-outline">
        <div class="card-body">

            <div class="" data-controller="<?= $current['controller'] ?>">
                <div class="form-horizontal form-groups">

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Umur Kehamilan Anda</label>
                        <div class="col-sm-9">
                            <select name="umur_kehamilan" class="form-control">
                                <?php for ($umur = 1; $umur <= 40; $umur++) : ?>
                                    <option value="<?= $umur ?>"><?= $umur ?> Minggu</option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>

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

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Berat Badan Anda Sekarang</label>
                        <div class="col-sm-9 input-group">
                            <input class="form-control" type="text" value="" name="berat_badan_sekarang">
                            <div class="input-group-append">
                                <span class="input-group-text">Kg</span>
                            </div>
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
<div class="col-sm-12 hasil_perhitungan">
    <div class="card card-warning card-outline">
        <div class="card-body">

            <div class="form-horizontal form-groups">

                <div class="form-group row">
                    <label class="col-sm-4 control-label">IMT atau BMI</label>
                    <div class="col-sm-3" id="bmi">12 Kg/m<sup>2</sup></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label">IMT Sebelum Kehamilan</label>
                    <div class="col-sm-3" id="imt_sebelum_kehamilan">Underweight</div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label">Total Kenaikan Berat Badan Anda</label>
                    <div class="col-sm-6" id="total_kenaikan_berat_badan">10Kg (nilai ideal: 12,5Kg - 18Kg)</div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label">Rata-rata Kenaikan Berat Badan Anda</label>
                    <div class="col-sm-6" id="rata2_kenaikan_berat_badan_per_minggu">0,4Kg/minggu (nilai ideal: 0,44Kg/minggu - 0,58Kg/minggu)</div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12" id="penjelasan">
                        Anda mengalami kekurangan berat badan saat hamil, artinya Anda harus mengejar kenaikan berat badan dengan cepat. Hal normal bila berat badan turun selama trimester pertama karena mual muntah di pagi hari. Namun, berat badan Anda semestinya sudah kembali optimal sejak trimester kedua dan ketiga. Kekurangan berat badan saat hamil meningkatkan risiko bayi lahir prematur dan prosedur operasi caesar. Anda perlu meningkatkan berat badan secepatnya agar mencapai bobot tubuh ideal bagi ibu hamil. Caranya dengan mengonsumsi makanan dalam jumlah kalori yang direkomendasikan. Bila kenaikan berat badan Anda belum cukup cobalah makan dalam jumlah yang lebih banyak sambil tetap menghindari makanan instan. Upayakan menyantap makanan padat nutrisi dan berasal dari sumber yang bervariasi. Misalnya susu rendah lemak, gandum utuh, buah-buahan, dan sayuran. Sehingga Anda dapat menyerap berbagai nutrisi yang dibutuhkan oleh tubuh. Pastikan pula Anda memperoleh asupan kalsium yang cukup, asam folat, zat besi, vitamin A, vitamin D, DHA, dan protein. Berhentilah menenggak minuman beralkohol serta kurangi asupan kafein dan makanan asin. Bila Anda belum juga berhasil menaikkan berat badan sesuai target, berkonsultasilah ke dokter atau ahli gizi untuk membantu merencanakan pola makan yang tepat untuk Anda.
                    </div>
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