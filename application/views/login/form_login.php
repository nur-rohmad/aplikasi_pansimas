<div class="login-box shadow">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="logo">
        <img class="logo" src="<?= base_url('resource/adminlte31/') ?>/img/pansimas.jpeg" alt="">
      </div>
      <a href="#" class="h2"><b>KP-SPAM Panguripan</b></a>
    </div>
    <div class="card-body">
      <?php
      if ($this->session->FlashData('gagal')) {
      ?>
        <script>
          Swal.fire("Gagal", "<?= $this->session->FlashData('gagal') ?>", "error");
        </script>
      <?php } elseif ($this->session->FlashData('sukses_logout')) { ?>
        <script>
          Swal.fire("Sukses", "<?= $this->session->FlashData('sukses_logout') ?>", "success");
        </script>
      <?php } elseif ($this->session->FlashData('success')) { ?>
        <div class="alert alert-success  alert-dismissible fade show" role="alert">

          <?= $this->session->FlashData('success') ?>

          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
        </div>

      <?php }
      ?> 


      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?= base_url('login/proccess_login') ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="user_name" placeholder="User Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" required class="form-control" name="pass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
        </div>
        <!-- /.col -->
        <div class="col-4.5 float-right">
          <button type="submit" class="btn btn-primary btn-block">Masuk <i class="fas fa-sign-in-alt"></i></button>
        </div>
        <!-- /.col -->
    </div>
    </form>
    <a class="text-center mb-4" href="<?= base_url('login/forgotpassword'); ?>">Lupa Password</a>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->


<style>
  .logo {
    margin-left: auto;
    margin-right: auto;
    width: 150px;
    height: 150px;
  }
</style>
<!-- /.login-box -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('resource/adminlte31/') ?>js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('resource/adminlte31/') ?>js/demo.js"></script>
</body>

</html>