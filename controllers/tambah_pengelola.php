<?php
session_start();
// Include file koneksi database
include("../koneksi.php");

$conn = $koneksi;

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Enkripsi password (gunakan password_hash untuk keamanan)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menambahkan pengelola ke tabel user
    $query = "INSERT INTO user (email, nama, password, alamat, role, status) VALUES (?, ?, ?, ?, 'pengelola', 'active')";

    // Persiapan statement
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameter ke query
        mysqli_stmt_bind_param($stmt, 'ssss', $email, $nama, $hashedPassword, $alamat);

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke halaman sebelumnya dengan pesan sukses
            $_SESSION['success_konfir'] = "Pengelola berhasil ditambahkan.";
            header("Location: ../admin/admin_pengelola.php");
            exit();
        } else {
            // Jika terjadi error pada query
            $_SESSION['error_konfir'] = "Gagal menambahkan pengelola. Silakan coba lagi.";
            header("Location: ../admin/admin_pengelola.php");
            exit();
        }
    } else {
        // Jika terjadi error pada persiapan query
        $_SESSION['error_konfir'] = "Terjadi kesalahan pada server. Silakan coba lagi.";
        header("Location: ../admin/admin_pengelola.php");
        exit();
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
}

// Tutup koneksi
mysqli_close($conn);
