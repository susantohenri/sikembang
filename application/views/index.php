<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>SiKembang</title>
  <link href="<?= base_url('manifest-'. ENVIRONMENT .'.json') ?>" rel="manifest">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/css/all.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    a.btn:not([href]):not([tabindex]) {
      color: white
    }

    .form-child .form-group.row>div {
      margin: 5px 0
    }
    #offline_sync_modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
  <?php if (isset($css)) : foreach ($css as $style) : ?>
      <link rel="stylesheet" href="<?= base_url("assets/css/{$style}") ?>">
  <?php endforeach;
  endif; ?>
</head>

<body class="hold-transition layout-top-nav">
  <!-- add modal to block page -->
  <div id="offline_sync_modal" class="d-none">Loading...</div>
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-white">
      <div class="container">
        <a href="<?= base_url() ?>" class="navbar-brand">
          <img src="<?= base_url('logo-sikembang.jpeg') ?>" alt="SiKembang Logo" class="brand-image" style="opacity: .8; height: 60px; max-height:60px">
        </a>
        <div class="btn-group">
          <?php if (0 < $warning_signs && in_array('index_Warning', $permission)) : ?>
            <a class="btn btn-default" href="<?= site_url('Warning') ?>"><i class="fas fa-bell text-danger"></i></a>
          <?php endif ?>
          <a href="<?= site_url('Login/Logout') ?>" class="btn btn-warning">Logout</a>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?= $page_title ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>" style="color: #ffab00">Beranda</a></li>
                <?php if (in_array($page_name, array('table', 'dashboard'))) : ?>
                  <li class="breadcrumb-item active"><?= $page_title ?></li>
                <?php else : ?>
                  <li class="breadcrumb-item"><a href="<?= site_url($current['controller']) ?>" style="color: #ffab00"><?= $page_title ?></a></li>
                  <li class="breadcrumb-item active"><?= ucfirst(str_replace('_', ' ', $page_name)) ?></li>
                <?php endif ?>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container">
          <div class="row">
            <?php include "{$page_name}.php" ?>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        henry.dinus@gmail.com 081901088918
      </div>
      <!-- Default to the left -->
      <small><strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.</small>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script type="text/javascript">
    (function() {
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= base_url('service-worker-'. ENVIRONMENT .'.js') ?>')
      }
    })()
  </script>
  <script type="text/javascript">
    var site_url = '<?= site_url('/') ?>'
    var current_controller = '<?= $current['controller'] ?>'
    var current_controller_url = '<?= site_url($current['controller']) ?>'
  </script>
  <?php if (isset($js)) : foreach ($js as $script) : ?>
      <script type="text/javascript" src="<?= base_url("assets/js/{$script}") ?>"></script>
  <?php endforeach;
  endif; ?>
  <script src="<?= base_url('assets/js/offline.js') ?>"></script>
</body>

</html>