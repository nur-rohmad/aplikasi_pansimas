<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan</h1>
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
    <div class="content">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="card-title text-center">Tabel Laporan</h3>
            </div>
            <div class="row ml-1 mt-2">
                <div class="col-md-12">
                    <!-- SEARCH BAR NAVIGATION -->
                    <form class="form" action="<?= base_url('operator/laporan/search_process') ?>" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2 col-12">
                                    <div class="form-group my-1">
                                        <select name="bulan_transaksi" class="form-control select-2" placeholder="Pilih Jenis">
                                            <option value="">Pilih Bulan</option>
                                            <?php
                                            $no = 1;
                                            foreach ($bulan as $data_bulan) : ?>
                                                <option value="<?= $no++; ?>" <?php
                                                                                $select = $no - 1;
                                                                                if (isset($search['bulan'])) {
                                                                                    if ($search['bulan'] == $select) {
                                                                                        echo "selected";
                                                                                    } else {
                                                                                        echo "";
                                                                                    }
                                                                                } else {
                                                                                    echo "";
                                                                                }
                                                                                ?>>
                                                    <?= $data_bulan; ?></option>
                                            <?php endforeach; ?>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group my-1">
                                        <input type="text" class="form-control" name="tahun_transaksi" value="<?php
                                                                                                                if (empty($search['tahun'])) {
                                                                                                                    echo "";
                                                                                                                } else {
                                                                                                                    echo $search['tahun'];
                                                                                                                }
                                                                                                                ?>" placeholder="Tahun ">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group my-1">
                                        <button class="btn btn-primary" type="submit" name="save" value="Cari"><i class="fa fa-search"></i></button>
                                        <button class="btn btn-outline-secondary" type="submit" name="save" value="Reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="form-body">


                        <div class="card-body">
                            <table id="myTable" class="table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Bulan Tagihan</th>
                                        <th>Start Meter</th>
                                        <th>End Meter</th>
                                        <th>Jumlah Meteran</th>
                                        <th>Total Tagihan</th>
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
                                                <td class="text-center"> <?= date("F  Y", strtotime($data['tanggal_transaksi']),); ?></td>
                                                <td class="text-center"><?= $data['start_meter']; ?></td>
                                                <td class="text-center"><?= $data['end_meter']; ?></td>
                                                <td class="text-center"> <?= $data['jumlah_meteran']; ?></td>
                                                <td class="text-center"> Rp. <?= number_format($data['total_bayar'], 2, ',', '.'); ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                        <!-- <tr>
                            
                            </tr> -->
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="8">
                                                <i class="fas fa-folder-open fa-2x mt-2"></i>
                                                <p>Data Tidak di Temukan</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <!-- <tfoot>
                            <td colspan="7" class="text-center"><strong>TOTAL PENDAPATAN</strong></td>
                            <td>Rp. <?= number_format($total_pendapatan['total'], 2, ',', '.');  ?> </td>
                    </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>