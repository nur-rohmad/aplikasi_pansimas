 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1>Tambah Pelanggan</h1>
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
             <div class="row">
               <div class="col-6 pt-2">
                 <h3 class="card-title ">
                   <?php
                    if ($status_pelanggan == '0') {
                      echo "Tambah Data  Pelanggan";
                    } else {
                      echo "Edit Data  Pelanggan";
                    }
                    ?>
                 </h3>
               </div>
               <div class="col-6 text-right">
                 <a href="<?= base_url('operator/pelanggan') ?>" class="btn btn-danger "><i class="fas fa-chevron-left mr-2"></i>Kembali</a>
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-8 mx-auto">
               <div class="bs-stepper">
                 <div class="bs-stepper-header mb-4" role="tablist">
                   <!-- your steps here -->
                   <div class="step" data-target="#logins-part">
                     <a href="#" class="step-trigger disabled" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                       <span class="bs-stepper-circle">1</span>
                       <span class="bs-stepper-label">Data Akun</span>
                     </a>
                   </div>

                   <div class="line"></div>

                   <div class="step" data-target="#information-part">
                     <a href="#" class="step-trigger active" role="tab" aria-controls="information-part" id="information-part-trigger">
                       <span class="bs-stepper-circle">2</span>
                       <span class="bs-stepper-label">Data Pelanggan</span>
                     </a>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- /.card-header -->
           <!-- form start -->
           <form action="<?= base_url('operator/pelanggan/procces_add') ?>" method="POST">
             <div class="card-body">
               <!-- motifikasi -->
               <?php
                if ($this->session->FlashData('gagal')) {
                ?>

                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   <?= $this->session->FlashData('gagal') ?>
                   <ul>
                     <?= $this->session->FlashData('pesan_eror') ?>
                   </ul>
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
               <?php
                } elseif ($this->session->FlashData('success')) { ?>
                 <script>
                   Swal.fire("Sukses", "<?= $this->session->FlashData('success') ?>", "success");
                 </script>

               <?php }
                ?>
               <!-- end notifikasi -->
               <input type="hidden" name="user_id" value="<?= $user_id ?>">

               <?php if ($status_pelanggan == '0') : ?>
                 <div class="form-group">
                   <label for="role_name">ID Pelanggan <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                   <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" placeholder=" Masukkan ID Pelanggan" value="<?= set_value('id_pelanggan') ?>" />
                 </div>
               <?php else :   ?>
                 <input type="hidden" name="id_pelanggan" value="<?php if (isset($user_detail['id_pelanggan'])) {
                                                                    echo $user_detail['id_pelanggan'];
                                                                  }  ?>">
               <?php endif;   ?>


               <div class="form-group">
                 <label for="role_name">Nama Pelanggan <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                 <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama Pelanggan" value="<?php if (isset($user_detail['name_pelanggan'])) {
                                                                                                                                                  echo $user_detail['name_pelanggan'];
                                                                                                                                                } else {
                                                                                                                                                  echo set_value('nama_pelanggan');
                                                                                                                                                }  ?>" />
               </div>


               <div class="form-group">
                 <label for="selectPortal">Pilih RW <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                 <select class="custom-select foom-control-border select-2" name="rw_pelanggan" id="rw_pelanggan">
                   <?php for ($i = 1; $i <= 3; $i++) : ?>
                     <?php if (isset($user_detail['rw_pelanggan'])) { ?>
                       <option value="<?= $i; ?>" <?php if ($user_detail['rw_pelanggan'] == $i) : ?> selected<?php endif; ?>>0<?= $i; ?></option> <?php } else { ?>
                       <option value="<?= $i; ?>">0<?= $i; ?></option>
                     <?php  } ?>
                   <?php endfor; ?>
                 </select>
               </div>

               <div class="form-group">
                 <label for="selectPortal">Pilih RT <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?> </label>
                 <select class="custom-select foom-control-border select-2" name="rt_pelanggan" id="rt_pelanggan">
                   <?php for ($i = 1; $i <= 12; $i++) : ?>
                     <?php if (isset($user_detail['rt_pelanggan'])) : ?>
                       <option <?= $i; ?> <?php if ($user_detail['rt_pelanggan'] == $i) : ?> selected<?php endif; ?>>
                         <?php if ($i >= 10) : ?>
                           <?= $i; ?>
                         <?php else : ?>
                           0<?= $i; ?>
                         <?php endif; ?>
                       </option>
                     <?php else :  ?>
                       <option <?= $i; ?>>
                         <?php if ($i >= 10) : ?>
                           <?= $i; ?>
                         <?php else : ?>
                           0<?= $i; ?>
                         <?php endif; ?>
                       </option>
                     <?php endif; ?>
                   <?php endfor; ?>
                 </select>
               </div>

               <?php if ($status_pelanggan == '0') : ?>
                 <div class="form-group">
                   <label for="role_name">Start Stand Metter <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                   <input type="text" class="form-control" id="end_meter" name="end_meter" value="0" placeholder="Masukkan Awal Meteran" />
                 </div>
               <?php endif; ?>
               <?php if ($status_pelanggan == '0') : ?>
                 <div class="row mt-4">
                   <div class="col-12">
                     <small class="text-danger"> <b><i>CATATAN : Semua field bertanda bintang (*) wajib diisi.</i></b></small>
                   </div>
                 </div>
               <?php endif; ?>
             </div>

             <!-- /.card-body -->

             <div class="card-footer">
               <button type="submit" class="btn btn-success float-right"><i class="fas fa-check mr-2"></i>Simpan</button>
               <button type="reset" class="btn btn-outline-dark float-right mr-2"><i class="fas fa-redo mr-1"></i> Reset</button>
               <a class="btn btn-outline-dark" href="<?= base_url('operator/pelanggan/step_akun/' . $user_id) ?>"><i class="fas fa-chevron-left mr-2"></i>Sebelumnya</a>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
   <!-- /.content -->
 </div>