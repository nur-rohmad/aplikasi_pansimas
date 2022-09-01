<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<div class="content">
    <!-- <div class="row ml-2">
        <div class="col-sm-8  mt-1 text-center">
            <p class="mt-2  text-center">Struk Pembayaran Tagihan Air</p><br>
            <span>KP - SPAMS Panguripan Desa Bintoyo</span><br>
            <div class="alamat">
                <span class="ml-5">Jln. Pandawa No. 16 Ds. Bintoyo</span><br>
                <span class="tlp">Telp. 0863736267278</span>
            </div>
        </div>
    </div> -->

    <table width="100%">
        <tr>
            <td align="center"><span class="judul">Struk Pembayaran Tagihan Air</span></td>
        </tr>
        <tr>
            <td align="center" class="judul">KP - SPAMS Panguripan Desa Bintoyo</td>
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
    </table>
    <br>
    <div class="row tabel ">
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
                <td>: <?= $transaksi['jumlah_meteran'] ?> x Rp. <?= number_format($biaya_meter['jumlah_tagihan'], 0, ',', '.') ?> </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">: Rp. <?= number_format($transaksi['biaya_pemakaian'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td class="label">Abunemen</td>
                <td>: Rp. <?= number_format($biaya_abunemen['jumlah_tagihan'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <!-- <hr style="margin-left: 0.5em; width: 75%; border-top:1px black solid;" color="black"> -->
                    <div class="garis ml-2"></div>
                </td>
                <td>
                    <span style="font-size: 1.5em; color: black; font-weight: bold; margin-left: 1em;"> +</span>
                </td>
            </tr>
            <!-- <tr>
                <td colspan="2">
                    <div class="lunas">
                        <span><u>LUNAS</u></span>
                        <span class="tgl">Tanggal : <?= format_tanggal_indo($transaksi['waktu_bayar']) ?></span>
                    </div>
                </td>
            </tr> -->
            <tr>
                <td class="label">Total Bayar</td>
                <td>: Rp. <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
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
        margin-left: 2em;
        margin-top: 1em;
    }

    .row {
        background-image: url('./resource/adminlte31/img/pansimas.jpeg');
    }

    .garis {
        margin-top: 0.5em;
        width: 100px;
        height: 0px;
        border-bottom: 1px black solid;
    }

    .label {
        padding-right: 2em;
        padding-left: 1em;
        padding-top: 0.5em;
    }

    td {
        letter-spacing: 2px;
        /* font-family: 'minisystem'; */
        /* font-weight: bold; */

    }

    img {
        width: 90px;
        height: 90px;
    }

    .logo {
        float: right;
    }

    .judul {
        font-size: 20px;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
    }

    .lunas {
        margin-bottom: -100em;
        margin-left: 6em;
        width: 220px;
        transform: rotate(-30deg);
        letter-spacing: 25px;
        padding: 10px;
        border: 4px solid red;
        border-style: double;
        color: red;
        font-family: 'Anton', sans-serif;
        font-size: 30px;
        font-weight: bold;
        border-radius: 10px;
        opacity: 0.3;
    }

    .tgl {
        font-size: 15px;
        letter-spacing: 0px;
    }

    h4 {
        /* font-family: 'Times New Roman', Times, serif; */
        font-weight: bold;
    }

    .garis {
        width: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        height: 1px;
        color: black;
        /* margin-top: 0.5em; */
        /* margin-bottom: 1em; */
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
<!-- <script>
    window.print()
</script> -->