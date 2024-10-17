<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect berdasarkan role pengguna
    if ($_SESSION['role'] === 'admin') {
        header("Location: /nganjukvisitnew/admin/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'pengelola') {
        header("Location: /nganjukvisitnew/pengelola/index.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./style/login.css">
    <title>Login Nganjuk Visit</title>
    <style>
        .right-box {
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body class="bg-image">

    <!-- login -->
    <div class="container d-flex justify-content-center p-5 align-items-center min-vh-100">

        <!-- login container -->
        <div class="row border border-black rounded-5 p-2 bg-white shadow box-area">

            <!-- box kiri -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="./img/image_logos.png" class="img-fluid">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Nganjuk Visit</p>
                <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Destinasi wisata paling keren hanya ada di kota Nganjuk</small>
            </div>
            <!-- box kiri end -->

            <!-- box kanan -->
            <div class="col-md-6 right-box">
                <!-- Tombol Kembali -->
                <button class="btn btn-secondary back-button" onclick="window.location.href='index.php';">
                    Kembali
                </button>
                <div class="row align-items-center">
                    <div class="header-text mt-3 mb-2">
                        <h2>Login</h2>
                        <p class="mb-4">Selamat datang di Destinasi wisata Nganjuk</p>
                        
                        <!-- Pesan Sukses Password -->
                        <?php if (isset($_SESSION['sukses_password'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['sukses_password']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['sukses_password']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- error gak iso login -->
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- error status alert -->
                        <?php if (isset($_SESSION['error_status'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error_status']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['error_status']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form action="controllers/proseslogin.php" method="post">
                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Email address" name="email" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" required>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-end">
                            <div class="forgot">
                                <small><a href="lupa_password.php">Lupa Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Masuk</button>
                        </div>
                    </form>
                    <div class="input-group mb-3">
                        <button class="btn btn-lg btn-success w-100 fs-6" onclick="window.location.href='register.php';">Daftar</button>
                    </div>
                </div>
            </div>
            <!-- box kanan end -->
        </div>
        <!-- login container end -->
    </div>
    <!-- login end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>