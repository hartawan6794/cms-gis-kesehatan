<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('hospital.png') ?>">
    <title>Login Form</title>

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>
    <?= csrf_meta() ?>

    <!-- Google Font: Thai Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('asset/css/adminlte.min.css') ?>">
    <!--<link rel="stylesheet" href="<?php /* echo base_url('asset/css/rtl/adminlte.rtl.min.css') */ ?>"> -->

    <!-- SweetAlert2 Bootstrap or Dark -->
    <link rel="stylesheet" href="<?= base_url('asset/css/sweetalert2-dark.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('asset/plugins/datatables/Responsive-2.2.9/css/responsive.bootstrap5.min.css'); ?>">

    <!-- <link rel="stylesheet" href="<?= base_url('asset/plugins/datatables/StateRestore-1.1.1/css/stateRestore.bootstrap5.min.css') ?>"> -->

    <!-- SweetAlert2 Bootstrap or Dark -->
    <link rel="stylesheet" href="<?= base_url('asset/css/sweetalert2-dark.min.css') ?>">
</head>

<body>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">

                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h1 class="text-center">Form Login GIS Kesehatan</h1>

                    <img src="<?= base_url('/img/login.png') ?>" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form>
                        <!-- Email input -->
                        <div class="form-group mb-4">
                            <label for="email" class="col-form-label">Email / Username</label>
                            <input type="text" id="email" class="form-control form-control-lg" placeholder="Masukan email atau username" />
                        </div>

                        <!-- Password input -->
                        <div class="form-group mb-4">
                            <label class="col-form-label" for="passwrd">Password</label>
                            <input type="password" id="password" class="form-control form-control-lg" placeholder="Enter password" />
                        </div>


                        <!-- <div class="d-flex justify-content-around align-items-center mb-4">
                           
                        </div> -->

                        <!-- Submit button -->
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-login">Login</button>
                        <!-- 
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
                        </div>

                        <a class="btn btn-primary btn-lg btn-block" style="background-color: #3b5998" href="#!" role="button">
                            <i class="fab fa-facebook-f me-2"></i>Continue with Facebook
                        </a>
                        <a class="btn btn-primary btn-lg btn-block" style="background-color: #55acee" href="#!" role="button">
                            <i class="fab fa-twitter me-2"></i>Continue with Twitter</a> -->

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url() ?>/asset/js/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('asset/js/sweetalert2.all.min.js') ?>"></script>

    <script>
        $("#email, #password").keydown(function(event) {
            var email = $('#email').val();
            var pass = $('#password').val();
            if (event.which == 13) { // Tombol "Enter" memiliki kode 13
                event.preventDefault(); // Mencegah pengiriman formulir
                login(email, pass);
            }
        });
        $('#btn-login').click(function() {
            // event.preventDefault();
            var email = $('#email').val();
            var pass = $('#password').val();

            // console.log(email)

            login(email, pass);
        })

        function login(email, pass) {
            $.ajax({
                // fixBug get url from global function only
                // get global variable is bug!
                url: '<?= base_url($controller . "/login") ?>',
                type: 'post',
                data: {
                    email: email,
                    password: pass,
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Selamat',
                            text: 'Login berhasil'
                        }).then((result) => {
                            if (result.value) {
                                window.location = "<?= site_url('/home') ?>"
                            }
                        })
                    } else {
                        Swal.fire({
                            toast: false,
                            position: 'bottom-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                }

            })
        }
    </script>

</body>

</html>