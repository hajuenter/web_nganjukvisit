<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Memuat autoloader Composer
include("../koneksi.php");
include("../base_url.php");

$conn = $koneksi;

// Ambil email dari formulir dan trim untuk menghindari spasi yang tidak diperlukan
$email = trim($_POST['email']);

// Persiapkan dan jalankan query
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah email ada di database
if ($result->num_rows > 0) {
    // Ambil data pengguna dari hasil query
    $user = $result->fetch_assoc();

    // Cek role pengguna
    if ($user['role'] != 'admin' && $user['role'] != 'pengelola') {
        // Jika role bukan admin atau pengelola, beri pesan error
        $_SESSION['gagal'] = 'Akses ditolak. Hanya admin atau pengelola yang diizinkan.';
        unset($_SESSION['berhasil']);
        header("Location:" . BASE_URL . "/lupa_password.php");
        exit();
    }

    if ($user['status'] != 'active') {
        $_SESSION['gagal'] = 'Akses ditolak. Status akun anda masih inactive.';
        unset($_SESSION['berhasil']);
        header("Location:" . BASE_URL . "/lupa_password.php");
        exit();
    }


    // Email ditemukan dan role valid, set session dan kirim OTP
    $_SESSION['email'] = $email;

    $otp = rand(10000000, 99999999); // 8 digit OTP
    $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes')); // OTP berlaku selama 5 menit

    // Simpan OTP dan waktu kedaluwarsa di database
    $sql = "UPDATE user SET kode_otp = ?, expired_otp = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $otp, $expiry, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Kirim email dengan kode OTP
        $mail = new PHPMailer(true); // Instance dari PHPMailer

        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Ganti dengan alamat SMTP server Google
            $mail->SMTPAuth = true; // Aktifkan otentikasi SMTP
            $mail->Username = 'hey12844@gmail.com'; // Ganti dengan alamat email Google kamu
            $mail->Password = 'rpsi iafq vizu wwyc'; // Ganti dengan sandi aplikasi Google kamu
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Aktifkan enkripsi TLS
            $mail->Port = 587; // Port SMTP untuk TLS

            // Penerima
            $mail->setFrom('nganjukvisit86@gmail.com', 'Nganjuk Visit');
            $mail->addAddress($email); // Tambahkan penerima

            // Konten email
            $mail->isHTML(true); // Set email format ke HTML
            $mail->Subject = 'Kode OTP untuk Pemulihan Password';
            $mail->Body    = "Kode OTP Anda adalah: <strong>$otp</strong><br>Kode ini berlaku selama 5 menit.";
            $mail->AltBody = "Kode OTP Anda adalah: $otp\nKode ini berlaku selama 5 menit.";

            $mail->send();
            $_SESSION['berhasil'] = 'Email ditemukan dan kode OTP sudah dikirim ke email.';
            unset($_SESSION['gagal']);
            header("Location:" . BASE_URL . "/lupa_password_otp.php");
        } catch (Exception $e) {
            $_SESSION['gagal'] = 'Terjadi kesalahan saat mengirim email. Silakan coba lagi. Error: ' . $mail->ErrorInfo;
            unset($_SESSION['berhasil']);
            header("Location:" . BASE_URL . "/lupa_password.php");
        }
    } else {
        $_SESSION['gagal'] = 'Terjadi kesalahan saat memperbarui data OTP.';
        unset($_SESSION['berhasil']);
        header("Location:" . BASE_URL . "/lupa_password.php");
    }
} else {
    // Email tidak ditemukan, beri tahu pengguna
    $_SESSION['gagal'] = 'Email tidak ditemukan. Silakan coba lagi.';
    unset($_SESSION['berhasil']);
    header("Location:" . BASE_URL . "/lupa_password.php");
}

// Tutup koneksi
$stmt->close();
$conn->close();
