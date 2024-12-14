<?php
header("Content-Type: application/json");
include_once '../koneksi.php';
include 'jsonResponse.php';
include("../config/encryption_helper.php");
include("../config/key.php");
global $koneksi;
// Mendapatkan parameter `action` untuk menentukan fungsi yang dipanggil
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        login();
        break;
    case 'google':
        LoginGoogle();
        break;
    case 'register':
        register();
        break;
    case 'forgot_password':
        forgotPassword();
        break;
    case 'get_user_info':
        getUserInfo();
        break;
    case 'edit_user_info':
        editUserInfo();
        break;
    case 'cari_nomor_pengelola':
        SearchNoPengelola();
        break;
    case 'base64':
        base64();
        break;
    default:
        jsonResponse(false, "Action tidak valid");
}

// Fungsi login
function login()
{
    global $koneksi;

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $decrypted_no_hp = decryptData($user['no_hp'], ENCRYPTION_KEY);
                jsonResponse(true, "Login berhasil", [
                    "id_user" => $user['id_user'],
                    "email" => $user['email'],
                    "nama" => $user['nama'],
                    "role" => $user['role'],
                    "alamat" => $user['alamat'],
                    "gambar" => $user['gambar'],
                    "no_hp" => $decrypted_no_hp
                ]);
            } else {
                jsonResponse(false, "Password salah");
            }
        } else {
            jsonResponse(false, "Email tidak ditemukan");
        }
    } else {
        jsonResponse(false, "Email dan password diperlukan");
    }
}

// Fungsi register
function register()
{
    global $koneksi;

    $alamat = $_POST['alamat'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $nama = $_POST['nama'] ?? '';
    if (validateEmail($email) && validatePassword($password) && $nama) {
        $sqlCheckEmail = "SELECT id_user FROM user WHERE email = ?";
        $stmtCheck = $koneksi->prepare($sqlCheckEmail);
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        if ($stmtCheck->num_rows > 0) {
            jsonResponse(false, "Email sudah terdaftar.");
        } else {
            // Jika email belum terdaftar, lanjutkan dengan proses registrasi
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (alamat, email, password, nama, role) VALUES (?, ?, ?, ?, 'user')";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("ssss", $alamat, $email, $password_hashed, $nama);

            if ($stmt->execute()) {
                jsonResponse(true, "Registrasi berhasil");
            } else {
                jsonResponse(false, "Gagal registrasi. Silakan coba lagi.");
            }
        }
    } else {
        jsonResponse(false, "Data tidak valid");
    }
}


// Fungsi lupa password
function forgotPassword()
{
    global $koneksi;

    $email = $_POST["email"];
    $passget = $_POST["password"];
    $password = password_hash($passget, PASSWORD_BCRYPT);

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(false, "Email tidak valid");
        return;
    }

    // Validasi password (minimal 6 karakter)
    if (strlen($passget) < 6) {
        jsonResponse(false, "Password harus minimal 6 karakter");
        return;
    }

    // Query untuk mengupdate password
    $sqlquery = "UPDATE `user` SET `password`='$password' WHERE email = '$email'";

    $result = mysqli_query($koneksi, $sqlquery);

    if ($result) {
        jsonResponse(true, "Berhasil mengubah password");
    } else {
        jsonResponse(false, "Gagal mengubah password");
    }
}



