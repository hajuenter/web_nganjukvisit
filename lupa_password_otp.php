<?php
session_start();
include("koneksi.php");
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

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_otp = $_POST['kode_otp'];
    $email = $_SESSION['email'] ?? ''; // Pastikan email diambil dari session jika tersedia

    if (!$email) {
        $_SESSION['gagal'] = 'Session email tidak ditemukan. Silakan coba lagi.';
        header('Location: lupa_password.php');
        exit();
    }

    // Ambil OTP dan waktu kedaluwarsa dari database
    $sql = "SELECT kode_otp, expired_otp FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $stored_otp = $user['kode_otp'];
        $expired_otp = $user['expired_otp'];

        if ($input_otp === $stored_otp && strtotime($expired_otp) > time()) {
            $_SESSION['berhasil'] = 'Kode OTP valid. Anda dapat melanjutkan ke proses selanjutnya.';
            unset($_SESSION['gagal']);
            header("Location:" . BASE_URL . "/password_baru.php");
            exit();
        } else {
            $_SESSION['gagal'] = 'Kode OTP tidak valid atau sudah kedaluwarsa.';
            unset($_SESSION['berhasil']);
        }
    } else {
        $_SESSION['gagal'] = 'Email tidak ditemukan.';
        unset($_SESSION['berhasil']);
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
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./style/login.css">
    <title>Nganjuk Visit</title>
</head>

<body class="bg-image">
    <!-- login -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- login container -->
        <div class="row border border-black rounded-5 p-3 bg-white shadow box-area">
            <!-- box kiri -->
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="./public/assets/image_logos.png" class="img-fluid">
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
                        <p>Masukkan Kode OTP</p>
                        <?php if (isset($_SESSION['berhasil'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['berhasil']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['berhasil']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['gagal'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['gagal']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <?php unset($_SESSION['gagal']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="kode_otp" class="form-control form-control-lg bg-light fs-6" placeholder="Kode OTP" required>
                        </div>
                        <div class="input-group mb-3 mt-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Konfirmasi</button>
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