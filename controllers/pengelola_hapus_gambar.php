<?php
session_start();
include("../koneksi.php");
include("../base_url.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wisata = $_POST['id_wisata'];
    $gambar = trim($_POST['gambar']); // Pastikan untuk trim gambar yang ingin dihapus

    // Validasi input
    if (!empty($id_wisata) && !empty($gambar)) {
        // Hapus gambar dari folder public/gambar
        $gambar_path = "../public/gambar/" . $gambar; // Gambar yang ingin dihapus
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
            $gambar_baru = array_diff($gambar_array, [$gambar]); // Hapus gambar yang ingin dihapus
            $gambar_baru_string = implode(',', $gambar_baru);

            // Trim untuk memastikan tidak ada koma di awal dan akhir
            $gambar_baru_string = trim($gambar_baru_string, ',');

            // Update database hanya jika $gambar_baru_string tidak kosong
            if ($gambar_baru_string === '') {
                $gambar_baru_string = NULL; // Jika tidak ada gambar tersisa, set ke NULL
            }

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
header("Location:" . BASE_URL . "/pengelola/index.php");
exit();
