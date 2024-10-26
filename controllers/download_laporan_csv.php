<?php
// Koneksi ke database
include('../koneksi.php');
$conn = $koneksi;

// Query untuk mengambil data laporan dari tabel `riwayat_transaksi_tiket_wisata`
$query = "SELECT * FROM riwayat_transaksi_tiket_wisata";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Set nama file CSV
$fileName = 'Laporan_Riwayat_Transaksi_Tiket_Wisata.csv';

// Mengirim header HTTP agar file terdownload sebagai CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . $fileName . '"');

// Membuka output stream untuk menulis data CSV
$output = fopen('php://output', 'w');

// Menulis header kolom ke CSV
fputcsv($output, ['ID Transaksi', 'ID Detail Tiket', 'Nama Wisata', 'Jumlah Tiket', 'Harga Tiket', 'Total', 'Status']);

// Menulis data dari query ke CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id_transaksi'],
        $row['id_detail_tiket'],
        $row['nama_wisata'],
        $row['jumlah_tiket'],
        $row['harga_tiket'],
        $row['total'],
        $row['status']
    ]);
}

// Menutup output stream
fclose($output);

// Menutup koneksi database
$conn->close();
