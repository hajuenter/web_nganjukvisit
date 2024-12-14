<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_detail_tiket'])) {
    $idDetailTiket = $_POST['id_detail_tiket'];

    $query = "DELETE FROM detail_tiket WHERE id_detail_tiket = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idDetailTiket);

    if ($stmt->execute()) {
        $_SESSION['berhasil'] = "Tiket berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus tiket.";
    }

    header("Location: ../pengelola/pengelola_scan_tiket.php");
    exit();
}
