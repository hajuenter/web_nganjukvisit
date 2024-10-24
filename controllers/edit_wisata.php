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

    // Ambil data jadwal dari POST dan format jadwal
    $jadwal = $_POST['jadwal'];
    $jadwal_string = '';
    foreach ($jadwal as $hari => $jam) {
        $jam_buka = isset($jam['buka']) ? $jam['buka'] : '';
        $jam_tutup = isset($jam['tutup']) ? $jam['tutup'] : '';
        $jadwal_string .= "$hari: $jam_buka-$jam_tutup, ";
    }
    $jadwal_string = rtrim($jadwal_string, ', ');

    // Proses gambar baru jika ada
    $gambar_baru = '';
    if (isset($_FILES['gambar'])) {
        $gambar_baru_array = [];
        foreach ($_FILES['gambar']['name'] as $key => $nama_gambar_baru) {
            $gambar_tmp = $_FILES['gambar']['tmp_name'][$key];
            $target_dir = "../public/gambar/";
            $target_file = $target_dir . basename($nama_gambar_baru);

            if (move_uploaded_file($gambar_tmp, $target_file)) {
                $gambar_baru_array[] = $nama_gambar_baru;
            }
        }
        $gambar_baru = implode(',', $gambar_baru_array);
        $gambar_baru = trim($gambar_baru, ',');
    }

    // Gabungkan gambar lama dan gambar baru
    $gambar_final = !empty($gambar_baru) ? ($gambar_lama ? $gambar_lama . ',' . $gambar_baru : $gambar_baru) : $gambar_lama;
    $gambar_final = trim($gambar_final, ',');

    // Update data di tabel detail_wisata
    $sql = "UPDATE detail_wisata SET nama_wisata = ?, deskripsi = ?, alamat = ?, harga_tiket = ?, jadwal = ?, gambar = ?, koordinat = ?, link_maps = ? WHERE id_wisata = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssi', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal_string, $gambar_final, $koordinat, $link_maps, $id_wisata);

    if ($stmt->execute()) {
        // Cek apakah id_wisata memiliki tiket di tabel tiket_wisata
        $sql_check_tiket = "SELECT COUNT(*) AS jumlah_tiket FROM tiket_wisata WHERE id_wisata = ?";
        $stmt_check_tiket = $conn->prepare($sql_check_tiket);
        $stmt_check_tiket->bind_param('i', $id_wisata);
        $stmt_check_tiket->execute();
        $result_check_tiket = $stmt_check_tiket->get_result();
        $row_check_tiket = $result_check_tiket->fetch_assoc();

        if ($row_check_tiket['jumlah_tiket'] > 0) {
            // Update nama_wisata dan harga_tiket di tabel tiket_wisata jika ada tiket
            $sql_update_tiket = "UPDATE tiket_wisata SET nama_wisata = ?, harga_tiket = ? WHERE id_wisata = ?";
            $stmt_update_tiket = $conn->prepare($sql_update_tiket);
            $stmt_update_tiket->bind_param('sdi', $nama_wisata, $harga_tiket, $id_wisata);
            $stmt_update_tiket->execute();
            $stmt_update_tiket->close();
        }

        header("Location: ../admin/admin_wisata.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
