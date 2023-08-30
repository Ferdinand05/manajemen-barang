<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Login</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan Login Untuk menggunakan Sistem</p>

                <?= form_open('login/cekUser') ?>
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" id="username" name="username" class="form-control <?= session()->has('errUsername') ? ' is-invalid' : '' ?>" placeholder="Username" value="">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback small">
                        <?= session('errUsername'); ?>
                    </div>
                </div>
                <div class="input-group mb-3">

                    <input type="password" class="form-control <?= session()->has('errPassword') ? ' is-invalid' : '' ?>" placeholder="Password" id="password" name="password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span id="passwordIcon" class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <?= session('errPassword'); ?>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-primary btn-block" title="Masuk">
                        <i class="fas fa-sign-in-alt"></i>
                    </button>
                </div>
                <?= form_close() ?>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
        <script>
            $(document).ready(function() {


                function cekType() {
                    let inputType = $('#password').attr('type');
                    if ($('#passwordIcon').hasClass('fa-eye-slash') && inputType == 'password') {
                        $('#password').attr('type', 'text');
                        $('#passwordIcon').removeClass('fa-eye');
                    } else if ($('#passwordIcon').hasClass('fa-eye') && inputType == 'text') {
                        $('#password').attr('type', 'password');
                        $('#passwordIcon').removeClass('fa-eye-slash');
                    } else {
                        $('#passwordIcon').removeClass('fa-eye-slash');
                        $('#password').attr('text', 'password');
                    }
                }



                function iconClick() {
                    $('#passwordIcon').removeClass('fa-lock');
                    $('#passwordIcon').addClass('fa-eye');

                    $('#passwordIcon').click(function(e) {
                        $('#passwordIcon').toggleClass('fa-eye');
                        $('#passwordIcon').toggleClass('fa-eye-slash');
                        cekType();
                    });
                }

                $('#password').click(function(e) {
                    iconClick();
                });

            });
        </script>
</body>

</html>