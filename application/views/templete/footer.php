<!-- Control Sidebar -->

<!-- /.control-sidebar -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= base_url('operator/') . $this->uri->segment(2) ?>">KP - SPAMS Panguripan</a>.</strong> All rights reserved.
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('resource/adminlte31/') ?>js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('resource/adminlte31/') ?>js/demo.js"></script>
<!-- Select2 -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/select2/js/select2.full.min.js"></script>
<!-- //data tables -->
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('resource/adminlte31/') ?>plugins/pdfmake/vfs_fonts.js"></script>


<script>
  $(document).ready(function() {
    var table = $("#myTable").DataTable({
      "language": {
        "decimal": "",
        "emptyTable": "Tidak ada data yang tersedia",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 - 0 dari 0 data",
        "infoFiltered": "(Berhasil memfilter dari _MAX_ data)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Memuat...",
        "processing": "Memproses...",
        "search": "Pencarian:",
        "zeroRecords": `<i class="fas fa-folder-open fa-2x"></i> <p>Tidak ditemukan data yang cocok</p>`,
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        },
      },

      dom: 'Bfrtip',
      lenghtMenu: [
        [10, 25, 50, -1],
        ['q', 'q', 'e', 'e']
      ],
      // lengthChange: true,
      buttons: [{
          extend: "print",
          text: '<i class="fas fa-print mr-1"></i>Print',
          className: "btn btn-success mr-2",
          title: '<h1 >Data  Transaksi KP - SPAMS Panguripan</h1> ',
          exportOptions: {
            columns: ':visible:not(:contains(Action),:contains(No))'
          }
        },
        {
          extend: "excel",
          text: '<i class="fas fa-file-excel mr-1"></i> Donwload Excel',
          className: "btn btn-primary mr-2",
          filename: 'data_transaksi',
          title: 'Data  Transaksi KP - SPAMS Panguripan ',
          exportOptions: {
            columns: ':visible:not(:contains(Action),:contains(No))'
          }
        },
        {
          extend: "pdf",
          text: '<i class="fas fa-file-pdf mr-1"></i> Donwload PDF',
          className: "btn btn-warning mr-2",
          filename: 'data_transaksi',
          title: 'Data  Transaksi KP - SPAMS Panguripan ',
          exportOptions: {
            columns: ':visible:not(:contains(Action),:contains(No))'
          }
        }
      ],
      "searching": true
    });

    var table = $("#myTable2").DataTable({
      lengthChange: false,
      "language": {
        "decimal": "",
        "emptyTable": "Tidak ada data yang tersedia",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 - 0 dari 0 data",
        "infoFiltered": "(Berhasil memfilter dari _MAX_ data)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Memuat...",
        "processing": "Memproses...",
        "search": "Pencarian:",
        "zeroRecords": `<i class="fas fa-folder-open fa-2x"></i> <p>Tidak ditemukan data yang cocok</p>`,
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        },
      }

    });
    var table1 = $("#myTable1").DataTable({
      lengthChange: false,
      "language": {
        "decimal": "",
        "emptyTable": "Tidak ada data yang tersedia",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 - 0 dari 0 data",
        "infoFiltered": "(Berhasil memfilter dari _MAX_ data)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Tampilkan _MENU_ data",
        "loadingRecords": "Memuat...",
        "processing": "Memproses...",
        "search": "Pencarian:",
        "zeroRecords": `<i class="fas fa-folder-open"></i> Tidak ditemukan data yang cocok`,
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        },
      }

    });

    // table.buttons().container().appendTo(".col-md-6:eq(0)");

  });

  //   $(document).ready( function () {
  //     $('#myTable').DataTable();
  // } );


  $(document).ready(function() {
    $('.select-2').select2({
      theme: 'bootstrap4',
    });
  });
</script>



</body>

</html>