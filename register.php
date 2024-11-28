<?php
session_start();
include("./koneksi.php");
include("./base_url.php");
// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect berdasarkan role pengguna
    if ($_SESSION['role'] === 'admin') {
        header("Location:" . BASE_URL . "/admin/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'pengelola') {
        header("Location:" . BASE_URL . "/pengelola/index.php");
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
    <link rel="icon" href="./public/assets/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./style/register.css">
    <title>Register Nganjuk Visit</title>
</head>

<body class="bg-image">

    <!-- Register Form -->
    <div class="container mt-4 mb-4 d-flex justify-content-center align-items-center min-vh-100">
        <!-- Register container -->
        <div class="row border border-black rounded-5 p-3 bg-white shadow box-area">
            <!-- box kiri -->
            <div class="col-lg-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="./public/assets/image_logos.png" class="img-fluid">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Nganjuk Visit</p>
                <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Destinasi wisata paling keren hanya ada di kota Nganjuk</small>
            </div>
            <!-- box kiri end -->

            <!-- box kanan -->
            <div class="col-lg-6 right-box">
                <!-- Alerts -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <!-- Form -->
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Daftar</h2>
                        <p>Masukkan data sesuai dengan ketentuan</p>
                        <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#ketentuanModal">Baca ketentuan
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                    <form action="controllers/prosesregister.php" method="post">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Role -->
                        <!-- <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select w-100" id="role" name="role" required>
                                <option value="pengelola">Pengelola</option>
                            </select>
                        </div> -->

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-primary" type="button" onclick="passwordDelokOra()">
                                    <i class="fas fa-eye" id="anjayPas"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <!-- NO HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" name="daftar" class="btn btn-primary">Daftar</button>
                        </div>
                        <div class="d-grid mt-3">
                            <button onclick="window.location.href='login.php';" name="hhh" class="btn btn-success">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- box kanan end -->
        </div>
        <!-- Register container end -->

        <div class="modal fade" id="ketentuanModal" tabindex="-1" aria-labelledby="ketentuanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ketentuanModalLabel">Syarat dan Ketentuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">*<small class="text-black">Isi semua kolom</small></p>
                        <p class="text-danger">*<small class="text-black">Pastikan menggunakan email yang aktif</small></p>
                        <p class="text-danger">*<small class="text-black">Email harus menggunakan domain @gmail.com</small></p>
                        <p class="text-danger">*<small class="text-black">Password harus mengandung huruf dan angka</small></p>
                        <p class="text-danger">*<small class="text-black">Password harus memiliki panjang antara 8 hingga 50 karakter</small></p>
                        <p class="text-danger">*<small class="text-black">Nama harus memiliki panjang antara 4 hingga 50 karakter</small></p>
                        <p class="text-danger">*<small class="text-black">Nomor HP harus terdiri dari 10 hingga 15 digit angka</small></p>
                        <p class="text-danger">*<small class="text-black">Nomor HP harus menggunakan format +62 sebagai ganti angka 0</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Ketentuan end -->
    </div>
    <!-- Register end -->

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('no_hp').addEventListener('input', function() {
            let input = this.value;

            // Hapus angka 0 di depan jika ada
            if (input.startsWith('0')) {
                input = input.substring(1);
            }

            // Periksa apakah sudah ada kode negara '62'
            if (!input.startsWith('62')) {
                this.value = '62' + input;
            }
        });
    </script>

    <script>
        function passwordDelokOra() {
            const pasInput = document.getElementById("password");
            const btnShowHide = document.getElementById("anjayPas");

            if (pasInput.type === "password") {
                pasInput.type = "text";
                btnShowHide.classList.remove("fa-eye");
                btnShowHide.classList.add("fa-eye-slash");
            } else {
                pasInput.type = "password";
                btnShowHide.classList.remove("fa-eye-slash");
                btnShowHide.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>