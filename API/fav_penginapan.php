<?php
// Menghubungkan ke database
include '../koneksi.php';
$conn = $koneksi;
$id_user = $_POST['id_user'] ?? '';

if ($id_user) {
    $sql = "SELECT dp.id_penginapan, dp.nama_penginapan, dp.deskripsi, dp.lokasi 
            FROM fav_penginapan fp
            JOIN detail_penginapan dp ON fp.id_penginapan = dp.id_penginapan
            WHERE fp.id_user = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    $penginapan_favorit = [];
    while ($row = $result->fetch_assoc()) {
        $penginapan_favorit[] = [
            "id_penginapan" => $row['id_penginapan'],
            "nama_penginapan" => $row['nama_penginapan'],
            "deskripsi" => $row['deskripsi'],
            "lokasi" => $row['lokasi']
        ];
    }

    if (count($penginapan_favorit) > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Penginapan favorit ditemukan",
            "data" => $penginapan_favorit
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Tidak ada penginapan favorit untuk pengguna ini"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "ID pengguna harus disediakan"
    ]);
}

// Menutup koneksi
$conn->close();
?>