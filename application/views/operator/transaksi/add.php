 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1>Tambah Transaksi</h1>
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
     <div class="row ">
       <!-- left column -->
       <div class="col-md-12">
         <?php
          if ($this->session->FlashData('success_transaksi')) {
          ?>
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
             <?= $this->session->FlashData('success_transaksi') ?>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
         <?php
          }
          ?>
         <div class="card card-dark">
           <div class="card-header">
             <h3 class="card-title">Add Transaksi</h3>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form action="<?= base_url('operator/transaksi/procces_add_transaksi') ?>" method="POST">
             <div class="card-body">

               <div class="form-group">
                 <label>Nama Pelanggan</label>
                 <select class="form-control select-2" data-placeholder="Masukkan Nama Pelanggan" name="nama_pelanggan" id="nama_pelanggan">
                   <option value=""></option>
                   <?php foreach ($pelanggan as $nama) : ?>
                     <option value="<?= $nama['id_pelanggan']; ?>"><?= $nama['id_pelanggan']; ?> - <?= $nama['name_pelanggan']; ?></option>
                   <?php endforeach; ?>
                 </select>
               </div>

               <div class="form-group">
                 <label for="selectPortal">Metteran Sekarang </label>
                 <input type="number" class="form-control" id="end_meteran" name="end_meteran" placeholder="Masukkan Metteran Sekarang" />
               </div>

             </div>
             <!-- /.card-body -->

             <div class="card-footer">
               <button type="submit" class="btn btn-success float-right"><i class="fas fa-arrow-up mr-1"></i>Simpan</button>
               <a class="btn btn-dark" href="<?= base_url('operator/transaksi') ?>"><i class="fas fa-arrow-left mr-1"></i>Back</a>
             </div>
           </form>
         </div>
         <!-- end card  -->
       </div>
     </div>
   </div>
   <!-- /.content -->
 </div>