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
                                            echo "Tambah Data Akun Pelanggan";
                                        } else {
                                            echo "Edit Data Akun Pelanggan";
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
                                         <a href="#" class="step-trigger active" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                             <span class="bs-stepper-circle">1</span>
                                             <span class="bs-stepper-label">Data Akun</span>
                                         </a>
                                     </div>

                                     <div class="line"></div>

                                     <div class="step" data-target="#information-part">
                                         <a href="#" class="step-trigger disabled" role="tab" aria-controls="information-part" id="information-part-trigger">
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
                     <form action="<?= base_url('operator/pelanggan/procces_step_akun') ?>" method="POST">
                         <input type="hidden" name="user_id" value="<?php if (isset($result['user_id'])) {
                                                                        echo $result['user_id'];
                                                                    }  ?>">
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
                                         <span class="sr-only">Close</span>
                                     </button>
                                 </div>
                             <?php
                                }
                                ?>
                             <!-- end notifikasi -->
                             <div class="row">
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="role_name">User Name <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                                         <input type="text" class="form-control" id="id_pelanggan" name="user_name" <?= $status_pelanggan == "0" ? "" : "readonly" ?> value="<?php if (isset($result['user_name'])) {
                                                                                                                                                                                    echo $result['user_name'];
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo set_value('user_name');
                                                                                                                                                                                }  ?>" placeholder="Masukkan User Name Pelanggan" />
                                     </div>

                                     <div class="form-group">
                                         <label for="role_name">Password <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?> </label>
                                         <input type="password" class="form-control " id="nama_pelanggan" name="user_pass" placeholder="Masukkan password" />
                                         <?php if ($status_pelanggan == '1') : ?> <span class="text-danger">Kosongkan Bila Tidak Ingin Ganti Password</span> <?php endif; ?>
                                     </div>
                                     <div class="form-group">
                                         <label for="role_name">No Telepon</label>
                                         <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No Telepon" value="<?php if (isset($result['no_telp'])) {
                                                                                                                                                            echo $result['no_telp'];
                                                                                                                                                        } else {
                                                                                                                                                            # code...
                                                                                                                                                            echo set_value('no_telp');
                                                                                                                                                        } ?>" />

                                     </div>
                                 </div>
                                 <div class="col-6">
                                     <div class="form-group">
                                         <label for="role_name">Email</label>
                                         <input type="email" class="form-control" id="no_telp" name="email" placeholder="name@example.com" value="<?php if (isset($result['email'])) {
                                                                                                                                                        echo $result['email'];
                                                                                                                                                    } else {
                                                                                                                                                        # code...
                                                                                                                                                        echo set_value('email');
                                                                                                                                                    }  ?>" />
                                     </div>
                                     <div class="form-group">
                                         <label for="role_name">Nama Alias <?php if ($status_pelanggan == '0') : ?> <span class="text-danger">*</span> <?php endif; ?></label>
                                         <input type="text" class="form-control" id="nama_pelanggan" name="user_alias" placeholder="Masukkan Nama Pelanggan" value="<?php if (isset($result['user_alias'])) {
                                                                                                                                                                        echo $result['user_alias'];
                                                                                                                                                                    } else {
                                                                                                                                                                        # code...
                                                                                                                                                                        echo set_value('user_alias');
                                                                                                                                                                    }  ?>" />
                                     </div>
                                 </div>
                             </div>
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
                             <button type="submit" class="btn btn-success float-right">Simpan dan Selanjutnya <i class="fas fa-chevron-right ml-1"></i></button>
                             <button type="reset" class="btn btn-outline-dark float-right mr-2"><i class="fas fa-redo mr-1"></i> Reset</button>

                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- /.content -->
 </div>