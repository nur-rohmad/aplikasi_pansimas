<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengaduan</h1>
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
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengaduan</h3>
                    <a href="" class="btn btn-success float-right" data-toggle="modal" data-target="#modelId"><i class="fas fa-plus mr-1"></i>Tambah</a>
                </div>

                <div class="card-body">
                    <?php
                    if ($this->session->FlashData('error_pengaduan')) {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <?= $this->session->FlashData('error_pengaduan') ?>
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
                    <?php
                    if ($this->session->FlashData('success_pengaduan')) {
                    ?>
                        <script>
                            Swal.fire("Sukses", "<?= $this->session->FlashData('success_pengaduan') ?>", "success");
                        </script>
                    <?php
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable2" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" widht="10%">No</th>
                                    <th class="text-center">No Pengaduan</th>
                                    <th class="text-center">Jenis Pengaduan</th>
                                    <th class="text-center">Tanggal Pengaduan</th>
                                    <th class="text-center">Status Pengaduan</th>
                                    <th class="text-center" width="10%">Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php if ($data_pengaduan !== null) {
                                    $no = 1;
                                    foreach ($data_pengaduan as $key => $result) { ?>
                                        <tr style="background-color: <?= $result['color_bg'] ?>;">
                                            <td class="text-center"> <?php if ($result['read_status_user'] == 'belum_dilihat') :  ?> <i class="fas fa-circle text-primary" style="font-size: 10px;"></i> <?php endif; ?><?= $no++ ?></td>
                                            <td><?= $result['id_pengaduan'] ?></td>
                                            <td><?= $result['jenis_pengaduan'] ?></td>
                                            <td class="text-center"><?= format_tanggal_indo($result['tgl_pengaduan']) ?></td>
                                            <td class="text-center"> <span class="badge badge-<?= $result['color_status'] ?>"><?= ucwords($result['status_pengaduan']) ?></span> </td>
                                            <td class="text-center"><a href="<?= base_url('pelanggan/pengaduan/lihat_pengaduan/' . $result['id_pengaduan']) ?>" class="btn btn-outline-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">Keerangan : <i class="fas fa-circle text-primary ml-2 mr-2" style="font-size: 10px;"></i> Belum dilihat</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.content -->
</div>

<!-- modal tambah pengaduan -->

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url('pelanggan/pengaduan/procces_pengaduan') ?>?" method="POST">
                    <div class="form-group">
                        <label for="">No Pengaduan</label>
                        <input type="text" class="form-control" value="<?= $no_pengaduan ?>" name="no_pengaduan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Jenis Pengaduan <span class="text-danger">*</span></label>
                        <select name="jenis_pengaduan" class="form-control select-2" data-placeholder="Pilih Jenis Pengaduan">
                            <option value=""></option>
                            <option value="Tagihan">Tagihan</option>
                            <option value="Meteran Air">Meteran Air</option>
                            <option value="Kualitas Air">Kualitas Air</option>
                            <option value="Saluran Air">Saluran Air</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Isi Pengaduan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="isi_pengaduan" id="" rows="3"></textarea>
                    </div>
                    <div class="col-12 mt-4" style="margin-bottom: 0px">
                        <small class="text-danger text-left"> <b><i>CATATAN : Semua field bertanda bintang (*) wajib diisi.</i></b></small>
                    </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="button" class="btn btn-primary">Kirim</button>
            </div>
            </form>
        </div>
    </div>
</div>