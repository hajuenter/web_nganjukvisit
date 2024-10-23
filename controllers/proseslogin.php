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
                header("Location: /nganjukvisit/login.php");
                exit;
            } else {
                // Cek jika yang login adalah pengelola dan ket_wisata-nya kosong atau null
                if ($row['role'] == 'pengelola' && (is_null($row['ket_wisata']) || $row['ket_wisata'] == '')) {
                    $_SESSION['error'] = "Akun pengelola Anda belum memiliki wisata yang terdaftar!";
                    header("Location: /nganjukvisit/login.php");
                    exit;
                }

                // Jika password benar dan role valid, simpan informasi pengguna ke session
                $_SESSION['user_id'] = $row['id_user'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $row['role']; // Menyimpan role pengguna (admin/pengelola)

                // Cek role pengguna dan redirect ke halaman sesuai
                if ($row['role'] == 'admin') {
                    header("Location: /nganjukvisit/admin/index.php");
                } elseif ($row['role'] == 'pengelola') {
                    header("Location: /nganjukvisit/pengelola/index.php");
                } else {
                    $_SESSION['error'] = "Role pengguna tidak valid!";
                    header("Location: /nganjukvisit/login.php");
                }
                exit;
            }
        } else {
            // Jika password salah
            $_SESSION['error'] = "Password salah!";
            header("Location: /nganjukvisit/login.php");
            exit;
        }
    } else {
        // Jika email tidak ditemukan
        $_SESSION['error'] = "Email tidak ditemukan!";
        header("Location: /nganjukvisit/login.php");
        exit;
    }
}
?>
