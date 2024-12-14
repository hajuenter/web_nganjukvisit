<?php
include("../koneksi.php"); // Koneksi database

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan id_wisata dari tabel user berdasarkan user_id
$queryWisata = "SELECT ket_wisata FROM user WHERE id_user = ?";
$stmtWisata = $conn->prepare($queryWisata);
$stmtWisata->bind_param("i", $user_id);
$stmtWisata->execute();
$resultWisata = $stmtWisata->get_result();
$ket_wisata = $resultWisata->fetch_assoc()['ket_wisata'];

// Query untuk mendapatkan detail tiket yang sesuai dengan id_wisata dan status 'diproses'
$sqlq = "SELECT * FROM detail_tiket WHERE status = 'diproses' AND id_wisata = ?";
$stm = $conn->prepare($sqlq);
$stm->bind_param("i", $ket_wisata);
$stm->execute();
$result = $stm->get_result();

// Mengambil hasil query
$hasil = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
    <h1 class="text-center text-black fw-bold">Konfirmasi Pembelian Tiket Wisata</h1>
    <hr>
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
    <p class="text-sm">Data pembelian tiket wisata</p>
    <button class="btn btn-primary mb-2" onclick="window.location.href='pengelola_konfir_tiket.php'" id="refreshButton">
            <i class="fas fa-sync-alt"></i> Refresh
    </button>
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
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($hasil): ?>
                    <?php foreach ($hasil as $row): ?>
                        <tr class="tiket-row" data-status="<?php echo htmlspecialchars($row['status']); ?>">
                            <td><?php echo htmlspecialchars($row['id_detail_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_user']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_wisata']); ?></td>
                            <td><?php echo htmlspecialchars($row['harga']); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form method="POST" action="../controllers/pengelola_aktivasi_pembayaran.php" style="display:inline;">
                                    <input type="hidden" name="id_detail_tiket" value="<?php echo htmlspecialchars($row['id_detail_tiket']); ?>">
                                    <input type="hidden" name="status" value="berhasil">
                                    <button type="submit" name="action" value="update" class="btn btn-success mb-1 mb-lg-0"><i class="fas fa-check"></i></button>
                                </form>
                                <form method="POST" action="../controllers/pengelola_aktivasi_pembayaran.php" style="display:inline;">
                                    <input type="hidden" name="id_detail_tiket" value="<?php echo htmlspecialchars($row['id_detail_tiket']); ?>">
                                    <input type="hidden" name="status" value="gagal">
                                    <button type="submit" name="action" value="update" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>