<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_event'])) {
    $id_event = $_POST['id_event'];

    // Query untuk mendapatkan data wisata berdasarkan id_event
    $sql = "SELECT * FROM detail_event WHERE id_event = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_event);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_event.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_event" value="' . htmlspecialchars($row['id_event']) . '">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Event</label>
                <input type="text" class="form-control" id="nama" name="nama" value="' . htmlspecialchars($row['nama']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi_event" class="form-label">Deskripsi Event</label>
                <textarea class="form-control" id="deskripsi_event" name="deskripsi_event">' . htmlspecialchars($row['deskripsi_event']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="' . htmlspecialchars($row['alamat']) . '">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Event</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label for="tanggal_event" class="form-label">Tanggal Event</label>
                <input type="date" class="form-control" id="tanggal_event" name="tanggal_event" value="' . htmlspecialchars($row['tanggal_event']) . '">
            </div>
        </form>
        ';
    }
}
