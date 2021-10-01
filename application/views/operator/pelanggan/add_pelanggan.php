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
          <!-- motifikasi -->
          <?php
                      if($this->session->FlashData('gagal')){
                      ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?= $this->session->FlashData('gagal') ?>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      <?php
                      }
               ?>
                 <!-- end notifikasi -->
          <div class="card-header">
            <h3 class="card-title">Add Pelanggan</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="<?= base_url('operator/pelanggan/procces_add') ?>" method="POST">
            <div class="card-body">
              <div class="form-group">
                <label for="role_name">ID Pelanggan</label>
                <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" placeholder="Masukkan ID Pelanggan" />
              </div>

              <div class="form-group">
                <label for="role_name">Nama Pelanggan</label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama Pelanggan" />
              </div>

              <div class="form-group">
                <label for="selectPortal">Pilih RW </label>
                <select class="custom-select foom-control-border" name="rw_pelanggan" id="rw_pelanggan">
                    <?php for($i=1;$i<=3;$i++): ?>
                  <option value="<?= $i; ?>">0<?= $i; ?></option>
                    <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="selectPortal">Pilih RW </label>
                <select class="custom-select foom-control-border" name="rt_pelanggan" id="rt_pelanggan">
                    <?php for($i=1;$i<=12;$i++): ?>
                  <option value="<?= $i; ?>">
                  <?php if($i >=10) : ?>
                  <?= $i; ?>
                  <?php else: ?>
                    0<?= $i; ?>
                <?php endif; ?>
                </option>
                    <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="role_name">Start Stand Metter</label>
                <input type="text" class="form-control" id="end_meter" name="end_meter" placeholder="Masukkan Awal Meteran" />
              </div>
              
            </div>
            <!-- /.card-body -->

             <div class="card-footer">
              <button type="submit" class="btn btn-success float-right"><i class="fas fa-arrow-up mr-1"></i>Simpan</button>
              <a class="btn btn-dark" href="<?= base_url('operator/pelanggan') ?>"><i class="fas fa-arrow-left mr-1"></i>Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
 <!-- /.content -->
</div>