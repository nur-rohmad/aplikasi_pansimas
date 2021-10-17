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
                 <div class="col-lg-4 col-6">
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

                 <div class="col-lg-4 col-6">
                     <!-- small box -->
                     <div class="small-box bg-success">
                         <div class="inner">
                             <h3> Rp. <?= number_format($total_pendaptan, 2, ',', '.'); ?></h3>

                             <p>Pendapatan Bulan Ini</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-hand-holding-usd"></i>
                         </div>
                         <a href="<?= base_url('operator/transaksi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                     </div>
                 </div>

                 <div class="col-lg-4 col-6">
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
             <div class="card">
                 <div class="card-header">
                     <h3 class="text-center">Data Penggunaan Air Setahun Terakir</h3>
                 </div>
                 <div class="card-body">
                     <div class="row mt-2">
                         <canvas id="myChart"></canvas>
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
     <!-- /.content -->
 </div>

 <script src="<?= base_url('resource/adminlte31/') ?>plugins/chart.js/Chart.js ?>"></script>
 <script>
     var ctx = document.getElementById('myChart').getContext('2d');
     var chart = new Chart(ctx, {
         // The type of chart we want to create
         type: 'bar',
         // The data for our dataset
         data: {
             labels: [<?= $label; ?>],
             datasets: [{
                 label: 'Data Jumlah Meteran ',
                 backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)', 'rgb(210,105,30)', 'rgb(255,0,255)', 'rgba(25,25,112)', 'rgb(144,238,144)', 'rgb(128,0,0)', 'rgb(255,255,0)', 'rgba(255,0,0)', 'rgb(47,79,79)', 'rgb(138,43,226)'],
                 borderColor: ['rgb(255, 99, 132)'],
                 data: [<?= $jumlah; ?>]
             }]
         },

         // Configuration options go here
         options: {
             scales: {
                 yAxes: [{
                     ticks: {
                         beginAtZero: true
                     }
                 }]
             }
         }
     });
 </script>