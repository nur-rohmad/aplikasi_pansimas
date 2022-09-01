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
             <div class="row">
                 <div class="col-12">
                     <div class="card">
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
             <div class="row">
                 <div class="col-lg-6 col-md-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="text-center">Data Tagihan Bulan <?= format_indo(date("Y-m-d")) ?></h5>
                         </div>
                         <div class="card-body">
                             <div class="row">
                                 <div class="col-md-12 col-lg-6">
                                     <!-- small box -->
                                     <div class="small-box bg-success">
                                         <div class="inner">
                                             <?php if ($total_meteran != null) : ?>
                                                 <h3> Rp. <?= number_format($total_pendaptan, 0, ',', '.'); ?></h3>
                                             <?php else : ?>
                                                 <h3>Rp. 0</h3>
                                             <?php endif; ?>
                                             <p>Pengeluaran Bulan Ini</p>
                                         </div>
                                         <div class="icon">
                                             <i class="fas fa-hand-holding-usd"></i>
                                         </div>
                                         <a href="<?= base_url('pelanggan/tagihan') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                     </div>
                                 </div>
                                 <div class="col-md-12 col-lg-6">
                                     <!-- small box -->
                                     <div class="small-box bg-danger">
                                         <div class="inner">
                                             <?php if ($total_meteran != null) : ?>
                                                 <h3><?= $total_meteran['jumlah_meteran']; ?> m<sup>3</sup></h3>
                                             <?php else : ?>
                                                 <h3>0</h3>
                                             <?php endif; ?>

                                             <p>Jumlah Meteren Bulan Ini</p>
                                         </div>
                                         <div class="icon">
                                             <i class="fas fa-faucet"></i>
                                         </div>
                                         <a href="<?= base_url('pelanggan/tagihan') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>
                 <div class="col-lg-6 col-md-12">
                     <div class="card">
                         <div class="card-header">
                             <h5 class="text-center">Data Pengeluaran Air Satu Tahun Terakir</h5>
                         </div>
                         <div class="card-body">

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

 <script src="<?= base_url('resource/adminlte31/') ?>plugins/chart.js/Chart.js ?>"></script>
 <script src="<?= base_url('resource/adminlte31/') ?>js/apexcharts.min.js ?>"></script>

 <script>
     var options = {
         series: [{
             data: [<?= $jumlah; ?>],
             name: 'Tagihan',
         }],
         chart: {
             height: 350,
             type: 'line',
             dropShadow: {
                 enabled: true,
                 color: '#000',
                 top: 18,
                 left: 7,
                 blur: 10,
                 opacity: 0.2
             },
             toolbar: {
                 show: true
             }
         },
         markers: {
             size: 1
         },
         title: {
             text: 'Grafik Tagihan Pelanggan '
         },

         colors: ['#fc0335'],
         dataLabels: {
             enabled: true,
         },
         stroke: {
             stroke: {
                 width: [0, 4]
             },
         },
         xaxis: {
             categories: [<?= $label; ?>],
             title: {
                 text: 'Bulan Tagihan',
             },
         },
         yaxis: [{
             title: {
                 text: 'Jumlah Tagihan',
             },
         }]
     }

     var chart = new ApexCharts(document.querySelector("#myChart"), options);
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