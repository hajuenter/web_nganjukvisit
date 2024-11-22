<?php
// Koneksi ke database
include '../koneksi.php';
$conn = $koneksi;

// Ambil query pencarian dari URL (GET method)
$search = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Query untuk menampilkan data (dengan atau tanpa pencarian)
if (!empty($search)) {
    // Pencarian berdasarkan id_event, nama, deskripsi_event, atau tanggal_event
    $sql = "SELECT * FROM detail_event 
            WHERE id_event LIKE ? 
            OR nama LIKE ? 
            OR deskripsi_event LIKE ? 
            OR tanggal_event LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Tampilkan semua data jika tidak ada pencarian
    $sql = "SELECT * FROM detail_event";
    $result = $conn->query($sql);
}
?>

<div class="container-fluid">
    <h2>Data Event</h2>
    <p>Informasi event atau acara yang ada di Nganjuk</p>

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

    <form class="input-group mb-2">
        <input type="search" name="search_query" class="form-control form-control-lg" placeholder="Search for something..." aria-label="Search" aria-describedby="button-addon2">
        <button class="btn btn-primary btn-lg" type="submit" id="button-addon2">
            <i class="fas fa-search"></i>
        </button>
    </form>
    <!-- Button for Adding -->
    <button class="btn btn-success btn-md mb-2" type="button" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Add
    </button>
    <!-- Button for Refreshing -->
    <button class="btn btn-warning btn-md ms-2 mb-2" onclick="window.location.href='admin_event.php'" type="button">
        <i class="fas fa-sync-alt"></i> Refresh
    </button>

    <div class="table-responsive pb-2">
        <table id="eventTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Alamat</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_event']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['deskripsi_event']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";

                        // Pecah gambar menjadi array
                        $gambarArray = explode(',', $row['gambar']);

                        // Pilih satu gambar secara acak
                        $gambarAcak = $gambarArray[array_rand($gambarArray)];

                        // Tampilkan gambar acak
                        echo "<td><img class='img-fluid' src='../public/gambar/" . htmlspecialchars($gambarAcak) . "' alt='Gambar' style='width:100px; aspect-ratio: 16 / 9;'></td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_event']) . "</td>";
                        echo "<td class='d-flex flex-column'>
                                <button class='btn btn-primary btn-edit mb-1' data-id='" . htmlspecialchars($row['id_event']) . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                <i class='fas fa-edit'></i>
                                </button> 
                                <button class='btn btn-danger' data-id='" . htmlspecialchars($row['id_event']) . "' data-toggle='modal' data-target='#hapusModal'>
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

<!-- modal tambahhh -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="post" action="../controllers/tambah_event.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Event</label>
                        <textarea class="form-control" id="deskripsi_event" name="deskripsi_event" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar[]" accept="image/*" multiple required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_event" class="form-label">Tanggal Event</label>
                        <input type="date" class="form-control" id="tanggal_event" name="tanggal_event" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="addForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- modal hapus -->
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
                    <input type="hidden" name="id_event" id="id_event">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Hapus</button>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Event</h1>
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

<!-- JQuery dan Ajax untuk mengambil data -->
<script src="../js/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#eventTable').DataTable({
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

<!-- script dari modal hapus ke hapus_eveent.php -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners for the delete buttons
        const btnHapus = document.querySelectorAll('.btn-danger[data-target="#hapusModal"]');

        btnHapus.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ID dari data-id tombol
                const idEvent = this.getAttribute('data-id');
                // Set ID data pada field di formulir modal
                const idEventField = document.getElementById('id_event');
                idEventField.value = idEvent;
                // Set action form ke URL yang sesuai
                const hapusForm = document.getElementById('hapusForm');
                hapusForm.action = '../controllers/hapus_event.php';
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Event ketika tombol edit di klik
        $('.btn-edit').on('click', function() {
            var id_event = $(this).data('id');

            // Mengambil data wisata berdasarkan id_event
            $.ajax({
                url: '../controllers/get_data_event.php',
                type: 'POST',
                data: {
                    id_event: id_event
                },
                success: function(data) {
                    // Tampilkan data yang didapatkan ke dalam modal
                    $('.modal-body-edit').html(data);
                }
            });
        });
    });
</script>