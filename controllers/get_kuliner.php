<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_kuliner'])) {
    $id_kuliner = $_POST['id_kuliner'];

    // Query untuk mendapatkan data wisata berdasarkan id_kuliner
    $sql = "SELECT * FROM detail_kuliner WHERE id_kuliner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_kuliner);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_kuliner.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_kuliner" value="' . htmlspecialchars($row['id_kuliner']) . '">
            <div class="mb-3">
                <label for="nama_kuliner" class="form-label">Nama Wisata</label>
                <input type="text" class="form-control" id="nama_kuliner" name="nama_kuliner" value="' . htmlspecialchars($row['nama_kuliner']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">' . htmlspecialchars($row['deskripsi']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="text" class="form-control" id="harga" name="harga" value="' . htmlspecialchars($row['harga']) . '">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Wisata</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple>
            </div>
        </form>
        ';
    }
}
