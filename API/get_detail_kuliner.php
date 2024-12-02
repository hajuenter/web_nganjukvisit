<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $sql = "SELECT * FROM detail_kuliner";
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah ada pengguna ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data_detail_kuliner = [];
        while ($detail_kuliner = mysqli_fetch_assoc($result)) {
            $data_detail_kuliner[] = [
                'id_kuliner' => $detail_kuliner['id_kuliner'],
                'nama_kuliner' => $detail_kuliner['nama_kuliner'],
                'id_user' => $detail_kuliner['id_user'],
                'deskripsi' => $detail_kuliner['deskripsi'],
                'harga' => $detail_kuliner['harga'],
                'gambar' => $detail_kuliner['gambar']
            ];
        }

        // Respons jika data pengguna ditemukan
        $response = [
            'status' => true,
            'message' => 'Data kuliner ditemukan',
            'data' => $data_detail_kuliner
        ];
    } else {
        // Respons jika tidak ada pengguna dengan role 'user'
        $response = [
            'status' => false,
            'message' => 'Data kuliner tidak ditemukan'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
}
