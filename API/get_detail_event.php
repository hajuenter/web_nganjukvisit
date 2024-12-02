<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $sql = "SELECT * FROM detail_event";
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah ada pengguna ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data_detail_event = [];
        while ($detail_event = mysqli_fetch_assoc($result)) {
            $data_detail_event[] = [
                'id_event' => $detail_event['id_event'],
                'nama' => $detail_event['nama'],
                'id_user' => $detail_event['id_user'],
                'deskripsi_event' => $detail_event['deskripsi_event'],
                'alamat' => $detail_event['alamat'],
                'gambar' => $detail_event['gambar'],
                'tanggal_event' => $detail_event['tanggal_event']
            ];
        }

        // Respons jika data pengguna ditemukan
        $response = [
            'status' => true,
            'message' => 'Data event ditemukan',
            'data' => $data_detail_event
        ];
    } else {
        // Respons jika tidak ada pengguna dengan role 'user'
        $response = [
            'status' => false,
            'message' => 'Data event tidak ditemukan'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
}
