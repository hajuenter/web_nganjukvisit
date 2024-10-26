<?php
session_start();
include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'] ?? '';

    if ($id_transaksi) {
        // SQL untuk menghapus data berdasarkan id_transaksi
        $sql = "DELETE FROM riwayat_transaksi_tiket_wisata WHERE id_transaksi = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('s', $id_transaksi);

        if ($stmt->execute()) {
            $_SESSION['win'] = "Riwsayat berhasil di hapus!";
            header('Location: ../admin/admin_laporan_tiket.php'); // Redirect ke halaman awal dengan status success
            exit();
        } else {
            $_SESSION['lose'] = "Riwsayat gagal di hapus!";
            header('Location: ../admin/admin_laporan_tiket.php'); // Redirect ke halaman awal dengan status error
            exit();
        }
    } else {
        $_SESSION['lose'] = "Error ya!";
        header('Location: ../admin/admin_laporan_tiket.php'); // Redirect ke halaman awal jika ID tidak valid
        exit();
    }
} else {
    $_SESSION['lose'] = "Error fatal ya!";
    header('Location: ../admin/admin_laporan_tiket.php'); // Redirect jika bukan metode POST
    exit();
}