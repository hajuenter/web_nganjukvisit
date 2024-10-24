<?php
include("../koneksi.php"); // Koneksi database

$conn = $koneksi;

// Mengambil data riwayat transaksi tiket wisata
$sqlq = "SELECT * FROM riwayat_transaksi_tiket_wisata";
$stm = $conn->prepare($sqlq);
$stm->execute();
$result = $stm->get_result(); // Mengambil hasil query

$riwayat = $result->fetch_all(MYSQLI_ASSOC); // Mendapatkan semua hasil sebagai array
?>

<div class="container-fluid mb-3">
    <h2>Menu Tiket Laporan Wisata Nganjuk Visit</h2>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id Detail Tiket</th>
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
                        <td colspan="6" class="text-center">Tidak ada data tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>