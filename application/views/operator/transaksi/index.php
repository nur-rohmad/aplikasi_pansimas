<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <?php foreach ($this->uri->segments as $segment) : ?>
                            <?php
                            $url = substr($this->uri->uri_string, 0, strpos($this->uri->uri_string, $segment)) . $segment;
                            $is_active =  $url == $this->uri->uri_string;
                            ?>
                            <li class="breadcrumb-item <?php echo $is_active ? 'active' : '' ?>">
                                <?php if ($is_active) : ?>
                                    <?php echo ucfirst($segment) ?>
                                <?php else : ?>
                                    <a href="#"><?php echo ucfirst($segment) ?></a>
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
                <h3 class="card-title text-center">Tabel Tagihan</h3>

            </div>
            <!-- motifikasi -->
            <?php
            if ($this->session->FlashData('success_tagihan')) {
            ?>
                <script>
                    Swal.fire("Sukses", "<?= $this->session->FlashData('success_tagihan') ?>", "success");
                </script>
            <?php
            }
            ?>
            <!-- end notifikasi -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" widht="10%">No</th>
                            <th class="text-center">Nama Tagihan</th>
                            <th class="text-center">Jumlah Tagihan</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tagihan != null) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($tagihan as $data) : ?>
                                <tr>
                                    <td class="text-center"><?= $i; ?></td>
                                    <td><?= $data['name_tagihan']; ?></td>
                                    <td class="text-center"> Rp. <?= $data['jumlah_tagihan']; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('operator/transaksi/edit_tagihan/') . $data['id_tagihan'] ?>" class="btn btn-sm btn-info"><i class="fas fa-edit mr-1"></i>edit</a>
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

        <!-- tabel transaksi -->

        <div class="card">
            <div class="card-header mt-2" id="title-card">
                <h3 class="card-title text-center">Transaksi Bulan <?= format_indo(date("Y-m-d")) ?></h3>
                <div class="button d-none d-xl-block">
                    <a class="btn btn-success float-right" href="<?= base_url('operator/transaksi/add_transaksi') ?>"><i class="fas fa-plus mr-1"></i> Add</a>
                    <a class="btn btn-dark float-right mr-2" href="<?= base_url('operator/transaksi/export_excel') ?>"><i class="fas fa-file-excel mr-1"></i> Export Excel</a>
                    <a target="blank" class="btn btn-primary float-right mr-2" href="<?= base_url('operator/transaksi/cetak_laporan_bulanan') ?>"><i class="fas fa-print mr-1"></i> Transaksi Bulan <?= format_indo(date("Y-m-d")) ?></a>
                    <button type="button" class="btn btn-warning float-right mr-2 text-white" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-print mr-1"></i> Cetak Nota
                    </button>
                </div>
                <br>
                <div class="dropdown d-block d-xl-none">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="btn btn-success dropdown-item" href="<?= base_url('operator/transaksi/add_transaksi') ?>"><i class="fas fa-plus mr-1"></i> Add</a>
                        <a class="btn btn-dark dropdown-item " href="<?= base_url('operator/transaksi/export_excel') ?>"><i class="fas fa-file-excel mr-1"></i> Export Excel</a>
                        <a target="blank" class="btn btn-primary dropdown-item " href="<?= base_url('operator/transaksi/cetak_laporan_bulanan') ?>"><i class="fas fa-print mr-1"></i> Transaksi Bulan <?= format_indo(date("Y-m-d")) ?></a>
                        <button type="button" class="btn btn-warning dropdown-item " data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-print mr-1"></i> Cetak Nota
                        </button>
                    </div>
                </div>
            </div>
            <!-- motifikasi -->
            <?php
            if ($this->session->FlashData('success_transaksi')) {
            ?>
                <script>
                    Swal.fire("Sukses", "<?= $this->session->FlashData('success_transaksi') ?>", "success");
                </script>
            <?php
            }
            ?>
            <?php
            if ($this->session->FlashData('success_delete_transaksi')) {
            ?>
                <script>
                    Swal.fire("Sukses", "<?= $this->session->FlashData('success_delete_transaksi') ?>", "success");
                </script>
            <?php
            } else if ($this->session->FlashData('gagal_delete_transaksi')) {
            ?>
                <script>
                    Swal.fire("Gagal", "<?= $this->session->FlashData('gagal_delete_transaksi') ?>", "error");
                </script>
            <?php } ?>
            <!-- end notifikasi -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable2">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" widht="10%">No</th>
                                <th class="text-center">ID Pelanggan</th>
                                <th class="text-center">Nama Pelanggan</th>
                                <th class="text-center">Bulan Tagihan</th>
                                <th class="text-center">Meteran Awal</th>
                                <th class="text-center">Meteran Akhir</th>
                                <th class="text-center">Jumlah Meteran</th>
                                <th class="text-center">Total Tagihan</th>
                                <th class="text-center align-middle" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transaksi != null) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($transaksi as $data) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <td><?= $data['id_pelanggan']; ?></td>
                                        <td><?= $data['name_pelanggan']; ?></td>
                                        <td class="text-center"> <?= format_indo($data['tanggal_transaksi'])  ?></td>
                                        <td class="text-center"><?= $data['start_meter']; ?></td>
                                        <td class="text-center"><?= $data['end_meter']; ?></td>
                                        <td class="text-center"> <?= $data['jumlah_meteran']; ?></td>
                                        <td class="text-center"> Rp. <?= number_format($data['total_bayar'], 0, ',', '.'); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('operator/transaksi/cetak_nota/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-info"><i class="fas fa-print"></i> Cetak</a>
                                            <a href="<?= base_url('operator/transaksi/delete_transaksi/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-danger mt-2"><i class="fas fa-trash-alt"></i> Hapus</a>

                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>

                            <?php else : ?>
                                <tr class="text-center">
                                    <td colspan="9">
                                        <i class="fas fa-folder-open fa-2x mt-2"></i>
                                        <p>Data Tidak di Temukan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-center"><strong>TOTAL </strong></td>
                                <td class="text-center"><strong><?= $total_meteran['total'] ?></strong></td>
                                <td colspan="2"><strong>Rp. <?= number_format($total_pendapatan['total'], 0, ',', '.');  ?> </strong> </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- modal cetak nota -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url('operator/transaksi/cetak_semua_nota') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Masukkan Halaman</label>
                        <div class="row">
                            <div class="col-5">
                                <input type="number" id="min_page" min="1" max="<?= $total_transaksi ?>" placeholder="Halaman Awal" class="form-control" name="page_awal" required>
                            </div>
                            <div class="col-1 text-center pt-2">
                                -
                            </div>
                            <div class="col-5">
                                <input type="number" id="max_page" max="<?= $total_transaksi ?>" placeholder="Halaman Akhir" class="form-control" name="page_akhir" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </div>
        </div>
        </form>
    </div>
</div>
<!-- end cetak nota -->