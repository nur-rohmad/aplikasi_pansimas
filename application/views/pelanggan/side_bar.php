 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
     <!-- Brand Logo -->
     <a href="<?= base_url('operator/dashboard'); ?>" class="brand-link">
         <img src="<?= base_url('resource/adminlte31/') ?>/img/pansimas.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">KP-SPAMS Panguripan</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="<?= base_url('resource/adminlte31/') ?>/img/profile/<?= $user_data['user_photo']  ?>" class="img elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="<?= base_url('profil') ?>" class="d-block"><?= $user_data['nama_lengkap']; ?></a>
                 <span class="badge badge-danger text-white mr-2"> <?= ucwords($user_data['user_role_name']); ?></span>
                 <a onclick="logout()" href="#"><i class="fas fa-sign-out-alt"></i></a>
             </div>
         </div>

         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


                 <li class="nav-item ">
                     <a href="<?= base_url('pelanggan/dashboard') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                         <!-- <i class="right fas fa-angle-left"></i> -->
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('pelanggan/tagihan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'tagihan' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-dollar-sign"></i>
                         <p>
                             Tagihan
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('pelanggan/pengaduan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'pengaduan' ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-phone-alt"></i>
                         <!-- <img class="nav-icon fas" src="<?= base_url('resource/adminlte31/img/icon/customer-service.png') ?>" alt=""> -->
                         <p>
                             Pengaduan
                         </p>
                         <?php if (cek_pengaduan() > 0) : ?>
                             <span href="#" class="badge badge-<?php echo $this->uri->segment(2) == 'pengaduan' ? 'light' : 'primary' ?> right"><?= cek_pengaduan(); ?></span>
                         <?php endif; ?>
                     </a>
                 </li>

             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
 <script>
     function logout() {
         Swal.fire({
             icon: 'warning',
             title: ' Anda Yakin Ingin Log Out ? ',
             showDenyButton: true,
             // showButton: true,

             //  showCancelButton: true,
             confirmButtonText: 'Iya',
             denyButtonText: `Tidak`,
             confirmButtonColor: '#3085d6',
             denyButtonColor: '#d33',
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 window.location.href = "<?= base_url("login/logout") ?>";
                 //  Swal.fire('Saved!', '', 'success')
             } else if (result.isDenied) {
                 Swal.fire({
                     position: 'top-center',
                     icon: 'error',
                     title: 'Log out Dibatalkan',
                     showConfirmButton: false,
                     timer: 1500
                 })
             }
         })
     }
 </script>