// Fungsi mendapatkan detail info user
function getUserInfo()
{
    global $koneksi;

    $token = $_POST['token'] ?? '';

    $sql = "SELECT * FROM user WHERE token = ? AND expired_token > NOW()";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $decrypted_no_hp = decryptData($user['no_hp'], ENCRYPTION_KEY);
        jsonResponse(true, "Data user ditemukan", [
            "id_user" => $user['id_user'],
            "email" => $user['email'],
            "nama" => $user['nama'],
            "role" => $user['role'],
            "alamat" => $user['alamat'],
            "gambar" => $user['gambar'],
            "no_hp" => $decrypted_no_hp
        ]);
    } else {
        jsonResponse(false, "Token tidak valid atau telah kedaluwarsa");
    }
}
// Fungsi edit informasi user
function editUserInfo()
{
    global $koneksi;

    $id_user = $_POST['id_user'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $encrypted_no_hp = encryptData($no_hp, ENCRYPTION_KEY);

    if ($id_user) {

        $update_sql = "UPDATE user SET nama = ?, alamat = ?, no_hp = ? WHERE id_user = ?";
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("sssi", $nama, $alamat, $encrypted_no_hp, $id_user);

        if ($update_stmt->execute()) {
            jsonResponse(true, "Informasi pengguna berhasil diperbarui");
        } else {
            jsonResponse(false, "Gagal memperbarui informasi pengguna");
        }
    } else {
        jsonResponse(false, "ID pengguna diperlukan untuk memperbarui informasi");
    }
}

function SearchNoPengelola()
{
    global $koneksi;

    $id_wis = $_POST['id_wisata'] ?? '';

    $sql = "SELECT * FROM user WHERE ket_wisata = ? AND role = 'pengelola'";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $id_wis);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $decrypted_no_hp = decryptData($user['no_hp'], ENCRYPTION_KEY);
        jsonResponse(true, "Data pengelola ditemukan", [
            "no_hp" => $decrypted_no_hp
        ]);
    } else {
        jsonResponse(false, "Nomor Hp tidak ditemukan");
    }
}
function LoginGoogle()
{
    global $koneksi;

    // Ambil data dari request POST
    $email = $_POST['email'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array('status' => 'error', 'message' => 'Email tidak valid');
        echo json_encode($response);
        return;
    }

    // Query untuk memeriksa apakah email sudah terdaftar
    $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika email ditemukan
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $decrypted_no_hp = decryptData($user['no_hp'], ENCRYPTION_KEY);
        $response = array(
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => array(
                "id_user" => $user['id_user'],
                "email" => $user['email'],
                "nama" => $user['nama'],
                "role" => $user['role'],
                "alamat" => $user['alamat'],
                "gambar" => $user['gambar'],
                "no_hp" => $decrypted_no_hp // Tambahkan data yang diperlukan
            )
        );
    } else {
        // Jika email tidak ditemukan
        $response = array('status' => 'notfound', 'message' => 'Email tersebut belum terdaftar.');
    }

    // Tampilkan respons dalam format JSON
    echo json_encode($response);
}

function base64()
{
    global $koneksi;

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    try {
        if (!isset($_POST["id_user"]) || !isset($_POST['photo'])) {
            jsonResponse(false, "Missing required parameters");
            return;
        }

        $idUser = intval($_POST["id_user"]);
        $photo = htmlspecialchars($_POST['photo']);

        $photo = preg_replace('/^data:image\/\w+;base64,/', '', $photo);
        $photo = str_replace(' ', '+', $photo);

        $data = base64_decode($photo);
        if ($data === false) {
            jsonResponse(false, "Invalid base64 data");
            return;
        }

        $hash = md5($data);
        $file = $hash . '.png';
        $filePath = "../public/gambar/" . $file;

        $uploadDir = dirname($filePath);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $sqlCheckCurrentPhoto = "SELECT `gambar` FROM `user` WHERE `id_user` = ?";
        $checkStmt = $koneksi->prepare($sqlCheckCurrentPhoto);

        if ($checkStmt === false) {
            jsonResponse(false, "Prepare statement failed: " . $koneksi->error);
            return;
        }

        $checkStmt->bind_param("i", $idUser);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->bind_result($currentImage);
            $checkStmt->fetch();

            if ($currentImage && $currentImage !== $file) {
                $oldFilePath = "../public/gambar/" . $currentImage;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }

        $checkStmt->close();

        if (file_exists($filePath)) {
            jsonResponse(false, "Duplikat foto terdeteksi. Upload ditolak.");
            return;
        }

        if (file_put_contents($filePath, $data) === false) {
            jsonResponse(false, "Gagal menyimpan foto: " . error_get_last()['message']);
            return;
        }

        $sqlqueryupload = "UPDATE `user` SET `gambar` = ? WHERE `id_user` = ?";
        $update_stmt = $koneksi->prepare($sqlqueryupload);

        if ($update_stmt === false) {
            jsonResponse(false, "Prepare statement gagal: " . $koneksi->error);
            return;
        }

        $update_stmt->bind_param("si", $file, $idUser);

        if (!$update_stmt->execute()) {
            jsonResponse(false, "Update gagal: " . $update_stmt->error);
            return;
        }

        if ($update_stmt->affected_rows === 0) {
            jsonResponse(false, "tidak ada baris yang diperbarui. Cek jika user ID exists.");
            return;
        }

        $update_stmt->close();

        jsonResponse(true, $file);
    } catch (Exception $e) {
        jsonResponse(false, "An error occurred: " . $e->getMessage());
    }
}
