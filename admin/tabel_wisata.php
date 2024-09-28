<?php
// Koneksi ke database
include '../koneksi.php';
$conn = $koneksi;

// Ambil query pencarian dari URL (GET method)
$search = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Query untuk menampilkan data (dengan atau tanpa pencarian)
if (!empty($search)) {
    // Pencarian berdasarkan id_wisata atau nama_wisata
    $sql = "SELECT * FROM detail_wisata WHERE id_wisata LIKE ? OR nama_wisata LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Tampilkan semua data jika tidak ada pencarian
    $sql = "SELECT * FROM detail_wisata";
    $result = $conn->query($sql);
}
?>

<div class="container-fluid">
    <!-- alert edit -->
    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- alert tambah -->
    <?php if (isset($_GET['tambah']) && $_GET['tambah'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambah!
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

    <!-- Judul Tabel -->
    <h1 class="h3 mb-2 text-gray-800">Data Wisata</h1>
    <p class="mb-4">Informasi wisata di Kota Nganjuk</p>

    <!-- Tabel Wisata -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold mb-3 text-primary">Tabel Data Wisata</h6>
            <!-- Tombol Tambah -->
            <button class='btn btn-success px-3 ms-lg-4 ms-2' data-bs-toggle="modal" data-bs-target="#modalTambahWisata"><i class="fas fa-plus"></i> Tambah</button>
            <button class='btn btn-info px-3 mt-1 mt-lg-0 ms-lg-4 ms-2' onclick="window.location.href='wisata_admin.php'"><i class="fas fa-sync"></i> Refresh</button>
            <!-- Form Pencarian -->
            <form method="GET" class="form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group px-2 mt-2">
                    <input type="text" name="search_query" class="form-control bg-white border-0 small" placeholder="Cari wisata..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Wisata</th>
                            <th>Nama Wisata</th>
                            <th>Deskripsi</th>
                            <th>Alamat</th>
                            <th>Harga Tiket</th>
                            <th>Jadwal Buka Tutup</th>
                            <th>Gambar</th>
                            <th>Koordinat</th>
                            <th>Maps</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_wisata']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_wisata']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['harga_tiket']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['jadwal']) . "</td>";

                                // Ambil gambar dan pisahkan nama file yang dipisahkan koma menjadi array
                                $gambar_array = explode(',', $row['gambar']);

                                // Pilih satu gambar secara acak dari array
                                $gambar_acak = $gambar_array[array_rand($gambar_array)];

                                // Tampilkan gambar acak
                                echo "<td><img src='../public/gambar/" . htmlspecialchars($gambar_acak) . "' alt='Gambar Acak' style='width:100px;height:auto;'></td>";

                                echo "<td>" . htmlspecialchars($row['koordinat']) . "</td>";
                                echo "<td><a href='" . htmlspecialchars($row['link_maps']) . "' target='_blank'>Lihat di Maps</a></td>";
                                echo "<td>
                                <button class='btn btn-primary btn-edit mb-1' data-id='" . htmlspecialchars($row['id_wisata']) . "' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fas fa-edit'></i> Edit</button> 
                                <button class='btn btn-danger mt-lg-1' data-id='" . htmlspecialchars($row['id_wisata']) . "' data-toggle='modal' data-target='#hapusModal'><i class='fas fa-trash-alt'></i> Hapus</button>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Tidak ada data ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal edit -->
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

<!-- Modal Tambah wisata -->
<div class="modal fade" id="modalTambahWisata" tabindex="-1" aria-labelledby="modalTambahWisataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahWisataLabel">Tambah Data Wisata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controllers/tambah_wisata.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_wisata" class="form-label">Nama Wisata</label>
                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_tiket" class="form-label">Harga Tiket</label>
                        <input type="number" class="form-control" id="harga_tiket" name="harga_tiket" required>
                    </div>
                    <div class="mb-3">
                        <label for="jadwal" class="form-label">Jadwal</label>
                        <input type="text" class="form-control" id="jadwal" name="jadwal" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar[]" multiple required>
                    </div>
                    <div class="mb-3">
                        <label for="koordinat" class="form-label">Koordinat</label>
                        <input type="text" class="form-control" id="koordinat" name="koordinat" required>
                    </div>
                    <div class="mb-3">
                        <label for="link_maps" class="form-label">Link Google Maps</label>
                        <input type="url" class="form-control" id="link_maps" name="link_maps" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
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
                    <input type="hidden" name="id_wisata" id="id_wisata">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>






<!-- JQuery dan Ajax untuk mengambil data -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ambil data untuk edit -->
<script>
    $(document).ready(function() {
        // Event ketika tombol edit di klik
        $('.btn-edit').on('click', function() {
            var id_wisata = $(this).data('id');

            // Mengambil data wisata berdasarkan id_wisata
            $.ajax({
                url: '../controllers/get_wisata.php',
                type: 'POST',
                data: {
                    id_wisata: id_wisata
                },
                success: function(data) {
                    // Tampilkan data yang didapatkan ke dalam modal
                    $('.modal-body-edit').html(data);
                }
            });
        });
    });
</script>

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

<!-- script dari modal hapus ke hapus_wisata.php -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-danger[data-target="#hapusModal"]');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idWisata = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idWisataField = document.getElementById('id_wisata');
                idWisataField.value = idWisata;
                // Set action form ke URL yang sesuai
                const hapusForm = document.getElementById('hapusForm');
                hapusForm.action = '../controllers/hapus_wisata.php';
            });
        });
    });
</script>


<?php
// Tutup koneksi
$conn->close();
?>