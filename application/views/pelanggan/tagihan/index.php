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

        <!-- tabel transaksi -->

        <div class="card">
            <div class="card-header mt-2" id="title-card">
                <h3 class="card-title text-center">Tabel Tagihan </h3>
            </div>
            <!-- motifikasi -->
            <?php
            if ($this->session->FlashData('success_transaksi')) {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->FlashData('success_transaksi') ?>
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
                    <table class="table table-striped table-bordered" id="myTable2" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" widht="10%">No</th>
                                <th class="text-center">ID Pelanggan</th>
                                <th class="text-center">Bulan Tagihan</th>
                                <th class="text-center">Total Tagihan</th>
                                <th class="text-center">Status Tagihan</th>
                                <th class="text-center" width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transaksi != null) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($transaksi as $data) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>
                                        <td><?= $data['id_pelanggan']; ?></td>
                                        <td class="text-center"> <?= format_indo($data['tanggal_transaksi'])  ?></td>
                                        <td class="text-center"> Rp. <?= number_format($data['total_bayar'], 0, ',', '.'); ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($data['status_pembayaran'] == 'waiting') : ?>

                                                <span class="badge badge-warning text-white">Waiting</span>
                                            <?php elseif ($data['status_pembayaran'] == 'succes') : ?>

                                                <span class="badge badge-success">suksess</span>
                                            <?php elseif ($data['status_pembayaran'] == 'belum_bayar') : ?>
                                                <span class="badge badge-info">Belum Bayar</span>
                                            <?php else : ?>
                                                <span class="badge badge-danger">Gagal</span>
                                            <?php endif; ?>
                                            <!-- <span class="badge badge-warning"><?= $data['status_pembayaran'] ?></span> -->
                                        </td>
                                        <td class="text-center">
                                            <!-- <a target="blank" href="<?= base_url('pelanggan/tagihan/download_nota/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-info"><i class="fas fa-print"></i> Cetak</a>
                                        <a target="blank" href="<?= base_url('pelanggan/tagihan/download_pdf/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> download</a> -->
                                            <?php if ($data['status_pembayaran'] == 'belum_bayar' || $data['status_pembayaran'] == 'gagal') : ?>

                                                <a href="<?= base_url('pelanggan/tagihan/bayar_tagihan/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-dark"> bayar <i class="fas fa-arrow-right ml-2"></i></a>
                                            <?php elseif ($data['status_pembayaran'] == 'succes') : ?>
                                                <a href="<?= base_url('pelanggan/tagihan/download_pdf/') . $data['id_transaksi'] ?>" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Bukti Pembayaran</a>
                                            <?php else : ?>
                                                <button id="detail" onclick="detail( '<?= $data['id_transaksi'] ?>')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> detail</button>
                                            <?php endif;  ?>

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
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- /.content -->
    <!-- <button id="pay-button">Pay!</button> -->
</div>
<script>
    function detail(a) {
        $.ajax({
            url: '<?= base_url('pelanggan/tagihan/get_detail_tagihan') ?>',
            type: "GET",
            // dataType: "JSON",
            data: {
                id_tagihan: a
            },
            cache: false,
            success: function(data) {

                var data1 = JSON.parse(data)
                console.log(data1)
                // console.log(data)
                var bank = data1.data.bank;

                var va_numbers = ''
                if (bank == "mandiri") {
                    va_numbers = `<div class="col-6"><h6>Kode Perusahaan</h6> </div>
                                <div class="col-6"><h6>Kode Pembayaran</h6> </div>
                        <div class="col-6"><h2 class="text-primary">` + data1.va_numbers.biller_code + `</h2></div>
                        <div class="col-6"><h2 class="text-primary">` + data1.va_numbers.bill_key + `</h2></div>`
                } else {
                    va_numbers = `<div class="col-12"><h6>Virtual Number</h6> </div>
                        <div class="col-12"><h2 class="text-primary">` + data1.data.va_number + `</h2></div>`
                }
                // var bank = data1.bank
                Swal.fire({
                    title: '<strong>Detail Tagihan</strong>',
                    // icon: 'info',
                    html: `
                    <div class="row">
                    <div class="col-12">
                    <div class="row">
                        <div class="col-12 text-center mt-4"><h6 >ID Transaksi</h6></div>
                        <div class="col-12 text-center"><h4>` + data1.data.id_transaksi + `</h4></div>
                
                        <div class="col-12"><h6>Bank</h6> </div>
                        <div class="col-12 "><h2 class="text-success"><img src="<?= base_url('') ?>resource/adminlte31/img/bank/` + data1.data.bank + `.png" width="200px" height="80px" ></h2></div>` + va_numbers +
                        `
                        <div class="col-12"><h6>Batas Waktu Pembayaran</h6> </div>
                        <div class="col-12"><h2 class="">` + data1.waktu + `</h2></div>
                    </div>
                    </div>
                   
                    </div>
                    `,
                    showDenyButton: true,
                    confirmButtonText: '<a target="_blank"  href="' + data1.data.link_petunjuk_pembayaran + '" class="text-white" ><i class="fas fa-download"></i> Cara Pembayaran</a>',
                    denyButtonText: `<i class="fas fa-window-close mr-2 "></i>Close`,
                    confirmButtonColor: '#28a745',


                })
            }
        })
    }
</script>