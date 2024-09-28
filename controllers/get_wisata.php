<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_wisata'])) {
    $id_wisata = $_POST['id_wisata'];

    // Query untuk mendapatkan data wisata berdasarkan id_wisata
    $sql = "SELECT * FROM detail_wisata WHERE id_wisata = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_wisata);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_wisata.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_wisata" value="' . htmlspecialchars($row['id_wisata']) . '">
            <div class="mb-3">
                <label for="nama_wisata" class="form-label">Nama Wisata</label>
                <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" value="' . htmlspecialchars($row['nama_wisata']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">' . htmlspecialchars($row['deskripsi']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="' . htmlspecialchars($row['alamat']) . '">
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="text" class="form-control" id="harga_tiket" name="harga_tiket" value="' . htmlspecialchars($row['harga_tiket']) . '">
            </div>
            <div class="mb-3">
                <label for="jadwal" class="form-label">Jadwal</label>
                <input type="text" class="form-control" id="jadwal" name="jadwal" value="' . htmlspecialchars($row['jadwal']) . '">
            </div>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Wisata</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple>
            </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Koordinat</label>
                <input type="text" class="form-control" id="koordinat" name="koordinat" value="' . htmlspecialchars($row['koordinat']) . '">
            </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Link Maps</label>
                <input type="text" class="form-control" id="link_maps" name="link_maps" value="' . htmlspecialchars($row['link_maps']) . '">
            </div>
        </form>
        ';
    }
}
