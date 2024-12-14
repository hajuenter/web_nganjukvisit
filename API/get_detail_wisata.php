<?php
// Mengatur header respons menjadi JSON dan mendukung CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include("../config/encryption_helper.php");
include("../config/key.php"); // Mengizinkan akses dari domain lain, jika perlu

// Mengimpor koneksi database
include '../koneksi.php'; // Pastikan file ini sudah ada untuk koneksi database

$conn = $koneksi;

// Memastikan koneksi berhasil
if (!$conn) {
    $response = [
        'status' => false,
        'message' => 'Koneksi ke database gagal'
    ];
    echo json_encode($response);
    exit();
}

// Mengambil metode request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    $sql = "SELECT * FROM detail_wisata";
    $result = mysqli_query($conn, $sql);

    // Memeriksa apakah ada data yang ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
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
                'id_pengelola' => $detail_wisata['id_pengelola'],
                'no_hp_pengelola' => $detail_wisata['no_hp_pengelola']
            ];
        }

        // Respons jika data wisata ditemukan
        $response = [
            'status' => true,
            'message' => 'Data wisata ditemukan',
            'data' => $data_detail_wisata
        ];
    } else {
        // Respons jika data wisata tidak ditemukan
        $response = [
            'status' => false,
            'message' => 'Data wisata tidak ditemukan'
        ];
    }

    // Mengirimkan respons dalam format JSON
    echo json_encode($response);
} else {
    // Respons jika metode tidak sesuai
    $response = [
        'status' => false,
        'message' => 'Metode request tidak valid'
    ];
    echo json_encode($response);
}

// Menutup koneksi database
mysqli_close($conn);
