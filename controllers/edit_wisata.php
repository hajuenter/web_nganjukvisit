<?php
include("../koneksi.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_wisata = $_POST['id_wisata'];
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $jadwal = $_POST['jadwal'];
    $koordinat = $_POST['koordinat'];
    $link_maps = $_POST['link_maps'];

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
            $sql = "UPDATE detail_wisata SET nama_wisata = ?, deskripsi = ?, alamat = ?, harga_tiket = ?, jadwal = ?, gambar = ?, koordinat = ?, link_maps = ? WHERE id_wisata = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssssi', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $gambar, $koordinat, $link_maps, $id_wisata);
        } else {
            echo "Error: Gagal mengunggah gambar.";
            exit();
        }
    } else {
        // Jika tidak ada gambar yang diunggah, tetap update tanpa gambar
        $sql = "UPDATE detail_wisata SET nama_wisata = ?, deskripsi = ?, alamat = ?, harga_tiket = ?, jadwal = ?, koordinat = ?, link_maps = ? WHERE id_wisata = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssi', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $koordinat, $link_maps, $id_wisata);
    }

    if ($stmt->execute()) {
        header("Location: ../admin/wisata_admin.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
