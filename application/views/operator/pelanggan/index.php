 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Pelanggan</h1>
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
                 <h3 class="card-title">Tabel Pelanggan</h3>
                 <a class="btn btn-success float-right" href="<?= base_url('operator/pelanggan/add_pelanggan') ?>"><i class="fas fa-plus mr-1"></i> Add</a>
                 <a class="btn btn-dark float-right mr-2" href="<?= base_url('operator/pelanggan/export_excel') ?>"><i class="fas fa-file-excel"></i> Export Excel</a>
                 <a class="btn btn-primary float-right mr-1" href="<?= base_url('operator/pelanggan/cetak_pelanggan') ?>"><i class="fas fa-print mr-1"></i> Cetak </a>
             </div>
             <!-- motifikasi -->
             <?php
                if ($this->session->FlashData('success')) {
                ?>
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $this->session->FlashData('success') ?>
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
                             <th class="text-center">RW</th>
                             <th class="text-center">RT</th>
                             <th class="text-center" width="20%">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php if ($pelanggan != null) : ?>
                             <?php $i = 1; ?>
                             <?php foreach ($pelanggan as $data) : ?>
                                 <tr>
                                     <td class="text-center"><?= $i; ?></td>
                                     <td><?= $data['id_pelanggan']; ?></td>
                                     <td><?= $data['name_pelanggan']; ?></td>
                                     <td class="text-center"> BINTOYO 0<?= $data['rw_pelanggan']; ?></td>
                                     <td class="text-center"><?= $data['rt_pelanggan']; ?></td>
                                     <td class="text-center">
                                         <a href="<?= base_url('operator/pelanggan/edit_pelanggan/') . $data['id_pelanggan'] ?>" class="btn btn-sm btn-info"><i class="fas fa-edit mr-1"></i>edit</a>
                                         <a href="<?= base_url('operator/pelanggan/delete_pelanggan/') . $data['id_pelanggan'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt mr-1"></i>hapus</a>
                                     </td>
                                 </tr>
                                 <?php $i++; ?>
                             <?php endforeach; ?>
                         <?php else : ?>
                             <tr class="text-center">
                                 <td colspan="5">
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
     <!-- /.content -->
 </div>