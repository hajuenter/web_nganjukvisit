<?php
// Mengatur header respons sebagai JSON
header("Content-Type: application/json");

// Mengimpor koneksi database
include '../koneksi.php';
include("../config/encryption_helper.php");
include("../config/key.php");
$conn = $koneksi; // Menggunakan koneksi dari config

require 'jsonResponse.php'; // Mengimpor file untuk menangani JSON

// Mendapatkan metode permintaan
$method = $_SERVER['REQUEST_METHOD'];

// Mendapatkan parameter action
$action = isset($_GET['action']) ? $_GET['action'] : null;

// Percabangan berdasarkan action
if ($method == 'GET') {
    // Menampilkan tiket berdasarkan action
    if ($action == 'tampilkan' && isset($_GET['id_user'])) {
        // Menampilkan daftar tiket berdasarkan id_user
        $id_user = $_GET['id_user'];

        try {
            $stmt = $conn->prepare("
                SELECT dt.*, u.nama AS nama_pemesan, dw.nama_wisata
                FROM detail_tiket dt
                JOIN user u ON dt.id_user = u.id_user
                JOIN detail_wisata dw ON dt.id_wisata = dw.id_wisata
                WHERE dt.id_user = ? AND dt.status IN ('gagal', 'diproses', 'berhasil')
            ");

            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $result = $stmt->get_result();

            $tiket = $result->fetch_all(MYSQLI_ASSOC);
            jsonResponse(true, "Tiket berhasil diambil", $tiket);
        } catch (Exception $e) {
            jsonResponse(false, "Gagal mengambil data tiket: " . $e->getMessage(), null);
        }
    }
    // Pencarian tiket berdasarkan nama wisata
    elseif ($action == 'cari' && isset($_GET['search'])) {
        // Pencarian tiket berdasarkan nama wisata
        $searchTerm = $_GET['search']; // Mendapatkan kata kunci pencarian
        $id_user = $_GET['id_user']; // Mendapatkan ID pengguna dari parameter

        try {
            $stmt = $conn->prepare("
            SELECT dt.*, dw.nama_wisata, u.nama AS nama_pemesan
            FROM detail_tiket dt
            JOIN detail_wisata dw ON dt.id_wisata = dw.id_wisata
            JOIN user u ON dt.id_user = u.id_user
            WHERE dw.nama_wisata LIKE ? AND dt.id_user = ?
        ");

            $searchTerm = "%" . $searchTerm . "%"; // Membuat wildcard untuk pencarian
            $stmt->bind_param("si", $searchTerm, $id_user); // Bind parameter (s untuk string, i untuk integer)
            $stmt->execute();
            $result = $stmt->get_result();

            $tiket = $result->fetch_all(MYSQLI_ASSOC);
            jsonResponse(true, "Tiket berhasil ditemukan", $tiket);
        } catch (Exception $e) {
            jsonResponse(false, "Gagal mencari tiket: " . $e->getMessage(), null);
        }
    } else {
        jsonResponse(false, "Action tidak ditemukan", null);
    }
}

// Menambahkan pesanan tiket
elseif ($method == 'POST' && $action == 'pesan') {
    // Mendapatkan data dari body permintaan
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    $allowedKeys = ['id_wisata', 'id_user', 'harga_tiket', 'nama_wisata', 'jumlah', 'tanggal', 'status', 'total'];
    validateInputKeys(array_keys($data), $allowedKeys);

    $id_wisata = $data['id_wisata'];
    $id_user = $data['id_user'];
    $harga_tiket = $data['harga_tiket'];
    $nama_wisata = $data['nama_wisata'];
    $jumlah = $data['jumlah'];
    $tanggal = $data['tanggal'];
    $status = $data['status'];
    $total = $data['total'];

    try {
        // Menyimpan tiket wisata baru
        $stmt = $conn->prepare("SELECT * FROM tiket_wisata WHERE id_wisata = ?");
        $stmt->bind_param("i", $id_wisata);
        $stmt->execute();
        $result = $stmt->get_result();
        // Mendapatkan ID tiket yang baru saja ditambahkan
        $id_tiket = $result->fetch_assoc();

        // Menyimpan detail tiket
        $stmtDetail = $conn->prepare("INSERT INTO detail_tiket (id_tiket, id_user, id_wisata, harga, jumlah, total, kembalian, tanggal, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $kembalian = 0; // Misalnya, untuk saat ini
        $stmtDetail->bind_param("iiisisiss", $id_tiket['id_tiket'], $id_user, $id_wisata, $harga_tiket, $jumlah, $total, $kembalian, $tanggal, $status);
        $stmtDetail->execute();

        jsonResponse("success", "Tiket berhasil ditambahkan", ["id_tiket" => $id_tiket['id_tiket']]);
    } catch (Exception $e) {
        jsonResponse(false, "Gagal menambahkan tiket: " . $e->getMessage(), null);
    }
} else {
    jsonResponse(false, "Metode atau action tidak diizinkan", null);
}
