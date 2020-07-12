<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
<form action="" method="POST" class="main-form col-sm-12" id="form_infografis">
    <div class="card card-warning card-outline">
        <div class="card-body">
            <div class="" data-controller="<?= $current['controller'] ?>">
                <div class="form-horizontal form-groups">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Jenis Perhitungan</label>
                        <div class="col-sm-9">
                            <select name="jenis" class="form-control">
                                <option value="bb">Berat Badan (BB/U)</option>
                                <option value="tb">Tinggi Badan (TB/U)</option>
                                <option value="gizi">Gizi (BB/TB)</option>
                                <option value="imd">Inisiasi Menyusu Dini</option>
                                <option value="asi">Asi Ekslusif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Sejak Tanggal</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="since" data-date="datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Hingga Tanggal</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="until" data-date="datepicker" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a id="submit" class="btn btn-info btn-submit"><i class="fa fa-chart-line"></i> &nbsp; Filter</a>
            <a class="btn btn-primary btn-download" download="sikembang.jpg"><i class="fa fa-image"></i> &nbsp; Download</a>
        </div>
    </div>
</form>
<div class="col-sm-12">
    <div class="card card-warning card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        $('.btn-download').hide()
        $('[name="jenis"]').change(function() {
            var since = $('[name="since"]').parent().parent()
            var until = $('[name="until"]').parent().parent()
            if (['bb', 'tb', 'gizi'].indexOf($(this).val()) > -1) {
                since.show()
                until.show()
            } else {
                since.hide()
                until.hide()
            }
        })

        var ctx = document.getElementById('chart').getContext('2d')
        $('.btn-submit').click(function() {
            if (window.myBar) window.myBar.destroy()
            var params = {}
            $('#form_infografis').find('input, select').each(function() {
                params[$(this).attr('name')] = $(this).val()
            })
            $.post('', params, function(data) {
                data = JSON.parse(data)
                data.options.animation = {}
                data.options.animation.onComplete = function() {
                    ctx.save()
                    ctx.globalCompositeOperation = 'destination-over'
                    ctx.fillStyle = 'white'
                    ctx.fillRect(0, 0, window.myBar.chart.width, window.myBar.chart.height)
                    ctx.restore()
                    $('.btn-download')
                        .attr('href', window.myBar.toBase64Image())
                        .show()
                }
                window.myBar = new Chart(ctx, data)
            })
        })
    })
</script>