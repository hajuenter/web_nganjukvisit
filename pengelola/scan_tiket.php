<?php
include("../koneksi.php"); // Koneksi database

$conn = $koneksi;

// Mendapatkan data tiket dengan status 'berhasil' dan masih berlaku (dalam 24 jam)
$sqlq = "SELECT * FROM detail_tiket WHERE status = 'berhasil' AND waktu_konfirmasi >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$stm = $conn->prepare($sqlq);
$stm->execute();
$result = $stm->get_result();
$hasil = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
    <h1 class="text-center text-black fw-bold">Scan Tiket Wisata</h1>
    <hr>
    <p class="text-sm">Data tiket yang masih aktif</p>
    <?php if (isset($_SESSION['berhasil'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['berhasil']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['berhasil']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id Detail Tiket</th>
                    <th>Id Tiket</th>
                    <th>Id User</th>
                    <th>Id Wisata</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($hasil): ?>
                    <?php foreach ($hasil as $row): ?>
                        <tr class="tiket-row">
                            <td><?php echo htmlspecialchars($row['id_detail_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_user']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_wisata']); ?></td>
                            <td><?php echo htmlspecialchars($row['harga']); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                            <td><?php echo htmlspecialchars($row['bayar']); ?></td>
                            <td><?php echo htmlspecialchars($row['kembalian']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada tiket yang berlaku</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <form action="../controllers/proses_scan_tiket.php" method="POST">
                <div class="mb-3">
                    <label for="barcodeInput" class="form-label">Scan Barcode Tiket</label>
                    <input type="text" class="form-control" id="barcodeInput" name="barcodeInput" placeholder="Scan barcode disini" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Proses Scan</button>
                </div>
            </form>
        </div>
    </div>
</div>