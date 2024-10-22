<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_penginapan'])) {
    $id_penginapan = $_POST['id_penginapan'];

    // Query untuk mendapatkan data wisata berdasarkan id_penginapan
    $sql = "SELECT * FROM detail_penginapan WHERE id_penginapan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_penginapan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_penginapan.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_penginapan" value="' . htmlspecialchars($row['id_penginapan']) . '">
            <div class="mb-3">
                <label for="nama_penginapan" class="form-label">Nama Wisata</label>
                <input type="text" class="form-control" id="nama_penginapan" name="nama_penginapan" value="' . htmlspecialchars($row['nama_penginapan']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">' . htmlspecialchars($row['deskripsi']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" value="' . htmlspecialchars($row['harga']) . '">
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="' . htmlspecialchars($row['lokasi']) . '">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Penginapan</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="' . htmlspecialchars($row['telepon']) . '">
            </div>
        </form>
        ';
    }
}
