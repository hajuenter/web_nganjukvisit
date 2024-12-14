<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
include("../config/encryption_helper.php");
include("../config/key.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dan validasi
    $id_pengelola = mysqli_real_escape_string($conn, $_POST['id_pengelola']);
    $id_wisata_baru = mysqli_real_escape_string($conn, $_POST['wisata']);

    // Cek apakah pengelola valid dan memiliki nomor HP
    $query_no_hp = "SELECT no_hp, ket_wisata FROM user WHERE id_user = '$id_pengelola'";
    $result_no_hp = mysqli_query($conn, $query_no_hp);

    if ($result_no_hp && mysqli_num_rows($result_no_hp) > 0) {
        $row_no_hp = mysqli_fetch_assoc($result_no_hp);
        $no_hp = $row_no_hp['no_hp'];
        $wisata_lama = $row_no_hp['ket_wisata'];

        // Update wisata lama, jika ada
        if ($wisata_lama) {
            $query_update_lama = "UPDATE detail_wisata SET id_pengelola = NULL, no_hp_pengelola = NULL WHERE id_wisata = '$wisata_lama'";
            mysqli_query($conn, $query_update_lama);
        }

        // Update wisata baru di tabel `user` dan `detail_wisata`
        $query_user = "UPDATE user SET ket_wisata = '$id_wisata_baru' WHERE id_user = '$id_pengelola'";
        $query_wisata_baru = "UPDATE detail_wisata SET id_pengelola = '$id_pengelola', no_hp_pengelola = '$no_hp' WHERE id_wisata = '$id_wisata_baru'";

        if (mysqli_query($conn, $query_user) && mysqli_query($conn, $query_wisata_baru)) {
            $_SESSION['success_konfir'] = 'Wisata berhasil diset untuk pengelola.';
        } else {
            $_SESSION['error_konfir'] = 'Gagal mengupdate data wisata baru.';
        }
    } else {
        $_SESSION['error_konfir'] = 'Pengelola tidak ditemukan atau tidak memiliki nomor HP.';
    }

    // Redirect kembali ke halaman admin
    header("Location: " . BASE_URL . "/admin/admin_pengelola.php");
    exit();
}
