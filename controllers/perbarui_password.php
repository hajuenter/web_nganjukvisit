<?php
session_start();
include('../koneksi.php');
include("../base_url.php");
$conn = $koneksi;

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location:" . BASE_URL . "/login.php");
    exit();
}

// Cek apakah form telah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id']; // Ambil ID user dari session
    $password_baru = $_POST['password'];
    $konfir_password = $_POST['konfir_password'];

    // Validasi input
    if (empty($password_baru) || empty($konfir_password)) {
        $_SESSION['error'] = "Semua kolom wajib diisi.";
        header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
        exit();
    }

    // Validasi panjang password
    if (strlen($password_baru) > 50) {
        $_SESSION['error'] = "Password tidak boleh lebih dari 50 karakter.";
        header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
        exit();
    }

    // Validasi pola password (kombinasi huruf dan angka)
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,50}$/', $password_baru)) {
    $_SESSION['error'] = "Password harus mengandung huruf, angka, karakter unik, dan panjang antara 8 hingga 50 karakter.";
    header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
    exit;
    }


    // Cek apakah password baru dan konfirmasi password cocok
    if ($password_baru !== $konfir_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
        header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
        exit();
    }

    // Hash password baru
    $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);

    // Update password di database
    $sql = "UPDATE user SET password = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $hashed_password, $id_user);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Password berhasil diperbarui.";
        header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat memperbarui password.";
        header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Jika pengguna mencoba mengakses file ini tanpa submit form
    $_SESSION['error'] = "Akses tidak valid.";
    header("Location:" . BASE_URL . "/admin/admin_ganti_password.php");
    exit();
}
