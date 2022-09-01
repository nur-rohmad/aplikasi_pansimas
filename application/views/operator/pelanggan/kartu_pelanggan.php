<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="<?= base_url('operator/pelanggan') ?>" class="btn btn-md btn-outline-dark float-left mr-2"><i class="fas fa-arrow-left"></i></a>
                    <h1 class="">Kartu Pelanggan</h1>
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

    <!-- content -->
    <div class="content mt-4">
        <div class="row mx-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Kartu Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?= base_url('resource/adminlte31/img/qrcodePelanggan/qrcode-' . $pelanggan['id_pelanggan'] . '.png') ?>" width="60%" alt="kode qr pelanggan">
                            </div>
                            <div class="col-md-8">
                                <table width="100%" style="line-height: 30px;">
                                    <tr>

                                        <td width="20%">ID Pelanggan</td>
                                        <td width="1%" align="center">:</td>
                                        <td width="30%"><?= $pelanggan['id_pelanggan'] ?></td>

                                    </tr>
                                    <tr>
                                        <td>Nama Pelanggan</td>
                                        <td align="center">:</td>
                                        <td><?= $pelanggan['name_pelanggan'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pelanggan</td>
                                        <td align="center">:</td>
                                        <td>Bintoyo, RW. 0<?= $pelanggan['rw_pelanggan']; ?>,
                                            <?php if ($pelanggan['rt_pelanggan'] >= 10) : ?>
                                                RT. <?= $pelanggan['rt_pelanggan']; ?>
                                            <?php else : ?>
                                                RT. 0<?= $pelanggan['rt_pelanggan']; ?>
                                        </td>
                                    <?php endif; ?></td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end content -->

    </div>
</div>