 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <a href="<?= base_url('operator/pelanggan') ?>" class="btn btn-md btn-outline-dark float-left mr-2"><i class="fas fa-arrow-left"></i></a>
                     <h1 class="">Detail Pelanggan</h1>
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

     <!-- content -->
     <div class="content mt-4">
         <div class="row">
             <div class="col-md-6">
                 <!-- data pelanggan -->
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-header bg-primary">
                             <h3 class="card-title">Data Pelanggan</h3>
                             <button class="btn btn-sm btn-dark float-right" id="button_qr"> <i class="fas fa-qrcode"></i> Kode QR </button>
                             <button class="btn btn-sm btn-dark float-right d-none" type="button" id="btn_qr_loading" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                         </div>
                         <div class="card-body">
                             <table width="100%" style="line-height: 30px;">
                                 <tr>
                                     <td width="10%">ID Pelanggan</td>
                                     <td width="1%" align="center">:</td>
                                     <td width="25%"><?= $pelanggan['id_pelanggan'] ?></td>
                                 </tr>
                                 <tr>
                                     <td width="10%">Nama Pelanggan</td>
                                     <td width="1%" align="center">:</td>
                                     <td width="25%"><?= $pelanggan['name_pelanggan'] ?></td>
                                 </tr>
                                 <tr>
                                     <td width="10%">Alamat Pelanggan</td>
                                     <td width="1%" align="center">:</td>
                                     <td width="25%">Bintoyo, RW. 0<?= $pelanggan['rw_pelanggan']; ?>,
                                         <?php if ($pelanggan['rt_pelanggan'] >= 10) : ?>
                                             RT. <?= $pelanggan['rt_pelanggan']; ?>
                                         <?php else : ?>
                                             RT. 0<?= $pelanggan['rt_pelanggan']; ?>
                                     </td>
                                 <?php endif; ?></td>
                                 </tr>

                             </table>
                         </div>
                     </div>
                 </div>
                 <!-- end data pelanggan -->
                 <!-- riwayat tagihan pelanggan -->
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-header bg-danger">
                             <h3 class="card-title">Riwayat Tagihan Pelanggan</h3>
                             <button class="btn btn-sm btn-dark float-right"> <i class="fas fa-download"></i> Download Riwayat Tagihan </button>
                         </div>
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th class="text-center align-middle" widht="10%">No</th>
                                             <th width="30%" class="text-center align-middle">Bulan Tagihan</th>
                                             <th class="text-center">Awal Meteran</th>
                                             <th class="text-center">Akhir Meteran</th>
                                             <th class="text-center">Jumlah Meteran</th>
                                             <th width="20%" class="text-center">Total Bayar</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php if ($riwayat != null) : ?>
                                             <?php $i = 1; ?>
                                             <?php foreach ($riwayat as $data) : ?>
                                                 <tr>
                                                     <td class="text-center"><?= $i ?></td>
                                                     <td><?= format_indo($data['tanggal_transaksi']) ?></td>
                                                     <td class="text-center"><?= $data['start_meter'] ?></td>
                                                     <td class="text-center"><?= $data['end_meter'] ?></td>
                                                     <td class="text-center"><?= $data['jumlah_meteran'] ?></td>
                                                     <td class="text-center">Rp. <?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
                                                 </tr>
                                                 <?php $i++; ?>
                                             <?php endforeach; ?>
                                         <?php else : ?>
                                             <tr class="text-center">
                                                 <td colspan="6">
                                                     <i class="fas fa-folder-open fa-2x mt-2"></i>
                                                     <p>Data Tidak di Temukan</p>
                                                 </td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- end riwayat tagihan pelanggan -->
             </div>
             <!-- performa pelanggan -->
             <div class="col-md-6">
                 <div class="card">
                     <div class="card-header bg-success">
                         <h3 class="card-title">Grafik Tagihan Pelanggan Satu Tahun Terakir</h3>
                     </div>
                     <div class="card-body mx-1">
                         <div id="myChart"></div>
                         <?php
                            $label = "";
                            $jumlah = null;
                            foreach ($data_chart as $data) {
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
             <!--  end performa pelanggan -->
         </div>
         <!-- riwayat tagihan pelanggan -->
         <div class="row">

         </div>
         <!-- end riwayat tagihan pelanggan -->
     </div>
     <!-- end content -->

 </div>

 <script src="<?= base_url('resource/adminlte31/') ?>plugins/jquery/jquery.min.js"></script>
 <script src="<?= base_url('resource/adminlte31/') ?>plugins/chart.js/Chart.js?>"></script>
 <script src="<?= base_url('resource/adminlte31/') ?>js/apexcharts.min.js?>"></script>
 <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->


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

         colors: ['#fc0335', '#545454'],
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

     var chart = new ApexCharts(document.getElementById('myChart'), options);
     chart.render();

     $('#button_qr').click(() => {
         $('#btn_qr_loading').removeClass('d-none');
         $('#button_qr').addClass('d-none');
         $.ajax({
             url: "<?= base_url('operator/pelanggan/genereteQrcodePelanggan'); ?>",
             data: {
                 'id_pelanggan':  "<?= $pelanggan['id_pelanggan'] ?>"
             },
             type: 'GET',
             success: function(res) {
                 $('#button_qr').removeClass('d-none');
                $('#btn_qr_loading').addClass('d-none');
                 Swal.fire({
                    imageUrl: "<?= base_url() ?>" + res,
                    imageHeight: 200,
                    imageAlt: 'A tall image'
                    })
             },
             error: function(jqXHR, exception) {
                 var error_msg = '';
                    if (jqXHR.status === 0) {
                    error_msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                    // 404 page error
                    error_msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                    // 500 Internal Server error
                    error_msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                    // Requested JSON parse
                    error_msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                    // Time out error
                    error_msg = 'Time out error.';
                    } else if (exception === 'abort') {
                    // request aborte
                    error_msg = 'Ajax request aborted.';
                    } else {
                    error_msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                 console.log(error_msg)
             }
         })

     })
 </script>
