<?php
require '../vendor/autoload.php'; // Memastikan autoload Composer sudah di-load

// Pastikan Anda menggunakan library FPDF yang tidak menggunakan namespace.
require_once('../vendor/setasign/fpdf/fpdf.php');

// Koneksi ke database
include('../koneksi.php');
$conn = $koneksi;

// Query untuk mengambil data laporan dari tabel `riwayat_transaksi_tiket_wisata`
$query = "SELECT * FROM riwayat_transaksi_tiket_wisata";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Inisialisasi objek FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Judul laporan
$pdf->Cell(0, 10, 'Laporan Riwayat Transaksi Tiket Wisata', 0, 1, 'C');

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 10, 'ID Transaksi', 1);
$pdf->Cell(30, 10, 'ID Detail Tiket', 1);
$pdf->Cell(40, 10, 'Nama Wisata', 1);
$pdf->Cell(25, 10, 'Jumlah Tiket', 1);
$pdf->Cell(25, 10, 'Harga Tiket', 1);
$pdf->Cell(20, 10, 'Total', 1);
$pdf->Cell(20, 10, 'Status', 1);
$pdf->Ln();

// Isi tabel
$pdf->SetFont('Arial', '', 10);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(25, 10, $row['id_transaksi'], 1);
    $pdf->Cell(30, 10, $row['id_detail_tiket'], 1);
    $pdf->Cell(40, 10, $row['nama_wisata'], 1);
    $pdf->Cell(25, 10, $row['jumlah_tiket'], 1);
    $pdf->Cell(25, 10, $row['harga_tiket'], 1);
    $pdf->Cell(20, 10, $row['total'], 1);
    $pdf->Cell(20, 10, $row['status'], 1);
    $pdf->Ln();
}

// Output file PDF ke browser
$pdf->Output('D', 'Laporan Riwayat Transaksi Tiket Wisata.pdf');
