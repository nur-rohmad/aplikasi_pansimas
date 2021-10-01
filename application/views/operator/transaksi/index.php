 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Transaksi</h1>
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
         <div class="card">
             <div class="card-header mt-2">
                 <h3 class="card-title text-center">Tabel Tagihan</h3>
                 <a class="btn btn-success float-right" href="<?= base_url('operator/transaksi/add_tagihan') ?>"><i class="fas fa-plus mr-1"></i> Add</a>
             </div>
             <!-- motifikasi -->
             <?php
                if ($this->session->FlashData('success_tagihan')) {
                ?>
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $this->session->FlashData('success_tagihan') ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             <?php
                }
                ?>
             <!-- end notifikasi -->
             <div class="card-body">
                 <table class="table table-bordered">
                     <thead>
                         <tr>
                             <th class="text-center" widht="10%">No</th>
                             <th class="text-center">Nama Tagihan</th>
                             <th class="text-center">Jumlah Tagihan</th>
                             <th class="text-center" width="20%">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php if ($tagihan != null) : ?>
                             <?php $i = 1; ?>
                             <?php foreach ($tagihan as $data) : ?>
                                 <tr>
                                     <td class="text-center"><?= $i; ?></td>
                                     <td><?= $data['name_tagihan']; ?></td>
                                     <td class="text-center"> Rp. <?= $data['jumlah_tagihan']; ?></td>
                                     <td class="text-center">
                                         <a href="<?= base_url('operator/transaksi/edit_tagihan/') . $data['id_tagihan'] ?>" class="btn btn-sm btn-info"><i class="fas fa-edit mr-1"></i>edit</a>
                                     </td>
                                 </tr>
                                 <?php $i++; ?>
                             <?php endforeach; ?>
                         <?php else : ?>
                             <tr class="text-center">
                                 <td colspan="5">Data Tidak di Temukan</td>
                             </tr>
                         <?php endif; ?>
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- tabel transaksi -->

         <div class="card">
             <div class="card-header mt-2" id="title-card">
                 <h3 class="card-title text-center">Tabel Transaksi</h3>
                 <a class="btn btn-success float-right" href="<?= base_url('operator/transaksi/add_transaksi') ?>"><i class="fas fa-plus mr-1"></i> Add</a>
                 <a class="btn btn-primary float-right mr-2" href="<?= base_url('operator/transaksi/cetak_laporan_bulanan') ?>"><i class="fas fa-print mr-1"></i> Cetak Laporan Bulan Ini</a>
             </div>
             <!-- motifikasi -->
             <?php
                if ($this->session->FlashData('success_transaksi')) {
                ?>
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $this->session->FlashData('success_transaksi') ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             <?php
                }
                ?>
             <!-- end notifikasi -->
             <div class="card-body">
                 <table class="table table-bordered" id="myTable2">
                     <thead>
                         <tr>
                             <th class="text-center" widht="10%">No</th>
                             <th class="text-center">ID Pelanggan</th>
                             <th class="text-center">Nama Pelanggan</th>
                             <th class="text-center">Bulan Tagihan</th>
                             <th class="text-center">Start Meter</th>
                             <th class="text-center">End Meter</th>
                             <th class="text-center">Jumlah Meteran</th>
                             <th class="text-center">Total Tagihan</th>
                             <th class="text-center" width="10%">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php if ($transaksi != null) : ?>
                             <?php $i = 1; ?>
                             <?php foreach ($transaksi as $data) : ?>
                                 <tr>
                                     <td class="text-center"><?= $i; ?></td>
                                     <td><?= $data['id_pelanggan']; ?></td>
                                     <td><?= $data['name_pelanggan']; ?></td>
                                     <td class="text-center"> <?= date("F  Y", strtotime($data['tanggal_transaksi']),); ?></td>
                                     <td class="text-center"><?= $data['start_meter']; ?></td>
                                     <td class="text-center"><?= $data['end_meter']; ?></td>
                                     <td class="text-center"> <?= $data['jumlah_meteran']; ?></td>
                                     <td class="text-center"> Rp. <?= number_format($data['total_bayar'], 2, ',', '.'); ?></td>
                                     <td class="text-center">
                                         <a href="<?= base_url('operator/transaksi/print/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-info"><i class="fas fa-print"></i> Cetak</a>
                                         <a href="<?= base_url('operator/transaksi/delete_transaksi/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-trash-alt"></i> Hapus</a>

                                     </td>
                                 </tr>
                                 <?php $i++; ?>
                             <?php endforeach; ?>

                         <?php else : ?>
                             <tr class="text-center">
                                 <td colspan="9">
                                     <i class="fas fa-folder-open fa-2x mt-2"></i>
                                     <p>Data Tidak di Temukan</p>
                                 </td>
                             </tr>
                         <?php endif; ?>
                     </tbody>
                     <tfoot>
                         <tr>
                             <td colspan="6" class="text-center"><strong>TOTAL </strong></td>
                             <td class="text-center"><strong><?= $total_meteran['total'] ?></strong></td>
                             <td colspan="2"><strong>Rp. <?= number_format($total_pendapatan['total'], 2, ',', '.');  ?> </strong> </td>
                         </tr>
                     </tfoot>
                 </table>
             </div>
         </div>
     </div>
     <!-- /.content -->
 </div>