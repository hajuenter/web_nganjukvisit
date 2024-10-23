<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tiket = $_POST['id_tiket'];

    // Hapus tiket
    $queryDelete = "DELETE FROM tiket_wisata WHERE id_tiket = ?";
    $stmtDelete = $conn->prepare($queryDelete);
    $stmtDelete->bind_param("s", $id_tiket);

    if ($stmtDelete->execute()) {
        $_SESSION['bagus'] = "Tiket berhasil di hapus!";
        header('Location: ../admin/admin_boking_tiket.php');
    } else {
        $_SESSION['gagal'] = "Tiket gagal di hapus!";
        header('Location: ../admin/admin_boking_tiket.php');
    }

    exit();
}
