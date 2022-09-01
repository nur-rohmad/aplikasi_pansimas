 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Pembayaran</h1>
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
         <div class="card">
             <div class="card-header mt-2">
                 <h3 class="card-title text-center">Daftar Transaksi Belum Terbayar</h3>
             </div>
             <!-- motifikasi -->
             <?php
                if ($this->session->FlashData('gagal_bayar')) {
                ?>
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $this->session->FlashData('gagal_bayar') ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             <?php
                }
                ?>
             <!-- end notifikasi -->
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered" id="myTable2">
                         <thead>
                             <tr>
                                 <th class="text-center" widht="10%">No</th>
                                 <th class="text-center">ID Pelanggan</th>
                                 <th class="text-center">Nama Pelanggan</th>
                                 <th class="text-center">Bulan Tagihan</th>
                                 <th class="text-center">Jumlah Tagihan</th>
                                 <th class="text-center">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php if ($belum_bayar != null) : ?>
                                 <?php $i = 1; ?>
                                 <?php foreach ($belum_bayar as $data) : ?>
                                     <tr>
                                         <td class="text-center"><?= $i; ?></td>
                                         <td><?= $data['id_pelanggan']; ?></td>
                                         <td class="text-center"> <?= $data['name_pelanggan'] ?> </td>
                                         <td class="text-center"><?= format_indo($data['tanggal_transaksi']) ?></td>
                                         <td class="text-center">Rp. <?= number_format($data['total_bayar'], 0, ',', '.'); ?></td>
                                         <td class="text-center">
                                             <button onclick="bayar('<?= $data['id_transaksi'] ?>')" class=" btn btn-outline-primary">Bayar <i class="fas fa-hand-holding-usd ml-2"></i></button>
                                         </td>
                                     </tr>
                                     <?php $i++; ?>
                                 <?php endforeach; ?>
                             <?php else : ?>
                                 <tr class="text-center">
                                     <td colspan="5">Data Tidak di Temukan</td>
                                 </tr>
                             <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         <div class="card">
             <div class="card-header mt-2">
                 <h3 class="card-title">Daftar Transaksi Telah Terbayar</h3>
             </div>
             <!-- motifikasi -->
             <?php
                if ($this->session->FlashData('success_bayar')) {
                ?>
                 <script>
                     Swal.fire("Sukses", "<?= $this->session->FlashData('success_bayar') ?>", "success");
                 </script>
                 <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <?= $this->session->FlashData('success_bayar') ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div> -->
             <?php
                }
                ?>
             <!-- end notifikasi -->
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered" id="myTable1">
                         <thead>
                             <tr>
                                 <th class="text-center" widht="10%">No</th>
                                 <th class="text-center">ID Pelanggan</th>
                                 <th class="text-center">Nama Pelanggan</th>
                                 <th class="text-center">Bulan Tagihan</th>
                                 <th class="text-center">Jumlah Tagihan</th>
                                 <th class="text-center">Metode Pembayaran</th>
                                 <th class="text-center">Status Pembayaran</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php if ($sudah_bayar != null) : ?>
                                 <?php $i = 1; ?>
                                 <?php foreach ($sudah_bayar as $data) : ?>
                                     <tr>
                                         <td class="text-center"><?= $i; ?></td>
                                         <td class="text-center"><?= $data['id_pelanggan']; ?></td>
                                         <td class="text-center"><?= $data['name_pelanggan']; ?></td>
                                         <td><?= format_indo($data['tanggal_transaksi']); ?></td>
                                         <td class="text-center"> Rp. <?= number_format($data['total_bayar'], 0, ',', '.'); ?> </td>
                                         <td class="text-center">
                                             <?php
                                                if ($data['metode_pembayaran'] == 'manual') { ?>
                                                 <button class="btn btn-primary btn-sm" onclick="detail_bayar('<?= $data['id_transaksi'];  ?>')"> <i class="fas fa-user mr-2"></i>Melalui Admin</button>

                                             <?php } else { ?>

                                                 <button class="btn btn-primary btn-sm" onclick="detail_bayar('<?= $data['id_transaksi'];  ?>')"><i class="fas fa-university mr-2"></i> Transfer Bank</button>
                                             <?php } ?>

                                         </td>
                                         <td class="text-center">
                                             <?php
                                                if ($data['status_pembayaran'] == 'waiting') : ?>

                                                 <span class="badge badge-warning text-white">Waiting</span>
                                             <?php elseif ($data['status_pembayaran'] == 'succes') : ?>

                                                 <span class="badge badge-success">Success</span>
                                             <?php elseif ($data['status_pembayaran'] == 'belum_bayar') : ?>
                                                 <span class="badge badge-info">Belum Bayar</span>
                                             <?php else : ?>
                                                 <span class="badge badge-danger">Gagal</span>
                                             <?php endif; ?>
                                             <!-- <span class="badge badge-warning"><?= $data['status_pembayaran'] ?></span> -->
                                         </td>
                                     </tr>
                                     <?php $i++; ?>
                                 <?php endforeach; ?>
                             <?php else : ?>
                                 <tr class="text-center">
                                     <td colspan="5">
                                         <i class="fas fa-folder-open fa-2x mt-2"></i>
                                         <p>Data Tidak di Temukan</p>
                                     </td>
                                 </tr>
                             <?php endif; ?>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>

     <!-- < !-- modal bayar-->
     <div class="modal fade" id="modal">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title text-danger">Anda Yakin Ingin Melakukan Pembayaran Denagan Data Berikut ?</h5>
                     <button class="close" data-dismiss="modal">
                         <span class="text-danger">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form id="form" method="POST" action="<?= base_url('operator/pembayaran/proccess_pembayaran_manual') ?>">
                         <input type="hidden" name="id">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>ID Transaksi</label>
                                     <input type="text" class="form-control" placeholder="Nama" name="id_transaksi" readonly required>
                                 </div>
                                 <div class="form-group">
                                     <label>Nama Pelanggan</label>
                                     <input type="text" class="form-control" placeholder="Nama" name="name_pelanggan" readonly required>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>ID Pelanggan</label>
                                     <input type="text" class="form-control" placeholder="Nama" name="id_pelanggan" readonly required>
                                 </div>

                                 <div class="form-group">
                                     <label>Total Bayar</label>
                                     <input type="text" class="form-control" placeholder="Alamat" name="total_bayar" required readonly>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12 text-right">
                             <button class="btn btn-outline-danger " data-dismiss="modal"> Batal <i class="fas fa-window-close ml-2"></i></button>
                             <button class="btn btn-outline-primary" type="submit">Bayar<i class="fas fa-coins ml-2"></i></button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- end modal -->
     <!-- modal informasi detail pembayran-->
     <div class="modal fade" id="modal_detail_pembayaran">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header ">
                     <h5 class="modal-title ">Informasi Detail Pembayaran</h5>
                 </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-5">
                             <div class="form-group">
                                 <label>No Transaksi</label>
                                 <div class="input-group mb-3">
                                     <div class="input-group-prepend">
                                         <span class=" input-group-text" id="basic-addon3"> <i class="fas fa-barcode"></i></span>
                                     </div>
                                     <input type="text" class="form-control" name="id_transaksi2" readonly>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label id="metode_pembayaran">Bank Yang Digunakan</label>
                                 <div class="input-group mb-3">
                                     <div class="input-group-prepend">
                                         <span class=" input-group-text" id=""> <i class="fas fa-university"></i></span>
                                     </div>
                                     <input type="text" class="form-control" name="bank" readonly>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-7">
                             <div class="form-group">
                                 <label id="label_waktu">Waktu Pembayaran</label>
                                 <div class="row">
                                     <div class="col-7">
                                         <div class="input-group">
                                             <div class="input-group-prepend">
                                                 <span class="input-group-text" id="basic-addon3"> <i class="fas fa-calendar-alt"></i></span>
                                             </div>
                                             <input type="text" class="form-control" name="waktu_bayar" readonly>
                                         </div>
                                     </div>
                                     <div class="col-5">
                                         <div class="input-group">
                                             <div class="input-group-prepend">
                                                 <span class=" input-group-text" style="padding-left: 10px;" id="basic-addon3"> <i class="fas fa-clock"></i></span>
                                             </div>
                                             <input type="text" class="form-control" style="padding-left: 10px;" name="jam_bayar" readonly>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label>Di Bayarkan Oleh</label>
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class=" input-group-text" id="basic-addon3"> <i class="fas fa-user"></i></span>
                                     </div>
                                     <input type="text" class="form-control" name="pembayaran_by" readonly>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 text-right">
                         <button class="btn btn-outline-dark " data-dismiss="modal"> Close <i class="fas fa-window-close ml-2"></i></button>

                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
 <!-- end modal -->
 <!-- /.content -->
 </div>

 <script>
     function bayar(id) {
         //  console.log(id);
         $.ajax({
             url: '<?= base_url('operator/pembayaran/get_data_pembayaran') ?>',
             type: "post",
             dataType: "json",
             data: {
                 id_transaksi: id
             },
             success: res => {
                 //  var data = JSON.parse(res)
                 console.log(res);
                 $('[name="id_transaksi"]').val(res.data.id_transaksi);
                 $('[name="id_pelanggan"]').val(res.data.id_pelanggan);
                 $('[name="name_pelanggan"]').val(res.data.name_pelanggan);
                 $('[name="total_bayar"]').val("Rp. " + res.total_bayar)
                 $('#modal').modal('show');
             },
             error: err => {
                 console.log(err)
             }
         })
     }

     function detail_bayar(id) {
         $.ajax({
             url: '<?= base_url('operator/pembayaran/get_data_detail_pembayaran') ?>',
             type: "post",
             dataType: "json",
             data: {
                 id_transaksi: id
             },
             success: res => {
                 //  var data = JSON.parse(res)
                 console.log(res);
                 $('[name="id_transaksi2"]').val(res.data.id_transaksi);
                 if (res.data.status_pembayaran == 'waiting') {
                     $('#label_waktu').html("Batas Waktu Pembayaran")
                 } else {
                     $('#label_waktu').html("Waktu Pembayaran")
                 }
                 $('[name="waktu_bayar"]').val(res.tanggal);
                 $('[name="jam_bayar"]').val(res.jam);
                 if (res.data.metode_pembayaran == 'manual') {
                     $('#metode_pembayaran').html("Metode Pembayaran")
                     $('[name="bank"]').val("Setor Tunai");
                 } else {
                     $('#metode_pembayaran').html("Bank Yang Digunakan")
                     $('[name="bank"]').val(res.data.bank);
                 }

                 $('[name="pembayaran_by"]').val(res.data.pembayaran_by + " (" + res.role_user + ")");
                 $('#modal_detail_pembayaran').modal('show');
             },
             error: err => {
                 console.log(err)
             }
         })

     }
 </script>