 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <ol class="breadcrumb">
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
             <div class="row">
               <div class="col-6 mt-2">
                 <h3 class="card-title">Tambah Tagihan</h3>
               </div>
               <div class="col-6 text-right">
                 <a href="<?= base_url('operator/transaksi') ?>" class="btn btn-danger "><i class="fas fa-chevron-left mr-2"></i>Kembali</a>
               </div>
             </div>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form action="<?= base_url('operator/transaksi/procces_add_tagihan') ?>" method="POST">
             <div class="card-body">
               <div class="form-group">
                 <label for="role_name">Kode Tagihan</label>
                 <input type="text" class="form-control" id="id_tagihan" name="id_tagihan" placeholder="Masukkan Kode Tagihan" />
               </div>

               <div class="form-group">
                 <label for="selectPortal">Nama Tagihan </label>
                 <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan" placeholder="Masukkan Nama Tagihan" />
               </div>

               <div class="form-group">
                 <label for="selectPortal">Jumlah Tagihan </label>
                 <input type="number" class="form-control" id="jumlah_tagihan" name="jumlah_tagihan" placeholder="Masukkan Jumlah Tagihan" />
               </div>
               <!-- /.card-body -->

               <div class="card-footer">
                 <button type="submit" class="btn btn-success float-right"><i class="fas fa-check mr-2"></i>Simpan</button>
                 <button type="reset" class="btn btn-outline-dark float-right mr-2"><i class="fas fa-redo mr-1"></i> Reset</button>
               </div>
           </form>
         </div>
       </div>
     </div>
   </div>
   <!-- /.content -->
 </div>
 </div>