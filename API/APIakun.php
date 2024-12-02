<?php
header("Content-Type: application/json");
include_once '../koneksi.php';
include 'jsonResponse.php';
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

                jsonResponse(true, "Login berhasil", [
                    "id_user" => $user['id_user'],
                    "email" => $user['email'],
                    "nama" => $user['nama'],
                    "role" => $user['role'],
                    "alamat" => $user['alamat'],
                    "gambar" => $user['gambar'],
                    "no_hp" => $user['no_hp']
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
        jsonResponse(true, "Data user ditemukan", [
            "id_user" => $user['id_user'],
            "email" => $user['email'],
            "nama" => $user['nama'],
            "role" => $user['role'],
            "alamat" => $user['alamat'],
            "gambar" => $user['gambar'],
            "no_hp" => $user['no_hp']
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
    $no_hp = $_POST['no_hp'] ?? ''; // URL atau path gambar

    if ($id_user) {
        $update_sql = "UPDATE user SET nama = ?, alamat = ?, no_hp = ? WHERE id_user = ?";
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("sssi", $nama, $alamat, $no_hp, $id_user);

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
        jsonResponse(true, "Data user ditemukan", [
            "no_hp" => $user['no_hp']
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
                "no_hp" => $user['no_hp'] // Tambahkan data yang diperlukan
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

    // Add error logging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    try {
        // Validate input
        if (!isset($_POST["id_user"]) || !isset($_POST['photo'])) {
            jsonResponse(false, "Missing required parameters");
            return;
        }

        $idUser = intval($_POST["id_user"]); // Ensure integer
        $photo = htmlspecialchars($_POST['photo']);

        // Remove base64 prefix and handle potential spaces
        $photo = preg_replace('/^data:image\/\w+;base64,/', '', $photo);
        $photo = str_replace(' ', '+', $photo);

        // Decode base64 and validate
        $data = base64_decode($photo);
        if ($data === false) {
            jsonResponse(false, "Invalid base64 data");
            return;
        }

        // Generate unique filename
        $file = uniqid() . '.png';
        $filePath = "../public/gambar/" . $file;

        // Ensure directory exists and is writable
        $uploadDir = dirname($filePath);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Save file
        if (file_put_contents($filePath, $data) === false) {
            jsonResponse(false, "Failed to save file: " . error_get_last()['message']);
            return;
        }

        // Prepare database update
        $sqlqueryupload = "UPDATE `user` SET `gambar` = ? WHERE `id_user` = ?";
        $update_stmt = $koneksi->prepare($sqlqueryupload);

        if ($update_stmt === false) {
            // Log detailed error information
            jsonResponse(false, "Prepare statement failed: " . $koneksi->error);
            return;
        }

        // Bind parameters
        $update_stmt->bind_param("si", $file, $idUser);

        // Execute and check result
        if (!$update_stmt->execute()) {
            jsonResponse(false, "Update failed: " . $update_stmt->error);
            return;
        }

        // Check if any rows were actually updated
        if ($update_stmt->affected_rows === 0) {
            jsonResponse(false, "No rows updated. Check if user ID exists.");
            return;
        }

        // Close statement
        $update_stmt->close();

        jsonResponse(true,$file);

    } catch (Exception $e) {
        // Catch any unexpected errors
        jsonResponse(false, "An error occurred: " . $e->getMessage());
    }
}





?>