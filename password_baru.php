<?php
session_start();
include("koneksi.php");

$conn = $koneksi;

// Cek jika form dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        $email = $_SESSION['email'] ?? ''; // Ambil email dari session

        // Validasi panjang password
        if (strlen($new_password) > 50) {
            $_SESSION['error_password'] = "Password tidak boleh lebih dari 50 karakter.";
            header("Location: /nganjukvisit/lupa_password.php"); // Sesuaikan URL redirect jika perlu
            exit();
        }

        // Validasi pola password (kombinasi huruf dan angka)
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,50}$/', $new_password)) {
            $_SESSION['error_password'] = "Password harus mengandung huruf, angka, dan panjang antara 8 hingga 50 karakter.";
            header("Location: /nganjukvisit/lupa_password.php"); // Sesuaikan URL redirect jika perlu
            exit();
        }

        if ($email) {
            // Enkripsi password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password di database
            $sql = "UPDATE user SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $email);

            if ($stmt->execute()) {
                $_SESSION['sukses_password'] = 'Password berhasil diperbarui, silahkan login kembali.';
                unset($_SESSION['email']); // Hapus email dari session
                unset($_SESSION['berhasil']);
                header("Location: /nganjukvisit/login.php"); // Redirect ke halaman login
                exit();
            } else {
                $_SESSION['error_password'] = 'Terjadi kesalahan saat memperbarui password. Silakan coba lagi.';
            }
        } else {
            $_SESSION['error_password'] = 'Email tidak ditemukan dalam session.';
        }
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
    <title>Reset Password Nganjuk Visit</title>
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
                        <p>Masukkan Password Baru</p>
                        <?php if (isset($_SESSION['sukses_password'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['sukses_password']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['sukses_password']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error_password'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error_password']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['error_password']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="password" name="new_password" class="form-control form-control-lg bg-light fs-6" placeholder="Password Baru" required>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Perbarui</button>
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