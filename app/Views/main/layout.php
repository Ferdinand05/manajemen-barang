<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Pergudangan</title>

    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('main/index') ?>" class="brand-link">
                <i class="fa fa-warehouse m-3 "></i>
                <span class="brand-text font-weight-bold">Pergudangan</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= session('username') ?></a>
                    </div>
                </div>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- master -->

                        <!-- controller/view Kasir -->
                        <?php if (session('idlevel') == 1) : ?>

                            <li class="nav-item user-panel">
                                <a href="<?= base_url('BarangKeluar/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-truck-loading text-success"></i>
                                    <p class="text">Barang Keluar</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- controller/view Gudang -->
                        <?php if (session('idlevel') == 2) : ?>
                            <li class="nav-header ">Master</li>
                            <li class="nav-item">
                                <a href="<?= base_url('barang'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly text-info"></i>
                                    <p class="text">Barang</p>
                                </a>
                            </li>

                            <li class="nav-item user-panel">
                                <a href="<?= base_url('barangMasuk/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly-flatbed text-success"></i>
                                    <p class="text">Barang Masuk</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- controller/view OWNER -->
                        <?php if (session('idlevel') == 3) : ?>
                            <li class="nav-header ">Master</li>
                            <li class="nav-item">
                                <a href="<?= base_url('kategori'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-tasks text-info"></i>
                                    <p class="text">Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('satuan'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-percent text-info"></i>
                                    <p class="text">Satuan</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('barang'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly text-info"></i>
                                    <p class="text">Barang</p>
                                </a>
                            </li>
                            <li class="nav-header">Transaksi</li>
                            <li class="nav-item">
                                <a href="<?= base_url('barangMasuk/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly-flatbed text-success"></i>
                                    <p class="text">Barang Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('BarangKeluar/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-truck-loading text-success"></i>
                                    <p class="text">Barang Keluar</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('laporan'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-file text-primary"></i>
                                    <p class="text">Laporan</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- controller/view Admin -->
                        <?php if (session('idlevel') == 4) : ?>
                            <li class="nav-header ">Master</li>
                            <li class="nav-item">
                                <a href="<?= base_url('kategori'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-tasks text-info"></i>
                                    <p class="text">Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('satuan'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-percent text-info"></i>
                                    <p class="text">Satuan</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('barang'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly text-info"></i>
                                    <p class="text">Barang</p>
                                </a>
                            </li>
                            <li class="nav-header">Transaksi</li>
                            <li class="nav-item">
                                <a href="<?= base_url('barangMasuk/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-dolly-flatbed text-success"></i>
                                    <p class="text">Barang Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('BarangKeluar/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-truck-loading text-success"></i>
                                    <p class="text">Barang Keluar</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel">
                                <a href="<?= base_url('laporan'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-file text-success"></i>
                                    <p class="text">Laporan</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item mt-3">
                            <a href="<?= base_url('login/logout'); ?>" class="nav-link text-center btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <!-- Content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col">
                            <h1 class="font-weight-bold">
                                <?= esc($title); ?>
                            </h1>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card p-0 m-0">
                    <div class="card-header">
                        <h3 class="card-title ">
                            <?= $subtitle ?>
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-1">
                        <?= esc($content) ?>
                        <?= $this->renderSection('content'); ?>

                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer text-center">
            <p class="m-0">&copy;2023 AdminLTE. <br>Made by <a href="https://github.com/Ferdinand05/manajemen-barang">Ferdinand</a></p>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>
</body>

</html>