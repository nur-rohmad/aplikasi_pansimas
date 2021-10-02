 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1>Edit Pelanggan</h1>
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
     <div class="row">
       <!-- left column -->
       <div class="col-md-12">

         <div class="card card-light">
           <div class="card-header">
             <h3 class="card-title text-danger">Anda yakin ingin menghapus data transaksi : </h3>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form action="<?= base_url('operator/transaksi/procces_delete_transaksi') ?>" method="POST">
             <div class="card-body">
               <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?= $transaksi['id_transaksi']; ?>">
               <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $transaksi['id_pelanggan']; ?>">
               <div class="row">
                 <div class="col-sm-6">
                   <div class="form-group">
                     <label for="role_name">ID Pelanggan</label>
                     <input type="text" class="form-control" id="id_pelanggan" value="<?= $transaksi['id_pelanggan']; ?>" name="id_pelanggan1" disabled />
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <div class="form-group">
                     <label for="role_name">Nama Pelanggan</label>
                     <input type="text" class="form-control" id="nama_pelanggan" value="<?= $transaksi['name_pelanggan']; ?>" name="nama_pelanggan" disabled />
                   </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-sm-6">
                   <div class="form-group">
                     <label for="role_name">Jumlah Pemakaian</label>
                     <input type="text" class="form-control" id="jumlah_meteran" value="<?= $transaksi['jumlah_meteran']; ?> " name="jumlah_meter" disabled />
                   </div>
                 </div>
                 <div class="col-sm-6">
                   <div class="form-group">
                     <label for="role_name">Total Tagihan</label>
                     <input type="text" class="form-control" id="total_bayar" value="Rp. <?= number_format($transaksi['total_bayar'], 2, ',', '.'); ?>" name="total_bayar" disabled />
                   </div>
                 </div>
               </div>





               <!-- /.card-body -->

               <div class="card-footer">
                 <button type="submit" class="btn btn-danger float-right"><i class="fas fa-trash-alt mr-1"></i>Hapus</button>
                 <a class="btn btn-dark" href="<?= base_url('operator/transaksi') ?>"><i class="fas fa-arrow-left mr-1"></i>Back</a>
               </div>
           </form>
         </div>
       </div>
     </div>
   </div>
 </div>
 <!-- /.content -->
 </div>