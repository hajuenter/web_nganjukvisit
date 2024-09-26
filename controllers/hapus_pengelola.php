<?php
include("../koneksi.php"); // Pastikan Anda sudah menghubungkan ke database

// Cek apakah id_user ada dalam POST
if (isset($_POST['id_user'])) {
    // Ambil ID pengguna dari POST
    $id_user = $_POST['id_user'];

    // Buat query untuk menghapus pengelola berdasarkan ID
    $hapusQuery = "DELETE FROM user WHERE id_user = ?";

    // Siapkan statement
    if ($stmt = mysqli_prepare($koneksi, $hapusQuery)) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, "i", $id_user);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, set pesan sukses
            session_start();
            $_SESSION['success_konfir'] = "Pengelola berhasil dihapus.";
        } else {
            // Jika gagal, set pesan error
            session_start();
            $_SESSION['error_konfir'] = "Terjadi kesalahan saat menghapus pengelola.";
        }
        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika statement gagal disiapkan
        session_start();
        $_SESSION['error_konfir'] = "Terjadi kesalahan dalam penghapusan data.";
    }
} else {
    // Jika ID tidak diberikan
    session_start();
    $_SESSION['error_konfir'] = "ID pengelola tidak ditemukan.";
}

// Redirect kembali ke halaman admin_pengelola.php
header("Location: ../admin/admin_pengelola.php");
exit();

// Tutup koneksi
mysqli_close($koneksi);
