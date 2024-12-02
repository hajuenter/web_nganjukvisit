<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_detail_tiket = $_POST['barcodeInput'];

    // Ambil data tiket berdasarkan id_detail_tiket
    $stmt = $conn->prepare("SELECT dt.*, dw.nama_wisata FROM detail_tiket dt 
                            JOIN detail_wisata dw ON dt.id_wisata = dw.id_wisata 
                            WHERE dt.id_detail_tiket = ?");
    $stmt->bind_param("i", $id_detail_tiket);
    $stmt->execute();
    $result = $stmt->get_result();
    $tiket = $result->fetch_assoc();

    if ($tiket) {
        // Validasi status harus "berhasil"
        if ($tiket['status'] !== 'berhasil') {
            echo json_encode(['success' => false, 'message' => 'Tiket belum dikonfirmasi.']);
            exit();
        }

        // Validasi waktu 24 jam sejak konfirmasi
        $waktu_konfirmasi = strtotime($tiket['waktu_konfirmasi']);
        $waktu_sekarang = time();
        $selisih_waktu = $waktu_sekarang - $waktu_konfirmasi;

        if ($selisih_waktu > 86400) { // 86400 detik = 24 jam
            echo json_encode(['success' => false, 'message' => 'Tiket sudah kadaluarsa (lebih dari 24 jam).']);
            exit();
        }

        // Cek apakah tiket sudah pernah di-scan sebelumnya
        if ($tiket['status'] === 'digunakan') {
            echo json_encode(['success' => false, 'message' => 'Tiket ini sudah pernah di-scan.']);
            exit();
        }

        // Update status menjadi "digunakan"
        $stmt = $conn->prepare("UPDATE detail_tiket SET status = 'digunakan' WHERE id_detail_tiket = ?");
        $stmt->bind_param("i", $id_detail_tiket);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Tiket berhasil di-scan.',
            'nama_wisata' => $tiket['nama_wisata'],
            'harga' => $tiket['harga'],
            'jumlah' => $tiket['jumlah'],
            'total' => $tiket['total']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan.']);
    }
}
