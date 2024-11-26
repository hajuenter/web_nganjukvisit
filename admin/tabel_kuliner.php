<?php
// Koneksi ke database
include '../koneksi.php';
$conn = $koneksi;

// Ambil query pencarian dari URL (GET method)
$search = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Query untuk menampilkan data (dengan atau tanpa pencarian)
if (!empty($search)) {
    // Pencarian berdasarkan id_kuliner, nama_kuliner, deskripsi, atau harga
    $sql = "SELECT * FROM detail_kuliner 
            WHERE id_kuliner LIKE ? 
            OR nama_kuliner LIKE ? 
            OR deskripsi LIKE ? 
            OR harga LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Tampilkan semua data jika tidak ada pencarian
    $sql = "SELECT * FROM detail_kuliner";
    $result = $conn->query($sql);
}
?>



<div class="container-fluid">

    <!-- Judul tabel kuliner -->
    <h1 class="h3 mb-2 text-gray-800">Data Kuliner</h1>
    <p class="mb-4">Informasi kuliner di Kota Nganjuk</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- alert tambah -->
    <?php if (isset($_GET['tambah']) && $_GET['tambah'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambah!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- alert edit -->
    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- alert hapus -->
    <?php if (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold mb-3 text-primary">Tabel Data Kuliner</h6>
            <!-- Tombol Tambah -->
            <button class='btn btn-success px-3 ms-lg-4 ms-2' data-bs-toggle="modal" data-bs-target="#modalTambahKuliner"><i class="fas fa-plus"></i> Tambah</button>
            <button class='btn btn-info px-3 mt-1 mt-lg-0 ms-lg-4 ms-2' onclick="window.location.href='admin_kuliner.php'"><i class="fas fa-sync"></i> Refresh</button>
            <!-- Form Pencarian -->
            <form method="GET" class="form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group px-2 mt-2">
                    <input type="text" name="search_query" class="form-control bg-white border-0 small" placeholder="Cari kuliner..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive pb-2">
                <table id="kulinerTable" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Kuliner</th>
                            <th>Nama Kuliner</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>Link Maps</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_kuliner']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kuliner']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['harga']) . "</td>";

                                // Pecah gambar menjadi array
                                $gambarArray = explode(',', $row['gambar']);

                                // Pilih satu gambar secara acak
                                $gambarAcak = $gambarArray[array_rand($gambarArray)];

                                // Tampilkan gambar acak
                                echo "<td><img class='img-fluid' src='../public/gambar/" . htmlspecialchars($gambarAcak) . "' alt='Gambar' style='width: 100px; aspect-ratio: 16 / 9;'></td>";
                                echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['koordinat']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['link_maps']) . "</td>";
                                echo "<td class='d-flex flex-column'>
                                <button class='btn btn-primary btn-edit mb-1' data-id='" . htmlspecialchars($row['id_kuliner']) . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                <i class='fas fa-edit'></i>
                                </button> 
                                <button class='btn btn-danger' data-id='" . htmlspecialchars($row['id_kuliner']) . "' data-toggle='modal' data-target='#hapusModal'>
                                <i class='fas fa-trash-alt'></i>
                                </button>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "";
                        }
                        ?>
                    </tbody>
                </table>
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
        $('#kulinerTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": false,
            "pageLength": 10,
            "language": {
                "emptyTable": "Tidak ada data ditemukan",
                "zeroRecords": "Tidak ada data ditemukan"
            }
        });
    });
</script>
<!-- ambil data untuk edit -->
<script>
    $(document).ready(function() {
        // Event ketika tombol edit di klik
        $('.btn-edit').on('click', function() {
            var id_kuliner = $(this).data('id');

            // Mengambil data wisata berdasarkan id_kuliner
            $.ajax({
                url: '../controllers/get_kuliner.php',
                type: 'POST',
                data: {
                    id_kuliner: id_kuliner
                },
                success: function(data) {
                    // Tampilkan data yang didapatkan ke dalam modal
                    $('.modal-body-edit').html(data);
                }
            });
        });
    });
</script>

<!-- Modal Tambah kuliner -->
<div class="modal fade" id="modalTambahKuliner" tabindex="-1" aria-labelledby="modalTambahKulinerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahKulinerLabel">Tambah Data Kuliner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/tambah_kuliner.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_kuliner" class="form-label">Nama Kuliner</label>
                        <input type="text" class="form-control" id="nama_kuliner" name="nama_kuliner" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="koordinat" class="form-label">Koordinat</label>
                        <input type="text" class="form-control" id="koordinat" name="koordinat" required>
                    </div>
                    <div class="mb-3">
                        <label for="link_maps" class="form-label">Link Maps</label>
                        <input type="text" class="form-control" id="link_maps" name="link_maps" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Wisata</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-edit p-2">
                <!-- Data dari Ajax akan dimasukkan ke sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-edit">Edit</button>
            </div>
        </div>
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
                <form id="hapusForm" method="post" action="">
                    <input type="hidden" name="id_kuliner" id="id_kuliner">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- script ketika alert di close url kembali ke semula -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan semua elemen dengan class 'alert-dismissible'
        var alertElement = document.querySelector('.alert-dismissible');

        // Jika ada alert, tambahkan event ketika tombol "X" ditekan
        if (alertElement) {
            alertElement.addEventListener('closed.bs.alert', function() {
                // Hapus parameter dari URL setelah alert ditutup
                var url = new URL(window.location.href);
                url.searchParams.delete('update'); // Hapus parameter 'update'
                url.searchParams.delete('tambah'); // Hapus parameter 'tambah'
                url.searchParams.delete('delete'); // Hapus parameter 'tambah'
                window.history.replaceState(null, null, url.pathname); // Ubah URL tanpa reload
            });
        }
    });
</script>

<!-- script dari modal hapus ke hapus_kuliner.php -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-danger[data-target="#hapusModal"]');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idWisata = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idWisataField = document.getElementById('id_kuliner');
                idWisataField.value = idWisata;
                // Set action form ke URL yang sesuai
                const hapusForm = document.getElementById('hapusForm');
                hapusForm.action = '../controllers/hapus_kuliner.php';
            });
        });
    });
</script>