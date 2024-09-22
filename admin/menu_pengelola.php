<?php
include("../koneksi.php");

$conn = $koneksi;

$pengelolaQuery = "SELECT * FROM user WHERE role = 'pengelola'";
$result = mysqli_query($conn, $pengelolaQuery);
$jumlahPengelola = mysqli_num_rows($result); // Count the number of rows
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Pengelola</h1>
    <p class="mb-4">Informasi pengelola Nganjuk Visit</p>
    <div class="mb-3">
        <span class="badge me-3 badge-danger py-2 px-3 rounded-pill d-inline">Jumlah Pengelola : <?= $jumlahPengelola ?></span>
    </div>
    <div class="mb-2">
        <button class='btn btn-success px-3 ms-2' data-bs-toggle="modal" data-bs-target="#modalTambahPengelola">Tambah</button>
        <button class='btn btn-info px-3 mt-1 mt-lg-0 ms-lg-2 ms-2' onclick="window.location.href='admin_pengelola.php'">Refresh</button>
    </div>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
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
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td><span class="badge badge-success rounded-pill py-2 px-3 d-inline">' . htmlspecialchars($row['role']) . '</span></td>';
                    echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['gambar']) . '" alt="Gambar" style="width: 45px; height: 45px;" class="rounded-circle"></td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-link btn-sm btn-rounded">Edit</button>';
                    echo '<button type="button" class="btn btn-link btn-sm btn-rounded">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">Tidak ada data pengelola.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php
mysqli_close($conn);
?>

<!-- JQuery dan Ajax untuk mengambil data -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal Tambah pengelola -->
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
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>