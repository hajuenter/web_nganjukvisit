<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengelola = $_POST['id_pengelola'];
    $id_wisata = $_POST['wisata'];

    // Ambil no_hp dari tabel user berdasarkan id_pengelola
    $query_no_hp = "SELECT no_hp FROM user WHERE id_user = '$id_pengelola'";
    $result = mysqli_query($conn, $query_no_hp);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $no_hp = $row['no_hp'];

        // Update ket_wisata di tabel user
        $query_user = "UPDATE user SET ket_wisata = '$id_wisata' WHERE id_user = '$id_pengelola'";
        if (mysqli_query($conn, $query_user)) {
            // Update id_pengelola dan no_hp_pengelola di tabel detail_wisata
            $query_wisata = "UPDATE detail_wisata SET id_pengelola = '$id_pengelola', no_hp_pengelola = '$no_hp' WHERE id_wisata = '$id_wisata'";
            if (mysqli_query($conn, $query_wisata)) {
                $_SESSION['success_konfir'] = 'Wisata berhasil diset untuk pengelola.';
            } else {
                $_SESSION['error_konfir'] = 'Gagal mengupdate pengelola dan no HP pada tabel detail_wisata.';
            }
        } else {
            $_SESSION['error_konfir'] = 'Gagal mengupdate wisata.';
        }
    } else {
        $_SESSION['error_konfir'] = 'Pengelola tidak ditemukan atau tidak memiliki nomor HP.';
    }

    header('Location: ../admin/admin_pengelola.php');
    exit();
}
