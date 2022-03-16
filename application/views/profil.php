 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Profile</h1>
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

     <!-- Main content -->
     <div class="content">
         <div class="card">
             <?php
                if ($this->session->FlashData('success_profil')) {
                ?>
                 <script>
                     Swal.fire("Sukses", "<?= $this->session->FlashData('success_profil') ?>", "success");
                 </script>
             <?php
                } elseif ($this->session->FlashData('gagal_profil')) { ?>

                 <script>
                     Swal.fire("Sukses", "<?= $this->session->FlashData('gagal_profil') ?>", "error");
                 </script>
             <?php }
                ?>
             <div class="row">
                 <div class="col-md-4">
                     <img src="<?= base_url('resource/adminlte31/') ?>/img/profile/<?= $user_detail['user_photo']  ?>" style="width: 100%; height: 90%;" class="my-3 mx-3">
                 </div>
                 <div class="col-md-8 px-4">
                     <form method="POST" action="<?= base_url('profil/procces_update_profile') ?>" enctype="multipart/form-data">
                         <input type="hidden" name="user_id" value="<?= $user_detail['user_id'] ?>">
                         <div class="row mt-5">
                             <div class="col-6">
                                 <div class="form-group">
                                     <label for="exampleFormControlInput1">Nama</label>
                                     <input type="text" class="form-control" name="nama_lengkap" value="<?= $user_detail['user_alias'] ?>" id="exampleFormControlInput1">
                                 </div>
                                 <div class="form-group">
                                     <label for="exampleFormControlInput1">User Name </label>
                                     <input type="text" class="form-control" name="user_name" readonly value="<?= $user_detail['user_name'] ?>" id="exampleFormControlInput1">
                                 </div>
                                 <div class="form-group">
                                     <label for="exampleFormControlInput1">Passwaord </label>
                                     <input type="password" name="pass" class="form-control mb-2" id="exampleFormControlInput1">
                                     <span class="text-danger">Kosongkan Bila Tidak Ingin Ganti Password</span>
                                 </div>
                             </div>
                             <div class="col-6">
                                 <div class="form-group">
                                     <label for="role_name">No Telepon</label>
                                     <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No Telepon" value="<?php if (isset($user_detail['no_telp'])) {
                                                                                                                                                        echo $user_detail['no_telp'];
                                                                                                                                                    }  ?>" />
                                 </div>
                                 <div class="form-group">
                                     <label for="role_name">Email</label>
                                     <input type="email" class="form-control" id="no_telp" name="email" placeholder="name@example.com" value="<?php if (isset($user_detail['email'])) {
                                                                                                                                                    echo $user_detail['email'];
                                                                                                                                                }  ?>" />
                                 </div>
                                 <div class="form-group">
                                     <label for="">Upload Photo Profil</label>
                                     <input type="file" name="foto_profil" class="form-control" id="exampleFormControlInput1">
                                 </div>
                             </div>
                         </div>



                         <div class="card-footer">
                             <button type="submit" class="btn btn-success float-right"><i class="fas fa-check mr-2"></i>Simpan</button>
                             <!-- <a class="btn btn-dark" href="<?= base_url('operator/transaksi') ?>"><i class="fas fa-arrow-left mr-1"></i>Back</a> -->
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>


 </div>