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
}
