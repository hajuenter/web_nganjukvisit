<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengelola = $_POST['id_pengelola'];
    $id_wisata = $_POST['wisata'];

    // Update ket_wisata di tabel user
    $query_user = "UPDATE user SET ket_wisata = '$id_wisata' WHERE id_user = '$id_pengelola'";
    if (mysqli_query($conn, $query_user)) {
        // Update id_pengelola di tabel detail_wisata
        $query_wisata = "UPDATE detail_wisata SET id_pengelola = '$id_pengelola' WHERE id_wisata = '$id_wisata'";
        if (mysqli_query($conn, $query_wisata)) {
            $_SESSION['success_konfir'] = 'Wisata berhasil diset untuk pengelola.';
        } else {
            $_SESSION['error_konfir'] = 'Gagal mengupdate pengelola pada tabel detail_wisata.';
        }
    } else {
        $_SESSION['error_konfir'] = 'Gagal mengupdate wisata.';
    }

    header('Location: ../admin/admin_pengelola.php');
    exit();
}
