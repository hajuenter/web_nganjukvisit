<?php
session_start();
include("../koneksi.php");
require_once '../base_url.php';

if (isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    // Query untuk menghapus data pengelola berdasarkan id_user
    $query = "DELETE FROM user WHERE id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        $_SESSION['success_konfir'] = "Pengelola berhasil dihapus.";
    } else {
        $_SESSION['error_konfir'] = "Terjadi kesalahan saat menghapus pengelola.";
    }

    $stmt->close();
    $koneksi->close();

    // Redirect kembali ke halaman sebelumnya
    header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
    exit();
} else {
    $_SESSION['error_konfir'] = "ID pengguna tidak ditemukan.";
    header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
    exit();
}
