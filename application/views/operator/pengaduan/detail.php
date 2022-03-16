 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Pengaduan</h1>
                 </div>
                 <div class="col-sm-6 ">
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
                             <div class="col-6 mt-2">
                                 <h3 class="card-title">Detail Tagihan</h3>
                             </div>
                             <div class="col-6 text-right">
                                 <a href="<?= base_url('operator/pengaduan') ?>" class="btn btn-danger "><i class="fas fa-chevron-left mr-2"></i>Kembali</a>
                             </div>
                         </div>
                     </div>
                     <!-- /.card-header -->
                     <!-- form start -->
                     <form action="<?= base_url('operator/pengaduan/prosess_respone_pengaduan') ?>" method="POST">
                         <div class="card-body">
                             <?php
                                if ($this->session->FlashData('gagal_pengaduan')) {
                                ?>
                                 <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                     <?= $this->session->FlashData('gagal_pengaduan') ?>
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
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="role_name">No Pengaduan</label>
                                         <input type="text" class="form-control" id="id_tagihan" name="no_pengaduan" readonly value="<?= $rs_pengaduan['id_pengaduan'] ?>" />
                                     </div>
                                     <div class="form-group">
                                         <label for="selectPortal">Dibuat Oleh</label>
                                         <input type="text" class="form-control" id="nama_tagihan" name="pengaduan_by" readonly value="<?= $rs_pengaduan['name_pelanggan'] ?>" />
                                     </div>
                                     <div class=" form-group">
                                         <label for="selectPortal">Tanggal Pengaduan</label>
                                         <input type="text" class="form-control" id="nama_tagihan" name="pengaduan_by" readonly value="<?= format_tanggal_indo($rs_pengaduan['tgl_pengaduan']) ?>" />
                                     </div>
                                     <div class=" form-group">
                                         <label for="selectPortal">Jenis Pengaduan</label>
                                         <input type="text" class="form-control" id="nama_tagihan" name="pengaduan_by" readonly value="<?= $rs_pengaduan['jenis_pengaduan'] ?>" />
                                     </div>
                                     <div class=" form-group">
                                         <label for="selectPortal">Isi pengaduan </label>
                                         <textarea class="form-control" rows="5" readonly><?= $rs_pengaduan['isi_pengaduan'] ?></textarea>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="selectPortal">Respone Pengaduan <span class="text-danger">*</span> </label>
                                         <textarea class="form-control" name="respone_pengaduan" rows="10" placeholder="Masukkan Respone Pengaduan"><?= $rs_pengaduan['respone_pengaduan'] ?></textarea>
                                     </div>
                                     <div class="form-group">
                                         <label for="selectPortal">Status Pengaduan <span class="text-danger">*</span></label>
                                         <select name="status_pengaduan" id="" class="form-control select-2" data-placeholder="Ubah Status Pengaduan">
                                             <option value=""></option>
                                             <option value="diproses" <?= $rs_pengaduan['status_pengaduan'] == 'diproses' ? 'selected' : '' ?>>Di Proses</option>
                                             <option value="ditolak" <?= $rs_pengaduan['status_pengaduan'] == 'ditolak' ? 'selected' : '' ?>>Di Tolak</option>
                                             <option value="selesai" <?= $rs_pengaduan['status_pengaduan'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>

                             <div class="row mt-4">
                                 <div class="col-12">
                                     <small class="text-danger"> <b><i>CATATAN : Semua field bertanda bintang (*) wajib diisi.</i></b></small>
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
             </div>
         </div>
         <!-- /.content -->
     </div>
 </div>