<?php
// Menghubungkan ke database
include '../koneksi.php';
$conn = $koneksi;

header('Content-Type: application/json');

// Memeriksa metode request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambahkan wisata favorit
    $id_user = $_POST['id_user'] ?? '';
    $id_wisata = $_POST['id_wisata'] ?? '';

    if ($id_user && $id_wisata) {
        // Query untuk menambahkan favorit
        $sql = "INSERT INTO fav_wisata (id_user, id_wisata) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_user, $id_wisata);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Wisata berhasil ditambahkan ke favorit"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menambahkan wisata ke favorit"
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID pengguna dan ID wisata harus disediakan"
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil daftar wisata favorit
    $id_user = $_GET['id_user'] ?? '';

    if ($id_user) {
        // Query untuk mengambil daftar wisata favorit
        $sql = "SELECT dw.id_wisata, dw.nama_wisata, dw.deskripsi, dw.alamat 
                FROM fav_wisata fw
                JOIN detail_wisata dw ON fw.id_wisata = dw.id_wisata
                WHERE fw.id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();

        $wisata_favorit = [];
        while ($row = $result->fetch_assoc()) {
            $wisata_favorit[] = [
                "id_wisata" => $row['id_wisata'],
                "nama_wisata" => $row['nama_wisata'],
                "deskripsi" => $row['deskripsi'],
                "alamat" => $row['alamat']
            ];
        }

        if (count($wisata_favorit) > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Wisata favorit ditemukan",
                "data" => $wisata_favorit
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Tidak ada wisata favorit untuk pengguna ini"
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "ID pengguna harus disediakan"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Metode request tidak valid"
    ]);
}

// Menutup koneksi
$conn->close();
?>