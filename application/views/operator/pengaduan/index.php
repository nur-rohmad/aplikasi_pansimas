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
                                            <td class="text-center"><?php if ($result['respone_pengaduan'] == '') :  ?> <i class="fas fa-circle text-danger" style="font-size: 10px;"></i> <?php endif; ?> <?php if ($result['read_status_admin'] == 'belum_dilihat') :  ?> <i class="fas fa-circle text-primary" style="font-size: 10px;"></i> <?php endif; ?><?= $no++ ?></td>
                                            <td><?= $result['id_pengaduan'] ?></td>
                                            <td><?= $result['jenis_pengaduan'] ?></td>
                                            <td class="text-center"><?= format_tanggal_indo($result['tgl_pengaduan']) ?></td>
                                            <td class="text-center"> <span class="badge badge-<?= $result['color_status'] ?>"><?= ucwords($result['status_pengaduan']) ?></span> </td>
                                            <td class="text-center"><a href="<?= base_url('operator/pengaduan/lihat_pengaduan/' . $result['id_pengaduan']) ?>" class="btn btn-outline-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                        </tr>
                                    <?php } ?>

                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="py-3" colspan="6">Keerangan : <i class="fas fa-circle text-primary ml-2 mr-2" style="font-size: 10px;"></i> Belum dilihat <i class="fas fa-circle text-danger ml-2 mr-2" style="font-size: 10px;"></i> Belum direspone <i class="fas fa-circle text-danger ml-2 " style="font-size: 10px;"></i><i class="fas fa-circle text-primary mr-2" style="font-size: 10px;"></i> Belum dilihat dan Belum direspone</td>
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