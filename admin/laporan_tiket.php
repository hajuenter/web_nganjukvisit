<?php
$_SESSION['print_token'] = bin2hex(random_bytes(32)); // Membuat token

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
    <h2 class="mb-2">Menu Tiket Laporan Wisata Nganjuk Visit</h2>
    <!-- Win -->
    <?php if (isset($_SESSION['win'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['win']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['win']); ?>
        </div>
    <?php endif; ?>

    <!-- lose -->
    <?php if (isset($_SESSION['lose'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['lose']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['lose']); ?>
        </div>
    <?php endif; ?>

    <div class="mb-2">
        <button class="btn btn-primary mb-1 mb-lg-0" onclick="window.location.href='../controllers/download_laporan_pdf.php'"><i class="fas fa-file-pdf"> Download PDF</i></button>
        <button class="btn btn-primary mb-1 mb-lg-0" onclick="window.location.href='../controllers/download_laporan_excel.php'"><i class="fas fa-file-excel"> Download Excel</i></button>
        <button class="btn btn-primary mb-1 mb-lg-0" onclick="window.location.href='../controllers/download_laporan_csv.php'"><i class="fas fa-file-csv"> Download CSV</i></button>
        <button class="btn btn-primary mb-1 mb-lg-0" onclick="window.open('../controllers/download_laporan_print.php?token=<?php echo $_SESSION['print_token']; ?>', '_blank');"><i class="fas fa-print"></i> Print</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id Riwayat Transaksi</th>
                    <th>Id Detail Tiket</th>
                    <th>Nama Wisata</th>
                    <th>Jumlah Tiket</th>
                    <th>Harga Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
                            <td>
                                <button class="btn btn-danger" data-id="<?php echo htmlspecialchars($row['id_transaksi']); ?>" data-target="#hapusModal" data-toggle="modal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="hapusForm" method="post">
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus riwayat transaksi ini?
                    <input type="hidden" name="id_transaksi" id="id_transaksi">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-danger[data-target="#hapusModal"]');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idWisata = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idTransaksiField = document.getElementById('id_transaksi');
                idTransaksiField.value = idWisata;
                // Set action form ke URL yang sesuai
                const hapusForm = document.getElementById('hapusForm');
                hapusForm.action = '../controllers/hapus_riwayat_wisata.php';
            });
        });
    });
</script>