<?php
include('../koneksi.php'); // Koneksi ke database

$conn = $koneksi;

// Mengambil data riwayat transaksi tiket wisata
$sqlq = "SELECT * FROM riwayat_transaksi_tiket_wisata";
$stm = $conn->prepare($sqlq);
$stm->execute();
$result = $stm->get_result(); // Mengambil hasil query

$riwayat = $result->fetch_all(MYSQLI_ASSOC); // Mendapatkan semua hasil sebagai array
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan Riwayat Transaksi Tiket Wisata</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Sesuaikan dengan path file CSS Bootstrap Anda -->
    <style>
        /* Gaya untuk tabel cetak */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            .print-hide {
                display: none;
                /* Menyembunyikan tombol print saat mencetak */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Laporan Riwayat Transaksi Tiket Wisata</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID Detail Tiket</th>
                    <th>Nama Wisata</th>
                    <th>Jumlah Tiket</th>
                    <th>Harga Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($riwayat): ?>
                    <?php foreach ($riwayat as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_detail_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_wisata']); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['harga_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button onclick="window.print();" class="btn btn-primary print-hide">Print</button>
    </div>
</body>

</html>