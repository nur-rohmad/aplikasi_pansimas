<div class="content">
    <div class="row ml-2">
        <div class="col-sm-8 judul mt-1">
            <h4 class="mt-2 pl-4">Struk Pembayaran Tagihan Air</h4>
            <h4>KP - SPAMS Panguripan Desa Bintoyo</h4>
            <div class="alamat">
                <h5 class="ml-5">Jln. Pandawa No. 16 Ds. Bintoyo</h5>
                <h5 class="tlp">Telp. 0863736267278</h5>
            </div>
        </div>
    </div>
    <!-- <table width="100%">
        <tr>
            <td align="center">Struk Pembayaran Tagihan Air</td>
        </tr>
        <tr>
            <td align="center">KP - SPAMS Panguripan Desa Bintoyo</td>
        </tr>
        <tr>
            <td align="center">
                Jln. Pandawa No. 16 Ds. Bintoyo
            </td>
        </tr>
        <tr>
            <td align="center">

                Telp. 0863736267278

            </td>
        </tr>
    </table> -->
    <br>
    <div class="row tabel ml-2">
        <table>
            <tr>
                <td class="label">ID Pelanggan</td>
                <td>: <?= strtoupper($transaksi['id_pelanggan']); ?></td>
            </tr>
            <tr>
                <td class="label">Nama Pelanggan</td>
                <td>: <?= strtoupper($transaksi['name_pelanggan']); ?></td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: BINTOYO ,
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 1em;">RW. 0<?= $transaksi['rw_pelanggan']; ?>,
                    <?php if ($transaksi['rt_pelanggan'] >= 10) : ?>
                        RT. <?= $transaksi['rt_pelanggan']; ?>
                    <?php else : ?>
                        RT. 0<?= $transaksi['rt_pelanggan']; ?>
                </td>
            <?php endif; ?></td>
            </tr>
            <tr>
                <td class="label">Tagihan Bulan</td>
                <td>: <?= format_indo($transaksi['tanggal_transaksi']) ?></td>
            </tr>

            <tr>
                <td class="label">Stand Meter</td>
                <td>: <?= $transaksi['start_meter'] ?> M<sup>3</sup> - <?= $transaksi['end_meter'] ?> M<sup>3</sup> </td>
            </tr>
            <tr>
                <td class="label">Jumlah Pemakaian </td>
                <td>: <?= $transaksi['jumlah_meteran'] ?> M<sup>3</sup> </td>
            </tr>
            <tr>
                <td class="label">Biaya Meteran</td>
                <td>: <?= $transaksi['jumlah_meteran'] ?> x Rp. <?= number_format($biaya_meter['jumlah_tagihan'], 2, ',', '.') ?> </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">: Rp. <?= number_format($transaksi['biaya_pemakaian'], 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td class="label">Abunemen</td>
                <td>: Rp. <?= number_format($biaya_abunemen['jumlah_tagihan'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <hr style="margin-left: 0.5em; width: 75%; border-top:1px black solid;" color="black">
                    <!-- <div class="garis ml-2"></div> -->
                </td>
                <td>
                    <h1> +</h1>
                </td>
            </tr>
            <tr>
                <td class="label">Total Bayar</td>
                <td>: Rp. <?= number_format($transaksi['total_bayar'], 2, ',', '.') ?></td>
            </tr>
        </table>
    </div>
</div>

<style>
    @page {
        margin: 0px;
    }

    .content {
        margin: 0px;
    }

    @font-face {
        font-family: 'minisystem';
        src: url('<?= base_url('resource/adminlte31/font/minisystem.ttf') ?>');
    }

    .content {
        font-family: 'minisystem';
    }

    .content {
        margin-left: 5em;
        margin-top: 2em;
    }

    .row {
        background-image: url('./resource/adminlte31/img/pansimas.jpeg');
    }

    .garis {
        margin-top: 1.5em;
        width: 100px;
        height: 0px;
        border-bottom: 1px black solid;
    }

    .label {
        padding-right: 5em;
        padding-left: 1em;
        padding-top: 0.5em;
    }

    td {
        letter-spacing: 2px;
        /* font-family: 'minisystem'; */
        font-weight: bold;

    }

    img {
        width: 90px;
        height: 90px;
    }

    .logo {
        float: right;
    }

    .judul {
        width: 100%;
        /* margin-left: 30%;; */
    }

    h4 {
        /* font-family: 'Times New Roman', Times, serif; */
        font-weight: bold;
    }

    .garis {
        width: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        height: 10px;
        color: black;
        margin-top: 0, 5em;
        margin-bottom: 2em;
        margin-right: 1em;

    }

    h5 {
        font-style: italic;
        /* font-family: 'Times New Roman', Times, serif; */
        font-size: 20px;
        font-weight: bold;
    }

    .tlp {
        margin-left: 10%;
    }
</style>
<script>
    window.print()
</script>