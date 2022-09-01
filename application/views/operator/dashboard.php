<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php foreach ($this->uri->segments as $segment) : ?>
                            <?php
                            $url = substr($this->uri->uri_string, 0, strpos($this->uri->uri_string, $segment)) . $segment;
                            $is_active =  $url == $this->uri->uri_string;
                            ?>
                            <li class="breadcrumb-item <?php echo $is_active ? 'active' : '' ?>">
                                <?php if ($is_active) : ?>
                                    <?php echo ucfirst($segment) ?>
                                <?php else : ?>
                                    <a href="<?php echo site_url($url) ?>"><?php echo ucfirst($segment) ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <div class="row pt-3">
                                <div class="col-6">
                                    <h5 class="text-left">Halo Selamat <img src="<?= base_url('resource/adminlte31/img/waktu/' . $waktu . '.png') ?>" style="width: 30px;" alt=""> <?= $profile['user_alias'] ?></h5>
                                </div>
                                <div class="col-6 text-right">
                                    <h4 id="jam" class="text-danger bold"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row  ">
                <div class="col-lg-4 col-md-12 ">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $total_pelanggan; ?></h3>

                            <p>Pelanggan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="<?= base_url('operator/pelanggan') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3> Rp. <?= number_format($total_pendaptan, 0, ',', '.'); ?></h3>

                            <p>Pendapatan Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <a href="<?= base_url('operator/transaksi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php if ($total_meteran !== null) : ?>
                                <h3><?= $total_meteran; ?></h3>
                            <?php else : ?>
                                <h3>0</h3>
                            <?php endif; ?>

                            <p>Jumlah Meteren Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-faucet"></i>
                        </div>
                        <a href="<?= base_url('operator/transaksi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="">Data Pelanggan Berdasarkan Dusun</h5>
                        </div>
                        <div class="card-body my-3 pt-2">
                            <div id="myChart1"></div>
                            <?php
                            $label_donut = "";
                            $jumlah_donut = null;
                            foreach ($data_cahart_donut as $data) {
                                $rw = "Dusun Bintoyo 0" . $data['rw_pelanggan'];

                                $label_donut .= "'$rw'" . ", ";
                                //mengambil data jumlah 
                                $total = (int)$data['total'];
                                $jumlah_donut .= "$total" . ", ";
                            };

                            ?>

                        </div>
                        <div class="card-footer bg-primary py-2 text-right pr-3">
                            TOTAL : <?= $total_pelanggan; ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="">Data Pendapatan Satu Tahun Terakir</h5>
                            <!-- <select class="form-control select-2" id="tahun" name="nama_pelanggan" id="nama_pelanggan">

                                 <?php foreach ($tahun as $result) : ?>
                                     <option value="<?= $result['tahun']; ?>"><?= $result['tahun']; ?> </option>
                                 <?php endforeach; ?>
                             </select> -->
                        </div>
                        <div class="card-body mx-1">
                            <div id="myChart"></div>
                            <?php
                            $label = "";
                            $jumlah = null;
                            foreach ($data_cart as $data) {
                                $bulan = format_indo($data['tanggal_transaksi']);

                                $label .= "'$bulan'" . ", ";
                                //mengambil data jumlah 
                                $total = $data['jumlah'];
                                $jumlah .= "'$total'" . ", ";
                            };

                            ?>

                        </div>

                    </div>
                </div>

            </div>



        </div>

    </div>
    <!-- /.content -->
</div>


<script src="<?= base_url('resource/adminlte31/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/chart.js/Chart.js ?>"></script>
<script src="<?= base_url('resource/adminlte31/') ?>js/apexcharts.min.js ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->


<script>
    var options = {
        series: [{
            data: [<?= $jumlah; ?>],
            name: 'Tagihan',
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                borderRadius: 4,
                horizontal: true,
            }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'
        ],
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#fff']
            },
            formatter: function(val, opt) {
                return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
            },
            offsetX: 0,
            dropShadow: {
                enabled: true
            }
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: [<?= $label; ?>],
        }
    };

    var chart = new ApexCharts(document.getElementById('myChart'), options);
    chart.render();
</script>

<script>
    console.log([<?= $label_donut ?>])
    var options = {
        series: [<?= $jumlah_donut ?>],
        labels: [
            <?= $label_donut ?>,
        ],
        colors: ["#ff5252", "#fd7e14", "#9ccc65"],
        chart: {
            toolbar: {
                show: true,
                offsetX: 0,
                offsetY: 0,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true | '<img src="/static/icons/reset.png" width="20">',
                    customIcons: []
                },
                export: {
                    csv: {
                        filename: undefined,
                        columnDelimiter: ',',
                        headerCategory: 'category',
                        headerValue: 'value',
                        dateFormatter(timestamp) {
                            return new Date(timestamp).toDateString()
                        }
                    },
                    svg: {
                        filename: 'chart-jumlah-pelanggan',
                    },
                    png: {
                        filename: 'chart-jumlah-pelanggan',
                    }
                },
                autoSelected: 'zoom'
            },
            height: 350,
            type: 'donut',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300,
                },
                legend: {
                    position: 'right'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.getElementById('myChart1'), options);
    chart.render();
</script>
<script type="text/javascript">
    window.onload = function() {
        jam();
    }

    function jam() {
        var e = document.getElementById('jam'),
            d = new Date(),
            h, m, s;
        h = set(d.getHours());
        m = set(d.getMinutes());
        s = set(d.getSeconds());

        e.innerHTML = h + ':' + m + ':' + s;

        setTimeout('jam()', 1000);
    }

    function set(e) {
        e = e < 10 ? '0' + e : e;
        return e;
    }
</script>