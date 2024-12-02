<?php
// Menghubungkan ke database
include '../koneksi.php';
$conn = $koneksi;
$id_user = $_POST['id_user'] ?? '';

if ($id_user) {
    $sql = "SELECT dk.id_kuliner, dk.nama_kuliner, dk.deskripsi 
            FROM fav_kuliner fk
            JOIN detail_kuliner dk ON fk.id_kuliner = dk.id_kuliner
            WHERE fk.id_user = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    $kuliner_favorit = [];
    while ($row = $result->fetch_assoc()) {
        $kuliner_favorit[] = [
            "id_kuliner" => $row['id_kuliner'],
            "nama_kuliner" => $row['nama_kuliner'],
            "deskripsi" => $row['deskripsi']
            // "alamat" => $row['alamat']
        ];
    }

    if (count($kuliner_favorit) > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Kuliner favorit ditemukan",
            "data" => $kuliner_favorit
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Tidak ada kuliner favorit untuk pengguna ini"
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