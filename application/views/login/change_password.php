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
            if ($this->session->FlashData('gagal_resetpassword')) {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <?= $this->session->FlashData('gagal_resetpassword') ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

            <?php
            }
            ?>


            <p class="login-box-msg">Please input new password !!</p>

            <form action="<?= base_url('login/changepassword') ?>" method="post">
                <div class="input-group mb-3 row">
                    <div class="col-sm-12">
                        <input type="password" class="form-control" id="show_password1" name="password1" placeholder="Entet Your new password" value="<?= set_value('password1') ?>">
                        <?= form_error('password1', '<small class="text-danger pl-3 ">', '</small>'); ?>
                    </div>
                </div>
                <div class="input-group mb-3 row">
                    <div class="col-sm-12">
                        <input type="password" class="form-control" id="show_password2" name="password2" placeholder="Repeart your new password" value="<?= set_value('password2') ?>">
                        <?= form_error('password2', '<small class="text-danger pl-3 ">', '</small>'); ?>
                    </div>
                </div>
                <div class="input-group form-group form-check mb-3 row">
                    <div class="col-sm-6">
                        <input class="form-check-input" type="checkbox" onclick="myFunction()">
                        <label class="form-check-label" for="exampleCheck1">Show Password</label>
                    </div>
                </div>


                <div class="row">
                </div>
                <!-- /.col -->
                <div class="col-12 float-right">
                    <button type="submit" class="btn btn-primary btn-block">Reset Password </button>
                </div>
                <!-- /.col -->
        </div>
        </form>
        <a class="text-center mb-4" href="<?= base_url('login'); ?>">Back to Login</a>
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
<script>
    function myFunction() {
      
        var x = document.getElementById("show_password1") ;
        var y = document.getElementById("show_password2") ;
    
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
    }
</script>
</body>

</html>