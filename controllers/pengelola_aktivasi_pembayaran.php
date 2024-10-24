<?php
session_start();
include("../koneksi.php"); // Koneksi database

$conn = $koneksi;

// Proses update status dan simpan ke riwayat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $id_detail_tiket = $_POST['id_detail_tiket'];
    $status = $_POST['status'];

    // Mendapatkan detail tiket
    $stmt = $conn->prepare("SELECT * FROM detail_tiket WHERE id_detail_tiket = ?");
    $stmt->bind_param("i", $id_detail_tiket);
    $stmt->execute();
    $detail = $stmt->get_result()->fetch_assoc();

    if ($detail) {
        // Ambil nama wisata berdasarkan id_wisata
        $stmt_wisata = $conn->prepare("SELECT nama_wisata FROM detail_wisata WHERE id_wisata = ?");
        $stmt_wisata->bind_param("i", $detail['id_wisata']);
        $stmt_wisata->execute();
        $result_wisata = $stmt_wisata->get_result();
        $wisata = $result_wisata->fetch_assoc();
        $nama_wisata = $wisata['nama_wisata'] ?? 'Nama Wisata Tidak Ditemukan';

        // Insert ke tabel riwayat
        $stmt = $conn->prepare("INSERT INTO riwayat_transaksi_tiket_wisata (id_detail_tiket, nama_wisata, jumlah_tiket, harga_tiket, total, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $detail['id_detail_tiket'], $nama_wisata, $detail['jumlah'], $detail['harga'], $detail['total'], $status);
        $stmt->execute();

        // Update status dan bayar di detail_tiket
        $stmt = $conn->prepare("UPDATE detail_tiket SET status = ?, bayar = ? WHERE id_detail_tiket = ?");
        $bayar = $detail['total'];
        $stmt->bind_param("ssi", $status, $bayar, $id_detail_tiket);
        $stmt->execute();

        $_SESSION['berhasil'] = "Pembayaran tiket berhasil dikonfirmasi";
        header("Location: ../pengelola/pengelola_konfir_tiket.php");
        exit();
    } else {
        $_SESSION['error'] = "Detail tiket tidak ditemukan.";
    }
}
