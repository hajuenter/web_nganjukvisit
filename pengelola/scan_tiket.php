<?php
include("../koneksi.php");

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan ket_wisata dari user
$queryWisata = "SELECT ket_wisata FROM user WHERE id_user = ?";
$stmtWisata = $conn->prepare($queryWisata);
$stmtWisata->bind_param("i", $user_id);
$stmtWisata->execute();
$resultWisata = $stmtWisata->get_result();
$ket_wisata = $resultWisata->fetch_assoc()['ket_wisata'];

// Query untuk mendapatkan tiket yang belum kadaluarsa (status 'berhasil' dan sesuai id_wisata)
$sqlq = "SELECT * FROM detail_tiket 
         WHERE status = 'berhasil' 
         AND tanggal >= CURDATE() 
         AND id_wisata = ?";
$stm = $conn->prepare($sqlq);
$stm->bind_param("i", $ket_wisata);
$stm->execute();
$result = $stm->get_result();

// Mengambil hasil query
$hasil = $result->fetch_all(MYSQLI_ASSOC);

// Query untuk mendapatkan tiket kadaluarsa
$sqlExpired = "SELECT * FROM detail_tiket 
               WHERE status = 'berhasil' 
               AND tanggal < CURDATE() 
               AND id_wisata = ?";
$stmtExpired = $conn->prepare($sqlExpired);
$stmtExpired->bind_param("i", $ket_wisata);
$stmtExpired->execute();
$resultExpired = $stmtExpired->get_result();
$expiredTickets = $resultExpired->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
    <h1 class="text-center text-black fw-bold">Scan Tiket Wisata</h1>
    <hr>
    <h5>Data Tiket Aktif</h5>
    <button class="btn btn-primary mb-2" onclick="window.location.href='pengelola_scan_tiket.php'" id="refreshButton">
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
                    <th>Bayar</th>
                    <th>Tanggal</th>
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
                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
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
    
    <div class="table-responsive mt-5">
        <h5>Data Tiket Kadaluarsa</h5>
        <table class="table table-bordered" id="expiredTable" width="100%" cellspacing="0">
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
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($expiredTickets): ?>
                    <?php foreach ($expiredTickets as $ticket): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ticket['id_detail_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['id_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['id_user']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['id_wisata']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['harga']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['jumlah']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['total']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['bayar']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['status']); ?></td>
                            <td>
                                <form method="POST" action="../controllers/hapus_tiket_kadaluarsa.php">
                                    <input type="hidden" name="id_detail_tiket" value="<?php echo htmlspecialchars($ticket['id_detail_tiket']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada tiket kadaluarsa</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="row justify-content-center mt-5 mb-3">
        <div class="col-md-6">
            <form id="scanForm" method="POST" onsubmit="return prosesScan(event);">
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

    <!-- Container untuk menampilkan informasi tiket -->
    <div id="tiketInfo" class="mt-4"></div>
</div>

<script>
    function prosesScan(event) {
        event.preventDefault(); // Mencegah form submit normal

        let barcodeInput = document.getElementById("barcodeInput").value;

        fetch('../controllers/proses_scan_tiket.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'barcodeInput=' + encodeURIComponent(barcodeInput)
            })
            .then(response => response.json())
            .then(data => {
                let tiketInfo = document.getElementById('tiketInfo');
                if (data.success) {
                    tiketInfo.innerHTML = `
                <div class="alert alert-success">
                    <h5>${data.message}</h5>
                    <p><strong>Tiket Wisata:</strong> ${data.nama_wisata}</p>
                    <p><strong>Harga:</strong> ${data.harga}</p>
                    <p><strong>Jumlah Tiket:</strong> ${data.jumlah}</p>
                    <p><strong>Total:</strong> ${data.total}</p>
                </div>`;
                } else {
                    tiketInfo.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('tiketInfo').innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
    }
</script>