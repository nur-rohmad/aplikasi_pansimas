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
         <img src="<?= base_url('resource/adminlte31/') ?>/img/<?= $user_data['user_photo']  ?>" class="img elevation-2" alt="User Image">
       </div>
       <div class="info">
         <a href="#" class="d-block"><?= $user_data['user_name']; ?></a>
         <a href="<?= base_url('login/logout') ?>"><i class="fas fa-sign-out-alt"></i></a>
       </div>
     </div>

     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="<?= base_url('operator/dashboard') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Dashboard
             </p>
           </a>
         </li>

         <li class="nav-item ">
           <a href="<?= base_url('operator/pelanggan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'pelanggan' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Pelanggan
             </p>
             <!-- <i class="right fas fa-angle-left"></i> -->
           </a>
           <!-- <ul class="nav nav-treeview">
             <li class="nav-item ml-3">
               <a href="<?= base_url('operator/dashboard') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>">
                 <i class="nav-icon fas fa-tachometer-alt"></i>
                 <p>
                   Stan Meter
                 </p>
               </a>
             </li>

           </ul> -->
         </li>

         <li class="nav-item">
           <a href="<?= base_url('operator/transaksi') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'transaksi' ? 'active' : '' ?>">
             <i class="nav-icon fas fa-cash-register"></i>
             <p>
               Transaksi
             </p>
           </a>
         </li>

         <li class="nav-item">
           <a href="<?= base_url('operator/laporan') ?>" class="nav-link <?php echo $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" class="nav-link">
             <i class="nav-icon fas fa-file-alt"></i>
             <p>
               Laporan
             </p>
           </a>
         </li>

       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>