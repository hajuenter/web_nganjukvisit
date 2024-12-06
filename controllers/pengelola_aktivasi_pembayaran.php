<?php
session_start();
include("../koneksi.php");
include("../base_url.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $id_detail_tiket = $_POST['id_detail_tiket'];
    $status = $_POST['status'];

    // Mendapatkan detail tiket
    $stmt = $conn->prepare("SELECT * FROM detail_tiket WHERE id_detail_tiket = ?");
    $stmt->bind_param("i", $id_detail_tiket);
    $stmt->execute();
    $detail = $stmt->get_result()->fetch_assoc();

    if ($detail) {
        if ($status === 'berhasil') {
            // Validasi tanggal tiket hanya untuk status berhasil
            $tanggalTiket = $detail['tanggal'];
            if (strtotime($tanggalTiket) < strtotime(date('Y-m-d'))) {
                $_SESSION['error'] = "Tiket sudah kadaluarsa dan tidak dapat dikonfirmasi.";
                header("Location:" . BASE_URL . "/pengelola/pengelola_konfir_tiket.php");
                exit();
            }

            // Ambil nama wisata berdasarkan id_wisata
            $stmt_wisata = $conn->prepare("SELECT nama_wisata FROM detail_wisata WHERE id_wisata = ?");
            $stmt_wisata->bind_param("i", $detail['id_wisata']);
            $stmt_wisata->execute();
            $wisata = $stmt_wisata->get_result()->fetch_assoc();
            $nama_wisata = $wisata['nama_wisata'] ?? 'Nama Wisata Tidak Ditemukan';

            // Insert ke tabel riwayat
            $stmt = $conn->prepare("INSERT INTO riwayat_transaksi_tiket_wisata (id_detail_tiket, nama_wisata, jumlah_tiket, harga_tiket, total, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssis", $detail['id_detail_tiket'], $nama_wisata, $detail['jumlah'], $detail['harga'], $detail['total'], $status);
            $stmt->execute();

            // Update status, bayar, dan waktu konfirmasi
            $stmt = $conn->prepare("UPDATE detail_tiket SET status = ?, bayar = ?, waktu_konfirmasi = NOW() WHERE id_detail_tiket = ?");
            $bayar = $detail['total'];
            $stmt->bind_param("ssi", $status, $bayar, $id_detail_tiket);
            $stmt->execute();

            $_SESSION['berhasil'] = "Pembayaran tiket berhasil dikonfirmasi.";
        } elseif ($status === 'gagal') {
            // Hapus data dari tabel detail_tiket jika ditolak
            $stmt = $conn->prepare("DELETE FROM detail_tiket WHERE id_detail_tiket = ?");
            $stmt->bind_param("i", $id_detail_tiket);
            $stmt->execute();

            $_SESSION['berhasil'] = "Tiket berhasil ditolak dan dihapus.";
        }

        header("Location:" . BASE_URL . "/pengelola/pengelola_konfir_tiket.php");
        exit();
    } else {
        $_SESSION['error'] = "Detail tiket tidak ditemukan.";
        header("Location:" . BASE_URL . "/pengelola/pengelola_konfir_tiket.php");
        exit();
    }
}
