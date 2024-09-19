<?php
// Mulai session
session_start();

// Include koneksi ke database
include("../koneksi.php");

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $email = $_POST['email'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];

    // Validasi sederhana apakah email sudah digunakan
    $sql_check_email = "SELECT * FROM user WHERE email = ?";
    $stmt_check = $koneksi->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Jika email sudah terdaftar, kirim pesan error
        $_SESSION['error'] = "Email sudah digunakan!";
        header("Location: /nganjukvisitnew/register.php");
        exit;
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data ke tabel user
    $sql = "INSERT INTO user (email, nama, role, password, alamat) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sssss", $email, $name, $role, $hashed_password, $alamat);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman login dengan pesan sukses
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: /nganjukvisitnew/register.php");
        exit;
    } else {
        // Jika gagal, redirect dengan pesan error
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi!";
        header("Location: /nganjukvisitnew/register.php");
        exit;
    }
}
