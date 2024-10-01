<?php
// Koneksi ke database
include '../koneksi.php';
$conn = $koneksi;

// Ambil query pencarian dari URL (GET method)
$search = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Query untuk menampilkan data (dengan atau tanpa pencarian)
if (!empty($search)) {
    // Pencarian berdasarkan id_wisata atau nama_wisata
    $sql = "SELECT * FROM detail_penginapan WHERE id_penginapan LIKE ? OR nama_penginapan LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Tampilkan semua data jika tidak ada pencarian
    $sql = "SELECT * FROM detail_penginapan";
    $result = $conn->query($sql);
}
?>

<div class="container-fluid">
    <h2>Data Penginapan</h2>
    <p>Informasi penginapan atau hotel yang ada di kawasan Nganjuk</p>
    <form method="get" class="input-group mb-2">
        <input type="search" name="search_query" class="form-control form-control-lg" placeholder="Search for something..." aria-label="Search" aria-describedby="button-addon2">
        <button class="btn btn-primary btn-lg" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
    </form>
    <!-- Button for Adding -->
    <button class="btn btn-success btn-md mb-2" type="button" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Add
    </button>
    <!-- Button for Refreshing -->
    <button class="btn btn-warning btn-md ms-2 mb-2" onclick="window.location.href='admin_penginapan.php'" type="button">
        <i class="fas fa-sync-alt"></i> Refresh
    </button>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Lokasi</th>
                    <th>Gambar</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_penginapan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_penginapan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['harga']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";

                        // Pecah gambar menjadi array
                        $gambarArray = explode(',', $row['gambar']);

                        // Pilih satu gambar secara acak
                        $gambarAcak = $gambarArray[array_rand($gambarArray)];

                        // Tampilkan gambar acak
                        echo "<td><img class='img-fluid' src='../public/gambar/" . htmlspecialchars($gambarAcak) . "' alt='Gambar' style='width:100px;'></td>";
                        echo "<td>" . htmlspecialchars($row['telepon']) . "</td>";
                        echo "<td>
                                <button class='btn btn-primary btn-edit mb-1 mb-lg-1' data-id='" . htmlspecialchars($row['id_penginapan']) . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                <i class='fas fa-edit'></i> Edit
                                </button> 
                                <button class='btn btn-danger' data-id='" . htmlspecialchars($row['id_penginapan']) . "' data-toggle='modal' data-target='#hapusModal'>
                                <i class='fas fa-trash-alt'></i> Hapus
                                </button>
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

<!-- modal tambahhh -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Penginapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
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
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon" required>
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