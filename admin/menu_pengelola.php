<?php
include("../koneksi.php");

$conn = $koneksi;

// Query untuk mengambil data pengelola dengan status active
$pengelolaActiveQuery = "SELECT id_user, email, nama, role, alamat, gambar, status, ket_wisata FROM user WHERE role = 'pengelola' AND status = 'active'";
$resultActive = mysqli_query($conn, $pengelolaActiveQuery);
$jumlahPengelolaActive = mysqli_num_rows($resultActive);

// Query untuk mengambil data pengelola dengan status inactive
$pengelolaInactiveQuery = "SELECT id_user, email, nama, status FROM user WHERE role = 'pengelola' AND status = 'inactive'";
$resultInactive = mysqli_query($conn, $pengelolaInactiveQuery);
$jumlahPengelolaInactive = mysqli_num_rows($resultInactive);
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Pengelola</h1>
    <p class="mb-4">Informasi pengelola Nganjuk Visit</p>

    <?php if (isset($_SESSION['success_konfir'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success_konfir']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['success_konfir']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_konfir'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error_konfir']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php unset($_SESSION['error_konfir']); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <div class="mb-3">
            <span class="badge me-1 badge-info py-2 px-3 rounded-pill d-inline">Jumlah Pengelola Aktif : <?= $jumlahPengelolaActive ?></span>
        </div>
        <span class="badge me-1 badge-warning py-2 px-3 rounded-pill d-inline">Jumlah Pengelola Inaktif : <?= $jumlahPengelolaInactive ?></span>
    </div>
    <div class="mb-2">
        <button class='btn btn-success px-3 ms-2' data-bs-toggle="modal" data-bs-target="#modalTambahPengelola"><i class="fas fa-plus"></i> Tambah</button>
        <button class='btn btn-primary px-3 mt-1 mt-lg-0 ms-lg-2 ms-2' data-bs-toggle="modal" data-bs-target="#modaltabelpengelola"><i class="fas fa-check-circle"></i> Permintaan</button>
        <button class='btn btn-danger px-3 mt-1 mt-lg-0 ms-lg-2 ms-2' onclick="window.location.href='admin_pengelola.php'"><i class="fas fa-sync"></i> Refresh</button>
    </div>

    <!-- Tabel Pengelola Aktif -->
    <div class="table-responsive">
        <table class="table align-middle mb-lg-5 mb-2 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Id Pengelola</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Pengelola Wisata</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($jumlahPengelolaActive > 0) {
                    while ($row = mysqli_fetch_assoc($resultActive)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id_user']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                        echo '<td><span class="badge badge-success rounded-pill py-2 px-3 d-inline">Pengelola</span></td>';
                        echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ket_wisata']) . '</td>';
                        echo '<td><img src="../public/gambar/' . htmlspecialchars($row['gambar']) . '" alt="Gambar" style="width: 45px; height: 45px;" class="rounded-circle"></td>';
                        echo '<td class="d-flex flex-column">';
                        echo '<button class="btn btn-danger mb-1" data-id="' . htmlspecialchars($row['id_user']) . '" data-toggle="modal" data-target="#hapusModal"><i class="fas fa-trash-alt"></i> Hapus</button>';
                        echo '<button class="btn btn-info" data-id="' . htmlspecialchars($row['id_user']) . '" data-bs-toggle="modal" data-bs-target="#modalSetWisata" onclick="setPengelolaId(' . htmlspecialchars($row['id_user']) . ')"><i class="fas fa-map-marker-alt"></i> Set Wisata</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">Tidak ada data pengelola aktif.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Set Wisata -->
<div class="modal fade" id="modalSetWisata" tabindex="-1" aria-labelledby="modalSetWisataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSetWisataLabel">Pilih Wisata untuk Pengelola</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/set_wisata.php" method="POST">
                    <input type="hidden" name="id_pengelola" id="id_pengelola">
                    <div class="mb-3">
                        <label for="wisata" class="form-label">Pilih Wisata</label>
                        <select class="form-control" id="wisata" name="wisata" required>
                            <option value="">Pilih Wisata</option>
                            <?php
                            // Query untuk mengambil id_wisata dan nama_wisata
                            $result = mysqli_query($conn, "SELECT id_wisata, nama_wisata FROM detail_wisata WHERE id_pengelola IS NULL OR id_pengelola = ''");

                            // Loop untuk membuat pilihan dropdown
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id_wisata'] . "'>" . $row['nama_wisata'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Set Wisata</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengelola -->
<div class="modal fade" id="modalTambahPengelola" tabindex="-1" aria-labelledby="modalTambahPengelolaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPengelolaLabel">Tambah Data Pengelola</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/tambah_pengelola.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-primary" type="button" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="pilih_untuk_mengelola" class="form-label">Pilih Wisata untuk Mengelola</label>
                        <select class="form-control" id="pilih_untuk_mengelola" name="pilih_untuk_mengelola" required>
                            <option value="">Pilih Wisata</option>
                            <?php
                            // Koneksi ke database
                            include("../koneksi.php");

                            // Query untuk mengambil id_wisata dan nama_wisata
                            $result = mysqli_query($conn, "SELECT id_wisata, nama_wisata FROM detail_wisata WHERE id_pengelola IS NULL OR id_pengelola = ''");

                            // Loop melalui hasil query dan buat opsi dropdown
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id_wisata'] . "'>" . $row['nama_wisata'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tabel Pengelola Inaktif -->
<div class="modal fade" id="modaltabelpengelola" tabindex="-1" aria-labelledby="modaltabelpengelolaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltabelpengelolaLabel">Detail Permintaan Pengelola In aktif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahPengelolaInactive > 0) {
                            while ($row = mysqli_fetch_assoc($resultInactive)) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td> 
                                    <form action="../controllers/activate_pengelola.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="user_id" value="' . htmlspecialchars($row['id_user']) . '">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                     <form action="../controllers/tolak_pengelola.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id_user" value="' . htmlspecialchars($row['id_user']) . '">
                                    <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i>
                                    </button>
                                    </form>
                                </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-center">Tidak ada data pengelola yang statusnya inactive.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Pengelola -->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah Anda yakin ingin menghapus data ini?</div>
            <div class="modal-footer">
                <form id="hapusForm" method="post" action="">
                    <input type="hidden" name="id_user" id="id_user">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-danger[data-target="#hapusModal"]');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idUser = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idUserField = document.getElementById('id_user'); // Perbaiki di sini
                idUserField.value = idUser;
                // Set action form ke URL yang sesuai
                const hapusForm = document.getElementById('hapusForm');
                hapusForm.action = '../controllers/hapus_pengelola.php';
            });
        });
    });
</script>

<!-- set wisata -->
<script>
    function setPengelolaId(id_pengelola) {
        document.getElementById('id_pengelola').value = id_pengelola;
    }
</script>

<?php
// Tutup koneksi setelah semua data selesai digunakan
mysqli_close($conn);
?>