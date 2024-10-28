<?php
// Mulai session untuk menampilkan pesan
session_start();
include("../koneksi.php"); // Pastikan Anda sudah menghubungkan ke database
include("../base_url.php");

// Cek apakah id_user ada dalam POST
if (isset($_POST['id_user'])) {
    // Ambil ID pengguna dari POST
    $id_user = $_POST['id_user'];

    // Query untuk mendapatkan nama file gambar sebelum menghapus pengguna
    $queryGambar = "SELECT gambar FROM user WHERE id_user = ?";
    if ($stmtGambar = mysqli_prepare($koneksi, $queryGambar)) {
        mysqli_stmt_bind_param($stmtGambar, "i", $id_user);
        mysqli_stmt_execute($stmtGambar);
        mysqli_stmt_bind_result($stmtGambar, $gambar);
        mysqli_stmt_fetch($stmtGambar);
        mysqli_stmt_close($stmtGambar);

        // Cek apakah file gambar ada dan hapus file dari direktori
        if ($gambar && file_exists("../public/gambar/" . $gambar)) {
            unlink("../public/gambar/" . $gambar); // Hapus file gambar dari folder
        }
    } else {
        $_SESSION['error_konfir'] = "Gagal mengambil gambar pengguna.";
        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
        exit();
    }

    // Query untuk mengupdate detail_wisata dan mengatur id_pengelola dan no_hp_pengelola menjadi NULL
    $updateWisataQuery = "UPDATE detail_wisata SET id_pengelola = NULL, no_hp_pengelola = NULL WHERE id_pengelola = ?";
    if ($stmtUpdate = mysqli_prepare($koneksi, $updateWisataQuery)) {
        mysqli_stmt_bind_param($stmtUpdate, "i", $id_user);

        // Eksekusi query
        mysqli_stmt_execute($stmtUpdate);
        mysqli_stmt_close($stmtUpdate);
    } else {
        $_SESSION['error_konfir'] = "Gagal memperbarui detail wisata.";
        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
        exit();
    }

    // Buat query untuk menghapus pengelola berdasarkan ID
    $hapusQuery = "DELETE FROM user WHERE id_user = ?";
    if ($stmt = mysqli_prepare($koneksi, $hapusQuery)) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, "i", $id_user);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, set pesan sukses
            $_SESSION['success_konfir'] = "Pengelola berhasil dihapus.";
        } else {
            // Jika gagal, set pesan error
            $_SESSION['error_konfir'] = "Terjadi kesalahan saat menghapus pengelola.";
        }
        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika statement gagal disiapkan
        $_SESSION['error_konfir'] = "Terjadi kesalahan dalam penghapusan data.";
    }
} else {
    // Jika ID tidak diberikan
    $_SESSION['error_konfir'] = "ID pengelola tidak ditemukan.";
}

// Redirect kembali ke halaman admin_pengelola.php
header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
exit();

// Tutup koneksi
mysqli_close($koneksi);
