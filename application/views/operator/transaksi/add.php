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

         <div class="card card-dark">
           <div class="card-header">
             <div class="row">
               <div class="col-6 mt-2">
                 <h3 class="card-title">Tambah Transaksi</h3>
               </div>
               <div class="col-6 text-right">
                 <a href="<?= base_url('operator/transaksi') ?>" class="btn btn-danger "><i class="fas fa-chevron-left mr-2"></i>Kembali</a>
               </div>
             </div>
           </div>
           <!-- /.card-header -->
           <!-- form start -->

           <form action="<?= base_url('operator/transaksi/procces_add_transaksi') ?>" method="POST">
             <div class="card-body">
               <?php
                if ($this->session->FlashData('gagal_transaksi')) {
                ?>
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">

                   <?= $this->session->FlashData('gagal_transaksi') ?>
                   <ul>
                     <?= $this->session->FlashData('pesan_eror') ?>
                   </ul>
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     <span class="sr-only">Close</span>
                   </button>
                 </div>

               <?php
                }
                ?>
               <div class="row">

                 <div class="col-md-3" id="reader"></div>
                 <div class="col-md-9">
                   <div class="form-group">
                     <label>Nama Pelanggan</label>
                     <select class="form-control select-2" id="id_pelanggan" data-placeholder="Masukkan Nama Pelanggan" name="nama_pelanggan" id="nama_pelanggan">
                       <option value=""></option>
                       <?php foreach ($pelanggan as $nama) : ?>
                         <option value="<?= $nama['id_pelanggan']; ?>" <?php echo set_value('nama_pelanggan') == $nama['id_pelanggan'] ? 'selected' : '' ?>><?= $nama['id_pelanggan']; ?> - <?= $nama['name_pelanggan']; ?></option>
                       <?php endforeach; ?>
                     </select>
                   </div>
                   <div class="form-group">
                     <label for="selectPortal">Metteran terakir </label>
                     <input type="number" class="form-control" id="meteran_terakir" readonly />
                   </div>
                   <div class="form-group">
                     <label for="selectPortal">Metteran Sekarang </label>
                     <input type="number" class="form-control" id="end_meteran" name="end_meteran" value="<?= set_value('end_meteran') ?>" placeholder="Masukkan Metteran Sekarang" />
                   </div>
                 </div>

               </div>



             </div>
             <!-- /.card-body -->

             <div class="card-footer">
               <button type="submit" class="btn btn-success float-right"><i class="fas fa-check mr-2"></i>Simpan</button>
               <button type="reset" class="btn btn-outline-dark float-right mr-2"><i class="fas fa-redo mr-1"></i> Reset</button>
             </div>
           </form>
         </div>
         <!-- end card  -->
       </div>
     </div>
   </div>
   <!-- /.content -->
 </div>
 <script src="<?= base_url('resource/adminlte31/') ?>plugins/jquery/jquery.min.js"></script>
 <script src="<?= base_url('resource/adminlte31/') ?>plugins/readerqrcode/html5-qrcode.min.js"></script>
 <script>
   $(document).ready(function() {

     $('#id_pelanggan').change(() => {
       // const jasa = "rental_mobil";
       let id = $('#id_pelanggan').val();
       console.log(id)
       $.ajax({
         url: '<?= base_url('operator/transaksi/getMeteranPelanggan') ?>',
         type: "POST",
         // dataType: "JSON",
         data: {
           id_pelanggan: id,
         },
         cache: false,
         success: function(res) {
           let data_json = JSON.parse(res)
           console.log(data_json)
           $('#meteran_terakir').val(data_json.data.end_meter)
         }
       });
     })
   })

   function onScanSuccess(decodedText, decodedResult) {
     // Handle on success condition with the decoded text or result.
     //  console.log(`Scan result: ${decodedText}`, decodedResult);
     $('#id_pelanggan').val(decodedText).change();
     //  window.location.assign('<?= base_url('operator/transaksi/add_transaksi') ?>')
   }

   var html5QrcodeScanner = new Html5QrcodeScanner(
     "reader", {
       fps: 10,
       qrbox: 250
     });
   html5QrcodeScanner.render(onScanSuccess);
 </script>