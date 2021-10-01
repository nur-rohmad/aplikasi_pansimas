<div class="card-header ">
     <h3 class=" text-center">Rekap Laporan Struk Tagihan Air KP- SPAMS Panguripan Bulan <?= date("F  Y" ); ?></h3>
 </div>
<div class="card-body">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th class="text-center" widht="10%" >No</th>
                        <th class="text-center">ID Pelanggan</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Bulan Tagihan</th>
                        <th class="text-center">Start Meter</th>
                        <th class="text-center">End Meter</th>
                        <th class="text-center">Jumlah Meteran</th>
                        <th class="text-center">Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($transaksi != null): ?>
                        <?php $i=1; ?>
                        <?php foreach($transaksi as $data): ?>
                        <tr>
                            <td class="text-center"><?= $i; ?></td>
                            <td><?= $data['id_pelanggan']; ?></td>                          
                            <td><?= $data['name_pelanggan']; ?></td>                          
                            <td class="text-center"> <?= date("F  Y",strtotime($data['tanggal_transaksi']), ); ?></td>                                                 
                            <td class="text-center"><?= $data['start_meter']; ?></td>                          
                            <td class="text-center"><?= $data['end_meter']; ?></td>                          
                            <td class="text-center"> <?= $data['jumlah_meteran']; ?></td>                                                 
                            <td class="text-center"> Rp. <?= number_format($data['total_bayar'],2,',','.'); ?></td>                                                 
                           
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="6" class="text-center"><strong>TOTAL </strong></td>
                            <td class="text-center"><strong><?= $total_meteran['total'] ?></strong></td>
                            <td><strong>Rp. <?= number_format($total_pendapatan['total'],2,',','.');  ?> </strong> </td>
                        </tr>
                        <?php else: ?>
                            <tr class="text-center">
                                <td colspan="6">Data Tidak di Temukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    </table>
                </div>

                <style>
                    h3{
                        font-family: 'Times New Roman', Times, serif;
                        font-weight: bold;
                    }
                </style>
                <script>
                    window.print();
                </script>