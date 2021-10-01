<div class="card-header ">
     <h3 class=" text-center">Rekap Daftar Pelanggan KP- SPAMS Panguripan </h3>
 </div>
<div class="card-body">
                    <table class="table table-bordered" id="">
                    <thead>
                        <tr>
                        <th class="text-center" widht="10%" >No</th>
                        <th class="text-center">ID Pelanggan</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">RW</th>
                        <th class="text-center">RT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($pelanggan != null): ?>
                        <?php $i=1; ?>
                        <?php foreach($pelanggan as $data): ?>
                        <tr>
                            <td class="text-center"><?= $i; ?></td>
                            <td><?= $data['id_pelanggan']; ?></td>                          
                            <td><?= $data['name_pelanggan']; ?></td>                          
                            <td class="text-center"> BINTOYO 0<?= $data['rw_pelanggan']; ?></td>                          
                            <td class="text-center"><?= $data['rt_pelanggan']; ?></td>                          
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="text-center">
                                <td colspan="5">Data Tidak di Temukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    </table>
                </div>
                <script>
                    window.print();
                </script>