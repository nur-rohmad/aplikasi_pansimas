 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1>Edit Tagihan</h1>
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

         <div class="card card-dark">
           <div class="card-header">
             <h3 class="card-title">Edit Tagihan</h3>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form action="<?= base_url('operator/transaksi/procces_delete_transaksi') ?>" method="POST">
             <div class="card-body">
               <input type="hidden" class="form-control" value="<?= $tagihan['id_tagihan'] ?>" id="id_tagihan" name="id_tagihan" placeholder="Masukkan Kode Tagihan" />


               <div class="form-group">
                 <label for="selectPortal">Nama Tagihan </label>
                 <input type="text" class="form-control" id="nama_tagihan" value="<?= $tagihan['name_tagihan'] ?>" name="nama_tagihan" placeholder="Masukkan Nama Tagihan" />
               </div>

               <div class="form-group">
                 <label for="selectPortal">Jumlah Tagihan </label>
                 <input type="number" class="form-control" id="jumlah_tagihan" value="<?= $tagihan['jumlah_tagihan'] ?>" name="jumlah_tagihan" placeholder="Masukkan Jumlah Tagihan" />
               </div>
               <!-- /.card-body -->

               <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fas fa-arrow-up mr-1"></i>Simpan</button>
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