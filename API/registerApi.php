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

// Fungsi untuk memvalidasi password
function validatePassword($password)
{
    return strlen($password) >= 8 && strlen($password) <= 50 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
}

// Fungsi untuk memeriksa input yang tidak valid
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
    // Mengambil dan sanitasi data dari input
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $nama = isset($_POST['nama']) ? mysqli_real_escape_string($conn, $_POST['nama']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';

    // Validasi input untuk kunci yang tidak diperbolehkan
    $allowedKeys = ['email', 'nama', 'password', 'alamat'];
    $inputKeys = array_keys($_POST);
    $validationResult = validateInputKeys($inputKeys, $allowedKeys);
    if (!$validationResult['status']) {
        echo json_encode($validationResult);
        exit();
    }

    // Validasi input
    if (empty($email) || empty($nama) || empty($password)) {
        echo json_encode(['status' => false, 'message' => 'Data yang diperlukan (email, nama, password) tidak lengkap']);
        exit();
    }

    // Validasi email
    if (!validateEmail($email)) {
        echo json_encode(['status' => false, 'message' => 'Email harus valid dan menggunakan domain @gmail.com']);
        exit();
    }

    // Validasi password
    if (!validatePassword($password)) {
        echo json_encode(['status' => false, 'message' => 'Password harus memiliki panjang antara 8 hingga 50 karakter dan mengandung kombinasi huruf dan angka']);
        exit();
    }

    // Cek jika email sudah ada di database
    $queryCheckEmail = "SELECT * FROM user WHERE email = '$email'";
    $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);
    if (mysqli_num_rows($resultCheckEmail) > 0) {
        echo json_encode(['status' => false, 'message' => 'Email sudah terdaftar']);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Siapkan query untuk memasukkan data baru
    $queryInsert = "INSERT INTO user (email, nama, password, alamat, role, status) VALUES ('$email', '$nama', '$hashedPassword', '$alamat', 'user', 'active')";
    if (mysqli_query($conn, $queryInsert)) {
        echo json_encode(['status' => true, 'message' => 'User berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal menambahkan user: ' . mysqli_error($conn)]);
    }
} else {
    // Jika metode request tidak valid
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}

// Menutup koneksi
mysqli_close($conn);
