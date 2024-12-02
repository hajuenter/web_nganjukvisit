<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $sql = "SELECT * FROM detail_penginapan";
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah ada pengguna ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data_detail_penginapan = [];
        while ($detail_penginapan = mysqli_fetch_assoc($result)) {
            $data_detail_penginapan[] = [
                'id_penginapan' => $detail_penginapan['id_penginapan'],
                'nama_penginapan' => $detail_penginapan['nama_penginapan'],
                'id_user' => $detail_penginapan['id_user'],
                'deskripsi' => $detail_penginapan['deskripsi'],
                'harga' => $detail_penginapan['harga'],
                'lokasi' => $detail_penginapan['lokasi'],
                'gambar' => $detail_penginapan['gambar'],
                'telepon' => $detail_penginapan['telepon']
            ];
        }

        // Respons jika data pengguna ditemukan
        $response = [
            'status' => true,
            'message' => 'Data penginapan ditemukan',
            'data' => $data_detail_penginapan
        ];
    } else {
        // Respons jika tidak ada pengguna dengan role 'user'
        $response = [
            'status' => false,
            'message' => 'Data penginapan tidak ditemukan'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
}
