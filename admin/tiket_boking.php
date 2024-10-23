<?php
include("../koneksi.php");

$conn = $koneksi;

// Query untuk mengambil semua data dari tabel tiket_wisata
$sqlTiket = "SELECT * FROM tiket_wisata";
$stm = $conn->prepare($sqlTiket);
$stm->execute();
$result = $stm->get_result();

// Query untuk mengambil semua data wisata dari tabel detail_wisata
// dan memastikan wisata yang sudah ada tiketnya tidak ditampilkan
$sqlWisata = "
    SELECT d.id_wisata, d.nama_wisata, d.harga_tiket
    FROM detail_wisata d
    LEFT JOIN tiket_wisata t ON d.id_wisata = t.id_wisata
    WHERE t.id_wisata IS NULL"; // Hanya ambil yang belum ada tiketnya

$stmWisata = $conn->prepare($sqlWisata);
$stmWisata->execute();
$resultWisata = $stmWisata->get_result();

?>

<div class="container-fluid mb-3">
    <h2>Menu Tiket Wisata Nganjuk Visit</h2>
    <hr>
    <!-- Pesan Sukses  -->
    <?php if (isset($_SESSION['bagus'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['bagus']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['bagus']); ?>
        </div>
    <?php endif; ?>

    <!-- gagal gak iso -->
    <?php if (isset($_SESSION['gagal'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['gagal']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['gagal']); ?>
        </div>
    <?php endif; ?>
    
    <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#tambahTiketModal">
        Tambah Tiket Wisata
    </button>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id Tiket</th>
                    <th>Id Wisata</th>
                    <th>Nama Wisata</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_tiket']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_wisata']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_wisata']); ?></td>
                        <td><?php echo htmlspecialchars($row['harga_tiket']); ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="<?php echo $row['id_tiket']; ?>"
                                data-nama="<?php echo $row['nama_wisata']; ?>"
                                data-harga="<?php echo $row['harga_tiket']; ?>">Edit</button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?php echo $row['id_tiket']; ?>">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- set Modal -->
<div class="modal fade" id="tambahTiketModal" tabindex="-1" aria-labelledby="tambahTiketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTiketModalLabel">Tambah Tiket Wisata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controllers/admin_tambah_tiket.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_wisata" class="form-label">Pilih Wisata</label>
                        <select class="form-select" id="id_wisata" name="id_wisata" required>
                            <option value="">Pilih Wisata</option>
                            <?php while ($row = $resultWisata->fetch_assoc()) : ?>
                                <option value="<?php echo $row['id_wisata'] . '-' . $row['nama_wisata'] . '-' . $row['harga_tiket']; ?>">
                                    <?php echo $row['id_wisata'] . ' - ' . $row['nama_wisata'] . ' - Rp' . number_format($row['harga_tiket'], 0, ',', '.'); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Tiket</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controllers/admin_edit_tiket.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_id_tiket" name="id_tiket">
                    <!-- <div class="mb-3">
                        <label for="edit_nama_wisata" class="form-label">Nama Wisata</label>
                        <input type="text" class="form-control" id="edit_nama_wisata" name="nama_wisata" required>
                    </div> -->
                    <div class="mb-3">
                        <label for="edit_harga_tiket" class="form-label">Harga Tiket</label>
                        <input type="number" class="form-control" id="edit_harga_tiket" name="harga_tiket" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controllers/admin_hapus_tiket.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="delete_id_tiket" name="id_tiket">
                    <p>Apakah Anda yakin ingin menghapus tiket ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Event untuk tombol edit
    const editButtons = document.querySelectorAll('button[data-bs-target="#editModal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const idTiket = button.getAttribute('data-id');
            // const namaWisata = button.getAttribute('data-nama');
            const hargaTiket = button.getAttribute('data-harga');

            document.getElementById('edit_id_tiket').value = idTiket;
            // document.getElementById('edit_nama_wisata').value = namaWisata;
            document.getElementById('edit_harga_tiket').value = hargaTiket;
        });
    });

    // Event untuk tombol hapus
    const deleteButtons = document.querySelectorAll('button[data-bs-target="#deleteModal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const idTiket = button.getAttribute('data-id');
            document.getElementById('delete_id_tiket').value = idTiket;
        });
    });
</script>