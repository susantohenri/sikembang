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
        <div class="card-header text-center">
            <h4>Status Gizi BB/U</h4>
        </div>
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
        var canvas = document.getElementById('chart')
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                        label: 'Sangat Kurang',
                        yAxisID: 'A',
                        data: [60, 70, 80, 90, 100],
                        type: 'bar',
                        backgroundColor: 'lightblue'
                    },
                    {
                        label: 'Kurang',
                        yAxisID: 'A',
                        data: [10, 20, 30, 40, 50],
                        type: 'bar',
                        backgroundColor: 'orange'
                    },
                    {
                        label: 'Resiko Lebih',
                        yAxisID: 'A',
                        data: [10, 20, 30, 40, 50],
                        type: 'bar',
                        backgroundColor: 'yellow'
                    },
                    {
                        label: 'Normal',
                        yAxisID: 'B',
                        data: [1, 0.4, 0.8, 0.4, 0],
                        type: 'line',
                        fill: false,
                        borderColor: 'green',
                        lineTension: 0
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                    }, {
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            max: 1,
                            min: 0
                        }
                    }]
                }
            }
        })

    })
</script>