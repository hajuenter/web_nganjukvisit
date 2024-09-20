<?php
include("../koneksi.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_kuliner = $_POST['id_kuliner'];
    $nama_kuliner = $_POST['nama_kuliner'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Variabel untuk nama file gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];

    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar)) {
        // Tentukan folder tempat menyimpan gambar
        $target_dir = "../public/gambar/";
        $target_file = $target_dir . basename($gambar);

        // Pindahkan file gambar ke folder target
        if (move_uploaded_file($gambar_tmp, $target_file)) {
            // Jika file berhasil diunggah, simpan nama file ke database
            $sql = "UPDATE detail_kuliner SET nama_kuliner = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id_kuliner = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $nama_kuliner, $deskripsi, $harga, $gambar, $id_kuliner);
        } else {
            echo "Error: Gagal mengunggah gambar.";
            exit();
        }
    } else {
        // Jika tidak ada gambar yang diunggah, tetap update tanpa gambar
        $sql = "UPDATE detail_kuliner SET nama_kuliner = ?, deskripsi = ?, harga = ? WHERE id_kuliner = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nama_kuliner, $deskripsi, $harga, $id_kuliner);
    }

    if ($stmt->execute()) {
        header("Location: ../admin/kuliner_admin.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
