<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengelola = $_POST['id_pengelola'];
    $id_wisata_baru = $_POST['wisata'];

    // Ambil no_hp dari tabel user berdasarkan id_pengelola
    $query_no_hp = "SELECT no_hp FROM user WHERE id_user = '$id_pengelola'";
    $result_no_hp = mysqli_query($conn, $query_no_hp);

    if ($result_no_hp && mysqli_num_rows($result_no_hp) > 0) {
        $row_no_hp = mysqli_fetch_assoc($result_no_hp);
        $no_hp = $row_no_hp['no_hp'];

        // Ambil id_wisata yang sudah dikelola pengelola sebelumnya
        $query_wisata_lama = "SELECT ket_wisata FROM user WHERE id_user = '$id_pengelola'";
        $result_wisata_lama = mysqli_query($conn, $query_wisata_lama);
        $wisata_lama = mysqli_fetch_assoc($result_wisata_lama)['ket_wisata'];

        // Update wisata lama dengan mengatur id_pengelola dan no_hp_pengelola menjadi NULL
        if ($wisata_lama) {
            $query_update_lama = "UPDATE detail_wisata SET id_pengelola = NULL, no_hp_pengelola = NULL WHERE id_wisata = '$wisata_lama'";
            mysqli_query($conn, $query_update_lama);
        }

        // Update ket_wisata di tabel user
        $query_user = "UPDATE user SET ket_wisata = '$id_wisata_baru' WHERE id_user = '$id_pengelola'";
        if (mysqli_query($conn, $query_user)) {
            // Update id_pengelola dan no_hp_pengelola di tabel detail_wisata untuk wisata baru
            $query_wisata_baru = "UPDATE detail_wisata SET id_pengelola = '$id_pengelola', no_hp_pengelola = '$no_hp' WHERE id_wisata = '$id_wisata_baru'";
            if (mysqli_query($conn, $query_wisata_baru)) {
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
