<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Memeriksa apakah metode request adalah GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query untuk mengambil semua user dengan role 'user'
    $query = "SELECT * FROM user WHERE role = 'user'";
    $result = mysqli_query($conn, $query);

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

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
} else {
    // Respons jika metode request tidak valid
    echo json_encode([
        'status' => false,
        'message' => 'Metode request tidak valid'
    ]);
}
