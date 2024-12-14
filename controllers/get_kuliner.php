<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_kuliner'])) {
    $id_kuliner = $_POST['id_kuliner'];

    // Query untuk mendapatkan data kuliner berdasarkan id_kuliner
    $sql = "SELECT * FROM detail_kuliner WHERE id_kuliner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_kuliner);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Pisahkan nama usaha dan alamat
        $parts = explode(",Alamat:", $row['alamat']);
        $nama_usaha = $parts[0];
        $alamat_lengkap = isset($parts[1]) ? $parts[1] : '';

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_kuliner.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_kuliner" value="' . htmlspecialchars($row['id_kuliner']) . '">
            <div class="mb-3">
                <label for="nama_kuliner" class="form-label">Nama Kuliner</label>
                <input type="text" class="form-control" id="nama_kuliner" name="nama_kuliner" value="' . htmlspecialchars($row['nama_kuliner']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">' . htmlspecialchars($row['deskripsi']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="' . htmlspecialchars($row['harga']) . '">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label for="nama_usaha" class="form-label">Nama Usaha</label>
                <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" value="' . htmlspecialchars($nama_usaha) . '">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="' . htmlspecialchars($alamat_lengkap) . '">
            </div>
            <div class="mb-3">
                <label for="koordinat" class="form-label">Koordinat</label>
                <input type="text" class="form-control" id="koordinat" name="koordinat" value="' . htmlspecialchars($row['koordinat']) . '">
            </div>
            <div class="mb-3">
                <label for="link_maps" class="form-label">Link Maps</label>
                <input type="url" class="form-control" id="link_maps" name="link_maps" value="' . htmlspecialchars($row['link_maps']) . '">
            </div>
        </form>
        ';
    }

    $stmt->close();
}

$conn->close();
