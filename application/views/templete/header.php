<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url('resource/adminlte31/') ?>/img/pansimas.jpeg ">
  <title>KP - SPAMS Panguripan - <?php echo $this->uri->segment(2) == '' ?  ucwords($this->uri->segment(1)) :  ucwords($this->uri->segment(2)) ?> </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="<?= base_url(''); ?>https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>css/adminlte.min.css">

  <!-- load style select 2 -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- data tabel -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/datatables-buttons/css/buttons.bootstrap4.css">

  <!-- bs stepper -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/bs-stepper/css/bs-stepper.min.css">
  <?php
  if ($this->uri->segment(2) == "tagihan") { ?>
    <!-- midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-BGZEaZ4uqOSXDwvu"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <?php } ?>
  <!-- swet alert -->
  <link rel="stylesheet" href="<?= base_url('resource/adminlte31/'); ?>plugins/sweetalert2/sweetalert2.min.css">
  <script src="<?= base_url('resource/adminlte31/'); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- toasr -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">