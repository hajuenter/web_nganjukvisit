<?php
session_start();
include("../koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wisata = $_POST['id_wisata'];
    $gambar = $_POST['gambar'];

    // Validasi input
    if (!empty($id_wisata) && !empty($gambar)) {
        // Hapus gambar dari folder public/gambar
        $gambar_path = "../public/gambar/" . trim($gambar);
        if (file_exists($gambar_path)) {
            unlink($gambar_path); // Hapus file dari folder
        }

        // Ambil data gambar saat ini
        $query_get_gambar = "SELECT gambar FROM detail_wisata WHERE id_wisata = ?";
        $stmt_get_gambar = $koneksi->prepare($query_get_gambar);
        $stmt_get_gambar->bind_param("i", $id_wisata);
        $stmt_get_gambar->execute();
        $result_gambar = $stmt_get_gambar->get_result();

        if ($result_gambar->num_rows > 0) {
            $row_gambar = $result_gambar->fetch_assoc();
            $gambar_sekarang = $row_gambar['gambar'];
            $gambar_array = explode(',', $gambar_sekarang);

            // Hapus gambar dari array
            $gambar_baru = array_diff($gambar_array, [$gambar]);
            $gambar_baru_string = implode(',', $gambar_baru);

            // Update database
            $query_update_gambar = "UPDATE detail_wisata SET gambar = ? WHERE id_wisata = ?";
            $stmt_update_gambar = $koneksi->prepare($query_update_gambar);
            $stmt_update_gambar->bind_param("si", $gambar_baru_string, $id_wisata);

            if ($stmt_update_gambar->execute()) {
                $_SESSION['berhasil'] = "Gambar berhasil dihapus!";
            } else {
                $_SESSION['gagal'] = "Terjadi kesalahan saat menghapus gambar dari database.";
            }
        }
    } else {
        $_SESSION['gagal'] = "Gambar atau wisata tidak valid.";
    }
} else {
    $_SESSION['gagal'] = "Metode pengiriman tidak valid.";
}

// Redirect kembali ke halaman sebelumnya
header("Location: ../pengelola/index.php");
exit();
