<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.css') ?>">
<form action="" method="POST" class="main-form col-sm-12" id="form_infografis">
    <div class="card card-warning card-outline">
        <div class="card-body">
            <div class="" data-controller="<?= $current['controller'] ?>">
                <div class="form-horizontal form-groups">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Sejak Tanggal</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="<?= $since ?>" name="since" data-date="datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Hingga Tanggal</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="<?= $until ?>" name="until" data-date="datepicker" autocomplete="off">
                        </div>
                    </div>
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
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button id="submit" class="btn btn-info btn-save"><i class="fa fa-chart-line"></i> &nbsp; Submit</button>
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

        var ctx = document.getElementById('chart').getContext('2d')
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sangat Kurang',
                    backgroundColor: 'lightblue',
                    data: [1, 2, 3, 4, 5, 6, 7]
                }, {
                    label: 'Kurang',
                    backgroundColor: 'orange',
                    data: [2, 4, 6, 8, 10, 12, 14]
                }, {
                    label: 'Resiko Lebih',
                    backgroundColor: 'yellow',
                    data: [1, 2, 3, 4, 5, 6, 7]
                }, {
                    label: 'Normal',
                    borderColor: 'green',
                    data: [600, 100, 200, 500, 300, 700, 400],
                    yAxisID: 'KANAN',
                    type: 'line',
                    fill: false,
                    lineTension: 0
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        id: 'KIRI',
                        type: 'linear',
                        position: 'left',
                    }, {
                        id: 'KANAN',
                        type: 'linear',
                        position: 'right'
                    }]
                }
            }
        })


    })
</script>