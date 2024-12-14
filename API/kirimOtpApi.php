<?php
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Memuat autoloader Composer
include("../koneksi.php");

$conn = $koneksi;

$requestMethod = $_SERVER['REQUEST_METHOD'];

// Fungsi untuk memvalidasi input keys
function validateInputKeys($inputKeys, $allowedKeys)
{
    foreach ($inputKeys as $key) {
        if (!in_array($key, $allowedKeys)) {
            return ['status' => false, 'message' => 'Kunci input tidak valid: ' . $key];
        }
    }
    return ['status' => true];
}

// Jika metode request adalah POST
if ($requestMethod === 'POST') {
    // Ambil input keys
    $inputKeys = array_keys($_POST);
    $allowedKeys = ['email'];

    // Validasi kunci input
    $validationResult = validateInputKeys($inputKeys, $allowedKeys);
    if (!$validationResult['status']) {
        echo json_encode($validationResult);
        exit();
    }

    // Ambil email dari request body dan trim untuk menghindari spasi yang tidak diperlukan
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validasi format email
    if (empty($email)) {
        echo json_encode(['status' => false, 'message' => 'Email tidak boleh kosong']);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'message' => 'Format email tidak valid']);
        exit();
    }

    // Persiapkan dan jalankan query
    $sql = "SELECT * FROM user WHERE email = ? AND role = 'user'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah email ada di database dengan role 'user'
    if ($result->num_rows > 0) {
        // Ambil data pengguna dari hasil query
        $user = $result->fetch_assoc();

        // Generate kode OTP
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);// 8 digit OTP
        $expiry = date('Y-m-d H:i:s', strtotime('+60 second')); // OTP berlaku selama 5 menit

        // Simpan OTP dan waktu kedaluwarsa di database
        $sql = "UPDATE user SET kode_otp = ?, expired_otp = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $otp, $expiry, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Kirim email dengan kode OTP
            $mail = new PHPMailer(true);

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
                $mail->Body = "Kode OTP Anda adalah: <strong>$otp</strong><br>Kode ini berlaku selama 60 detik.";
                $mail->AltBody = "Kode OTP Anda adalah: $otp\nKode ini berlaku selama 60 detik.";

                // Set timeout untuk pengiriman email
                $mail->Timeout = 30; // Timeout dalam detik

                // Kirim email
                $mail->send();
                // Kirim respons JSON termasuk email dan OTP
                echo json_encode(['status' => true, 'message' => 'Kode OTP sudah dikirim ke email Anda.', 'data' => ['email' => $email, 'otp' => $otp]]);
            } catch (Exception $e) {
                echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat mengirim email. Silakan coba lagi. Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memperbarui data OTP.']);
        }
    } else {
        // Email tidak ditemukan atau bukan role 'user'
        echo json_encode(['status' => false, 'message' => 'Email tidak terdaftar atau tidak memiliki akses sebagai pengguna.']);
    }

    // Menutup statement dan koneksi database
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid.']);
}
