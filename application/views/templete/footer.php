<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= base_url('operator/') . $this->uri->segment(2) ?>">KP - SPAMS Panguripa</a>.</strong> All rights reserved.
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
      dom: 'Bfrtip',
      // lengthChange: false,
      buttons: [{
          extend: "print",
          text: '<i class="fas fa-print mr-1"></i>Print',
          className: "btn btn-success mr-2",
          title: 'Data  Transaksi KP - SPAMS Panguripan ',

        },
        {
          extend: "excel",
          text: '<i class="fas fa-file-excel mr-1"></i> Donwload Excel',
          className: "btn btn-primary mr-2",
          filename: 'data_transaksi',
          title: 'Data  Transaksi KP - SPAMS Panguripan ',
        },
        {
          extend: "pdf",
          text: '<i class="fas fa-file-pdf mr-1"></i> Donwload PDF',
          className: "btn btn-warning mr-2",
          filename: 'data_transaksi',
          title: 'Data  Transaksi KP - SPAMS Panguripan ',
        }
      ],
    });

    var table = $("#myTable2").DataTable({
      lengthChange: false,

    });

    // table.buttons().container().appendTo(".col-md-6:eq(0)");
  });

  //   $(document).ready( function () {
  //     $('#myTable').DataTable();
  // } );


  $(document).ready(function() {
    $(".select-2").select2();
  });
</script>



</body>

</html>