<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Logika untuk mengaktifkan pengguna
    $sql = "UPDATE user SET status = 'active' WHERE id_user = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_konfir'] = "Pengguna berhasil diaktifkan!";
    } else {
        $_SESSION['error_konfir'] = "Gagal mengupdate status.";
    }

    // Redirect kembali setelah memproses
    header("Location:" . BASE_URL . "/admin/admin_pengelola.php"); // Ganti dengan URL halaman yang sesuai
    exit;
}
