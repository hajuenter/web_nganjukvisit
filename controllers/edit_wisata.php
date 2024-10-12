<?php
include("../koneksi.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wisata = $_POST['id_wisata'];
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $jadwal = $_POST['jadwal'];
    $koordinat = $_POST['koordinat'];
    $link_maps = $_POST['link_maps'];

    // Dapatkan gambar lama dari database
    $sql_get_gambar = "SELECT gambar FROM detail_wisata WHERE id_wisata = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_wisata);
    $stmt_get_gambar->execute();
    $result = $stmt_get_gambar->get_result();
    $row = $result->fetch_assoc();
    $gambar_lama = trim($row['gambar'], ','); // Hapus koma di awal dan akhir

    // Variabel untuk nama file gambar baru
    $gambar_baru = '';
    if (isset($_FILES['gambar'])) {
        $gambar_baru_array = [];
        foreach ($_FILES['gambar']['name'] as $key => $nama_gambar_baru) {
            $gambar_tmp = $_FILES['gambar']['tmp_name'][$key];
            $target_dir = "../public/gambar/";
            $target_file = $target_dir . basename($nama_gambar_baru);

            // Pindahkan file gambar ke folder target
            if (move_uploaded_file($gambar_tmp, $target_file)) {
                $gambar_baru_array[] = $nama_gambar_baru;
            }
        }
        $gambar_baru = implode(',', $gambar_baru_array); // Gabungkan gambar baru jadi satu string
        $gambar_baru = trim($gambar_baru, ','); // Hapus koma di awal dan akhir
    }

    // Gabungkan gambar lama dan gambar baru
    if (!empty($gambar_baru)) {
        $gambar_final = $gambar_lama ? $gambar_lama . ',' . $gambar_baru : $gambar_baru;
    } else {
        $gambar_final = $gambar_lama;
    }

    // Hapus koma di awal dan akhir dari gambar_final
    $gambar_final = trim($gambar_final, ',');

    // Update data di database
    $sql = "UPDATE detail_wisata SET nama_wisata = ?, deskripsi = ?, alamat = ?, harga_tiket = ?, jadwal = ?, gambar = ?, koordinat = ?, link_maps = ? WHERE id_wisata = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssi', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $gambar_final, $koordinat, $link_maps, $id_wisata);

    if ($stmt->execute()) {
        header("Location: ../admin/admin_wisata.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
