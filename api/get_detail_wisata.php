<?php
// Set header response menjadi JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $sql = "SELECT * FROM detail_wisata";
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah ada pengguna ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data_detail_wisata = [];
        while ($detail_wisata = mysqli_fetch_assoc($result)) {
            $data_detail_wisata[] = [
                'id_wisata' => $detail_wisata['id_wisata'],
                'nama_wisata' => $detail_wisata['nama_wisata'],
                'id_user' => $detail_wisata['id_user'],
                'deskripsi' => $detail_wisata['deskripsi'],
                'alamat' => $detail_wisata['alamat'],
                'harga_tiket' => $detail_wisata['harga_tiket'],
                'jadwal' => $detail_wisata['jadwal'],
                'gambar' => $detail_wisata['gambar'],
                'koordinat' => $detail_wisata['koordinat'],
                'link_maps' => $detail_wisata['link_maps'],
                'id_pengelola' => $detail_wisata['id_pengelola']
            ];
        }

        // Respons jika data pengguna ditemukan
        $response = [
            'status' => true,
            'message' => 'Data wisata ditemukan',
            'data' => $data_detail_wisata
        ];
    } else {
        // Respons jika tidak ada pengguna dengan role 'user'
        $response = [
            'status' => false,
            'message' => 'Data wisata tidak ditemukan'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
}
