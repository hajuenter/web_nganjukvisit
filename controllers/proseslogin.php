<?php
session_start();
include("../koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email ada di database
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika email ditemukan, ambil data user
        $row = $result->fetch_assoc();

        // Verifikasi password yang dimasukkan dengan yang ada di database
        if (password_verify($password, $row['password'])) {
            // Cek status akun
            if ($row['status'] == 'inactive') {
                $_SESSION['error_status'] = "Status akun Anda masih non aktif!";
                header("Location: /nganjukvisitnew/login.php");
                exit;
            } else {
                // Jika password benar, simpan informasi pengguna ke session
                $_SESSION['user_id'] = $row['id_user'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $row['role']; // Menyimpan role pengguna (admin/pengelola)

                // Cek role pengguna dan redirect ke halaman sesuai
                if ($row['role'] == 'admin') {
                    header("Location: /nganjukvisitnew/admin/index.php");
                } elseif ($row['role'] == 'pengelola') {
                    header("Location: /nganjukvisitnew/pengelola/index.php");
                } else {
                    $_SESSION['error'] = "Role pengguna tidak valid!";
                    header("Location: /nganjukvisitnew/login.php");
                }
                exit;
            }
        } else {
            // Jika password salah
            $_SESSION['error'] = "Password salah!";
            header("Location: /nganjukvisitnew/login.php");
            exit;
        }
    } else {
        // Jika email tidak ditemukan
        $_SESSION['error'] = "Email tidak ditemukan!";
        header("Location: /nganjukvisitnew/login.php");
        exit;
    }
}
