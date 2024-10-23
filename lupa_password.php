<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect berdasarkan role pengguna
    if ($_SESSION['role'] === 'admin') {
        header("Location: /nganjukvisit/admin/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'pengelola') {
        header("Location: /nganjukvisit/pengelola/index.php");
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
</head>

<body class="bg-image">

    <!-- login -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!-- login container -->
        <div class="row border border-black rounded-5 p-3 bg-white shadow box-area">

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
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Lupa Password</h2>
                        <p>Masukkan data dan lengkapi dengan benar</p>
                        <?php if (isset($_SESSION['gagal'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['gagal']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['gagal']); // Hapus pesan setelah ditampilkan 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form action="./controllers/cek_email_kirim_OTP.php" method="post">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email" required>
                        </div>
                        <div class="input-group mb-2 mt-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Cek Email</button>
                        </div>
                        <div class="input-group">
                            <button class="btn btn-lg btn-success w-100 fs-6" onclick="window.location.href='login.php';">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- box kanan end -->
        </div>
        <!-- login container end -->
    </div>
    <!-- login end -->


    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>