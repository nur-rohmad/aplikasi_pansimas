<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light ">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" id="side_bar" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item pt-2 mr-lg-3">
      <span class="mr-3 text-bold"><?= format_tanggal_indo_hari(date("Y-m-d")) ?></span>
    </li>

  </ul>
</nav>
<style>
  .logout {
    border-radius: 20px;
    margin-right: 2em;
  }
</style>
<!-- /.navbar -->

</script>