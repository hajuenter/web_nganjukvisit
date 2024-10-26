<?php
require '../vendor/autoload.php'; // Memastikan autoload Composer sudah di-load

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database
include('../koneksi.php');
$conn = $koneksi;

// Query untuk mengambil data laporan dari tabel `riwayat_transaksi_tiket_wisata`
$query = "SELECT * FROM riwayat_transaksi_tiket_wisata";
$result = $conn->query($query);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menulis header kolom
$sheet->setCellValue('A1', 'ID Transaksi');
$sheet->setCellValue('B1', 'ID Detail Tiket');
$sheet->setCellValue('C1', 'Nama Wisata');
$sheet->setCellValue('D1', 'Jumlah Tiket');
$sheet->setCellValue('E1', 'Harga Tiket');
$sheet->setCellValue('F1', 'Total');
$sheet->setCellValue('G1', 'Status');

// Menulis data ke dalam spreadsheet mulai dari baris ke-2
$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['id_transaksi']);
    $sheet->setCellValue('B' . $rowNum, $row['id_detail_tiket']);
    $sheet->setCellValue('C' . $rowNum, $row['nama_wisata']);
    $sheet->setCellValue('D' . $rowNum, $row['jumlah_tiket']);
    $sheet->setCellValue('E' . $rowNum, $row['harga_tiket']);
    $sheet->setCellValue('F' . $rowNum, $row['total']);
    $sheet->setCellValue('G' . $rowNum, $row['status']);
    $rowNum++;
}

// Membuat file Excel dan menulis ke output
$writer = new Xlsx($spreadsheet);

// Set nama file
$fileName = 'Laporan_Riwayat_Transaksi_Tiket_Wisata.xlsx';

// Mengirim header HTTP agar file terdownload
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Menulis file ke output
$writer->save('php://output');

// Menutup koneksi database
$conn->close();
