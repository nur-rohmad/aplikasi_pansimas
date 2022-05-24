<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row  mb-5 mr-2">
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
        <div class="card">
            <!-- end notifikasi -->
            <div class="card-body">
                <div class="row ">
                    <div class="col-md-12">
                        <h2 class="text-center">Data Tagihan</h2>
                    </div>
                    <div class="col-lg-8 mx-auto pt-4 ">
                        <form id="payment-form" method="post" action="<?= site_url('pelanggan/tagihan/finish'); ?>" enctype="multipart/form-data">
                            <input type="hidden" name="result_type" id="result-type" value="">
                            <input type="hidden" name="result_data" id="result-data" value="">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Id Tagihan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" readonly name="id_tagihan" id="id_tagihan" value="<?= $transaksi['id_transaksi'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Bulan Tagihan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" readonly name="id_reservasi1" id="bulan_tagihan" value="<?= format_indo($transaksi['tanggal_transaksi'])  ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Total Tagihan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" readonly value="<?= $transaksi['total_bayar'] ?>" name="uang_muka" id="total_bayar">
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10">
                                    <button id="pay-button" class="btn btn-outline-primary float-right mr-2 ml-3"> <i class="fas fa-hand-holding-usd mr-2"></i>Bayar</button>
                                    <a href="<?= base_url('pelanggan/tagihan') ?>" class="btn btn-outline-danger ml-2 float-right"><i class="fas fa-window-close mr-2"></i>Batal</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
        <!-- <button id="pay-button">Pay!</button> -->
    </div>
</div>
</div>

<!-- <button id="pay-button">Pay!</button> -->
<script type="text/javascript">
    $('#pay-button').click(function(event) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");


        var id_tagihan = $("#id_tagihan").val();
        var bulan_tagihan = $("#bulan_tagihan").val();
        var total_bayar = $("#total_bayar").val();
        console.log(id_tagihan, bulan_tagihan, total_bayar)
        $.ajax({
            type: "POST",
            url: '<?= site_url() ?>/pelanggan/tagihan/token',
            data: {
                id: id_tagihan,
                bulan_tagihan: bulan_tagihan,
                total_bayar: total_bayar
            },
            cache: false,

            success: function(data) {
                //location = data;

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    },
                    onError: function(result) {
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    });
</script>