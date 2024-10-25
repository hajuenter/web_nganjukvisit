<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Fungsi untuk memvalidasi email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) && str_ends_with($email, '@gmail.com');
}

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
    $allowedKeys = ['email', 'password'];

    // Validasi kunci input
    $validationResult = validateInputKeys($inputKeys, $allowedKeys);
    if (!$validationResult['status']) {
        echo json_encode($validationResult);
        exit();
    }

    // Mengambil dan sanitasi data dari input
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    // Validasi input
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => false, 'message' => 'Data yang diperlukan (email, password) tidak lengkap']);
        exit();
    }

    // Validasi email
    if (!validateEmail($email)) {
        echo json_encode(['status' => false, 'message' => 'Email harus valid dan menggunakan domain @gmail.com']);
        exit();
    }

    // Cek jika email ada di database
    $queryCheckEmail = "SELECT * FROM user WHERE email = '$email'";
    $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);

    if (mysqli_num_rows($resultCheckEmail) > 0) {
        $user = mysqli_fetch_assoc($resultCheckEmail);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Cek jika role user adalah 'user'
            if ($user['role'] === 'user') {
                // Jika login berhasil dan role sesuai, kembalikan data pengguna
                echo json_encode([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'id_user' => $user['id_user'],
                        'email' => $user['email'],
                        'nama' => $user['nama'],
                        'role' => $user['role'],
                        'alamat' => $user['alamat'],
                        'gambar' => $user['gambar'],
                        'kode_otp' => $user['kode_otp'],
                        'expired_otp' => $user['expired_otp'], 
                        'status' => $user['status']
                    ]
                ]);
            } else {
                // Jika role tidak sesuai
                echo json_encode(['status' => false, 'message' => 'Akses ditolak. Role tidak sesuai.']);
            }
        } else {
            // Jika password salah
            echo json_encode(['status' => false, 'message' => 'Password salah']);
        }
    } else {
        // Jika email tidak terdaftar
        echo json_encode(['status' => false, 'message' => 'Email tidak terdaftar']);
    }
} else {
    // Jika metode request tidak dikenali
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}

// Menutup koneksi
mysqli_close($conn);
