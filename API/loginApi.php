<?php
// Menghubungkan ke database
include '../koneksi.php';

// Mendapatkan data dari aplikasi Android
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$conn = $koneksi;
if ($email && $password) {
    // Mengecek user di database berdasarkan email
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Membuat token acak
            $token = bin2hex(random_bytes(16));
            $expired_token = date("Y-m-d H:i:s", strtotime("+1 day")); // Token berlaku 1 hari

            // Memperbarui token dan expired_token ke database
            $update_sql = "UPDATE user SET token = ?, expired_token = ? WHERE id_user = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssi", $token, $expired_token, $user['id_user']);
            $update_stmt->execute();

            // Mengembalikan respon sukses
            echo json_encode([
                "status" => "success",
                "message" => "Login berhasil",
                "data" => [
                    "id_user" => $user['id_user'],
                    "email" => $user['email'],
                    "nama" => $user['nama'],
                    "role" => $user['role'],
                    "alamat" => $user['alamat'],
                    "gambar" => $user['gambar'],
                    "no_hp" => $user['no_hp'],
                    "token" => $token,
                    "expired_token" => $expired_token
                ]
            ]);
        } else {
            // Password salah
            echo json_encode([
                "status" => "error",
                "message" => "Password salah"
            ]);
        }
    } else {
        // Email tidak ditemukan
        echo json_encode([
            "status" => "error",
            "message" => "Email tidak ditemukan"
        ]);
    }
} else {
    // Input tidak lengkap
    echo json_encode([
        "status" => "error",
        "message" => "Email dan password harus diisi"
    ]);
}

// Menutup koneksi
$conn->close();
?>