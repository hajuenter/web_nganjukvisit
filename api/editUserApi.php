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

if ($requestMethod === 'PUT') {
    // Jika metode request adalah PUT
    parse_str(file_get_contents("php://input"), $_PUT);

    // Mengambil dan sanitasi data dari input
    $id_user = isset($_PUT['id_user']) ? mysqli_real_escape_string($conn, $_PUT['id_user']) : '';
    $email = isset($_PUT['email']) ? mysqli_real_escape_string($conn, $_PUT['email']) : '';
    $nama = isset($_PUT['nama']) ? mysqli_real_escape_string($conn, $_PUT['nama']) : '';
    $password = isset($_PUT['password']) ? mysqli_real_escape_string($conn, $_PUT['password']) : '';
    $alamat = isset($_PUT['alamat']) ? mysqli_real_escape_string($conn, $_PUT['alamat']) : '';

    // Validasi input untuk kunci yang tidak diperbolehkan
    $allowedKeys = ['email', 'nama', 'password', 'alamat', 'id_user'];
    $inputKeys = array_keys($_PUT);
    $validationResult = validateInputKeys($inputKeys, $allowedKeys);
    if (!$validationResult['status']) {
        echo json_encode($validationResult);
        exit();
    }

    // Validasi jika semua data wajib diisi
    if (empty($id_user) || empty($email) || empty($nama) || empty($password) || empty($alamat)) {
        echo json_encode(['status' => false, 'message' => 'Semua data (id_user, email, nama, password, alamat) harus diisi']);
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

    // Cek jika email sudah ada di database hanya jika email diubah
    $queryCurrentEmail = "SELECT email FROM user WHERE id_user = '$id_user'";
    $resultCurrentEmail = mysqli_query($conn, $queryCurrentEmail);
    $currentEmailRow = mysqli_fetch_assoc($resultCurrentEmail);
    $currentEmail = $currentEmailRow['email'] ?? '';

    if ($currentEmail !== $email) {
        $queryCheckEmail = "SELECT * FROM user WHERE email = '$email' AND id_user != '$id_user'";
        $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);
        if (mysqli_num_rows($resultCheckEmail) > 0) {
            echo json_encode(['status' => false, 'message' => 'Email sudah terdaftar']);
            exit();
        }
    }

    // Siapkan query untuk mengupdate data
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $queryUpdate = "UPDATE user SET email = '$email', nama = '$nama', password = '$hashedPassword', alamat = '$alamat' WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $queryUpdate)) {
        echo json_encode(['status' => true, 'message' => 'User berhasil diperbarui']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal memperbarui user']);
    }
} elseif ($requestMethod === 'PATCH') {
    // Jika metode request adalah PATCH
    parse_str(file_get_contents("php://input"), $_PATCH);

    // Mengambil dan sanitasi data dari input
    $id_user = isset($_PATCH['id_user']) ? mysqli_real_escape_string($conn, $_PATCH['id_user']) : '';
    $email = isset($_PATCH['email']) ? mysqli_real_escape_string($conn, $_PATCH['email']) : '';
    $nama = isset($_PATCH['nama']) ? mysqli_real_escape_string($conn, $_PATCH['nama']) : '';
    $password = isset($_PATCH['password']) ? mysqli_real_escape_string($conn, $_PATCH['password']) : '';
    $alamat = isset($_PATCH['alamat']) ? mysqli_real_escape_string($conn, $_PATCH['alamat']) : '';

    // Validasi input untuk kunci yang tidak diperbolehkan
    $allowedKeys = ['email', 'nama', 'password', 'alamat', 'id_user'];
    $inputKeys = array_keys($_PATCH);
    $validationResult = validateInputKeys($inputKeys, $allowedKeys);
    if (!$validationResult['status']) {
        echo json_encode($validationResult);
        exit();
    }

    // Validasi ID user
    if (empty($id_user)) {
        echo json_encode(['status' => false, 'message' => 'ID user tidak boleh kosong']);
        exit();
    }

    // Siapkan query untuk mengupdate data berdasarkan input yang diberikan
    $set = [];
    if (!empty($email)) {
        if (!validateEmail($email)) {
            echo json_encode(['status' => false, 'message' => 'Email harus valid dan menggunakan domain @gmail.com']);
            exit();
        }
        $queryCheckEmail = "SELECT * FROM user WHERE email = '$email' AND id_user != '$id_user'";
        $resultCheckEmail = mysqli_query($conn, $queryCheckEmail);
        if (mysqli_num_rows($resultCheckEmail) > 0) {
            echo json_encode(['status' => false, 'message' => 'Email sudah terdaftar']);
            exit();
        }
        $set[] = "email = '$email'";
    }

    if (!empty($nama)) {
        $set[] = "nama = '$nama'";
    }

    if (!empty($alamat)) {
        $set[] = "alamat = '$alamat'";
    }

    if (!empty($password)) {
        if (!validatePassword($password)) {
            echo json_encode(['status' => false, 'message' => 'Password harus memiliki panjang antara 8 hingga 50 karakter dan mengandung kombinasi huruf dan angka']);
            exit();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $set[] = "password = '$hashedPassword'";
    }

    if (empty($set)) {
        echo json_encode(['status' => false, 'message' => 'Tidak ada data yang diperbarui']);
        exit();
    }

    // Mengupdate data pengguna
    $setString = implode(', ', $set);
    $queryUpdate = "UPDATE user SET $setString WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $queryUpdate)) {
        echo json_encode(['status' => true, 'message' => 'User berhasil diperbarui']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal memperbarui user']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}

// Menutup koneksi
mysqli_close($conn);
