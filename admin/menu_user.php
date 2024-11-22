<?php
include("../koneksi.php");

$conn = $koneksi;

$pengelolaQuery = "SELECT * FROM user WHERE role = 'user'";
$result = mysqli_query($conn, $pengelolaQuery);
$jumlahUser = mysqli_num_rows($result);
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data User</h1>
    <p class="mb-4">Informasi user Nganjuk Visit</p>
    <div class="mb-3">
        <span class="badge me-3 badge-success py-2 px-3 rounded-pill d-inline">Jumlah Pengguna : <?= $jumlahUser ?></span>
    </div>
    <div class="table-responsive pb-2">
        <!-- alert hapus -->
        <?php
        if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); // Hapus pesan setelah ditampilkan 
            ?>
        <?php endif; ?>

        <?php
        if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); // Hapus pesan setelah ditampilkan 
            ?>
        <?php endif; ?>

        <table id="userTable" class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Id User</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Alamat</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($jumlahUser > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id_user']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                        echo '<td><span class="badge badge-info rounded-pill d-inline">' . htmlspecialchars($row['role']) . '</span></td>';
                        echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                        echo '<td><img src="' . htmlspecialchars($row['gambar']) . '" alt="Gambar" style="width: 45px; height: 45px;" class="rounded-circle"></td>';
                        echo '<td>';
                        echo '<button type="button" class="btn btn-danger btn-sm btn-rounded btn-hapus" data-id="' . htmlspecialchars($row['id_user']) . '" data-toggle="modal" data-target="#hapusModal">
                        <i class="fas fa-trash"></i>
                       </button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">Tidak ada data pengguna.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus -->
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
                <form id="hapusForm" method="post" action="../controllers/hapus_user.php">
                    <input type="hidden" name="id_user" id="id_user">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- JQuery dan Ajax untuk mengambil data -->
<script src="../js/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": false,
            "pageLength": 10,
            "language": {
                "emptyTable": "Tidak ada data pengelola aktif.",
                "zeroRecords": "Tidak ada data pengelola aktif."
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-hapus');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idUser = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idUserField = document.getElementById('id_user');
                idUserField.value = idUser;
            });
        });
    });
</script>