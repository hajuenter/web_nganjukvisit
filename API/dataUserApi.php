<?php
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    // Query untuk mengambil data pengguna dengan role 'user'
    $query = "SELECT * FROM user WHERE role = 'user'";
    $result = mysqli_query($conn, $query);

    // Memeriksa hasil query
    if ($result) {
        // Memeriksa apakah ada pengguna ditemukan
        if (mysqli_num_rows($result) > 0) {
            $users = [];
            while ($user = mysqli_fetch_assoc($result)) {
                $users[] = [
                    'id_user' => $user['id_user'],
                    'email' => $user['email'],
                    'nama' => $user['nama'],
                    'role' => $user['role'],
                    'alamat' => $user['alamat'],
                    'gambar' => $user['gambar'],
                    'kode_otp' => $user['kode_otp'],
                    'expired_otp' => $user['expired_otp'],
                    'status' => $user['status']
                ];
            }

            // Respons jika data pengguna ditemukan
            $response = [
                'status' => true,
                'message' => 'Data pengguna ditemukan',
                'data' => $users
            ];
        } else {
            // Respons jika tidak ada pengguna dengan role 'user'
            $response = [
                'status' => false,
                'message' => 'Tidak ada pengguna dengan role "user"'
            ];
        }
    } else {
        // Respons jika terjadi kesalahan dalam eksekusi query
        $response = [
            'status' => false,
            'message' => 'Gagal mengambil data pengguna: ' . mysqli_error($conn)
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);

    // Menutup koneksi database
    mysqli_close($conn);
} elseif ($requestMethod === "POST") {
    // Mengambil data dari request POST
    $email = $_POST['email'] ?? '';

    // Memeriksa apakah email sudah diberikan
    if ($email) {
        // Query untuk memeriksa user berdasarkan email
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Memeriksa hasil query
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Menyiapkan data pengguna untuk respons
            $userData = [
                'id_user' => $user['id_user'],
                'email' => $user['email'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'alamat' => $user['alamat'],
                'gambar' => $user['gambar'],
                'kode_otp' => $user['kode_otp'],
                'expired_otp' => $user['expired_otp'],
                'status' => $user['status']
            ];

            // Respons jika pengguna ditemukan
            $response = [
                'status' => true,
                'message' => 'Data pengguna ditemukan',
                'data' => $userData
            ];
        } else {
            // Respons jika pengguna tidak ditemukan
            $response = [
                'status' => false,
                'message' => 'Pengguna tidak ditemukan'
            ];
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Respons jika email tidak disediakan
        $response = [
            'status' => false,
            'message' => 'Email harus diisi'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);

    // Menutup koneksi database
    $conn->close();
}
