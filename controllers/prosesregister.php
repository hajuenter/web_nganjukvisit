<?php
session_start();
include("../koneksi.php");
include("../base_url.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];  // Ambil data no_hp dari form

    // Tetapkan role otomatis sebagai 'pengelola'
    $role = 'pengelola';

    // Validasi email harus menggunakan @gmail.com
    if (!preg_match('/@gmail\.com$/', $email)) {
        $_SESSION['error'] = "Email harus menggunakan domain @gmail.com.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Validasi panjang name
    if (strlen($name) < 4 || strlen($name) > 50) {
        $_SESSION['error'] = "Nama harus memiliki antara 4 hingga 50 karakter.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Validasi panjang password
    if (strlen($password) > 50) {
        $_SESSION['error'] = "Password tidak boleh lebih dari 50 karakter.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Validasi format nomor HP (minimal 10 digit dan hanya angka)
    if (!preg_match('/^[0-9]{10,15}$/', $no_hp)) {
        $_SESSION['error'] = "Nomor HP harus terdiri dari 10 hingga 15 digit angka.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Validasi pola password (kombinasi huruf dan angka)
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,50}$/', $password)) {
        $_SESSION['error'] = "Password harus mengandung huruf, angka, dan panjang antara 8 hingga 50 karakter.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Validasi apakah email sudah digunakan
    $sql_check_email = "SELECT * FROM user WHERE email = ?";
    $stmt_check = $koneksi->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan!";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Set status sebagai inactive untuk pengelola
    $status = 'inactive';

    // Query untuk menyimpan data ke tabel user
    $sql = "INSERT INTO user (email, nama, role, password, alamat, no_hp, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sssssss", $email, $name, $role, $hashed_password, $alamat, $no_hp, $status);

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan tunggu konfirmasi dan login.";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi!";
        header("Location:" . BASE_URL . "/register.php");
        exit;
    }
}
