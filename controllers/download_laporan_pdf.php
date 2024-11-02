<?php
require '../vendor/autoload.php'; // Memastikan autoload Composer sudah di-load
require_once('../vendor/setasign/fpdf/fpdf.php'); // Memastikan FPDF sudah ter-load

// Koneksi ke database
include('../koneksi.php');
$conn = $koneksi;

// Mendapatkan tanggal dari parameter GET
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : null;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : null;

// Menyiapkan query berdasarkan filter tanggal
if ($tanggal_awal && $tanggal_akhir) {
    $query = "SELECT * FROM riwayat_transaksi_tiket_wisata WHERE tanggal_transaksi BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $tanggal_awal, $tanggal_akhir);
} else {
    // Jika filter tanggal kosong, ambil semua data
    $query = "SELECT * FROM riwayat_transaksi_tiket_wisata";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Inisialisasi objek FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Judul laporan
$pdf->Cell(0, 10, 'Laporan Riwayat Transaksi Tiket Wisata', 0, 1, 'C');
if ($tanggal_awal && $tanggal_akhir) {
    $pdf->Cell(0, 10, "Tanggal: $tanggal_awal sampai $tanggal_akhir", 0, 1, 'C');
} else {
    $pdf->Cell(0, 10, "Semua Data", 0, 1, 'C');
}

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
