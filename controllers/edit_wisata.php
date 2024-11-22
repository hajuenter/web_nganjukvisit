<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wisata = $_POST['id_wisata'];
    $nama_wisata = htmlspecialchars($_POST['nama_wisata']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $harga_tiket = htmlspecialchars($_POST['harga_tiket']);
    $koordinat = htmlspecialchars($_POST['koordinat']);
    $link_maps = htmlspecialchars($_POST['link_maps']);

    if (!preg_match('/^-?([1-8]?[0-9](\.\d+)?|90(\.0+)?),\s?-?(180(\.0+)?|((1[0-7][0-9])|([0-9]?[0-9]))(\.\d+)?)$/', $koordinat)) {
        $_SESSION['error'] = "Koordinat harus dalam format latitude, longitude. Contoh: -6.175392, 106.827153";
        header("Location: " . BASE_URL . "/admin/admin_wisata.php");
        exit();
    }
    $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png'];

    // Dapatkan gambar lama dari database
    $sql_get_gambar = "SELECT gambar FROM detail_wisata WHERE id_wisata = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_wisata);
    $stmt_get_gambar->execute();
    $result = $stmt_get_gambar->get_result();
    $row = $result->fetch_assoc();
    $gambar_lama = trim($row['gambar'], ','); // Hapus koma di awal dan akhir

    // Ambil data jadwal dari POST dan format jadwal
    $jadwal = [];
    foreach ($_POST['jadwal'] as $hari => $jam) {
        $jam_buka = isset($jam['buka']) ? htmlspecialchars($jam['buka']) : '';
        $jam_tutup = isset($jam['tutup']) ? htmlspecialchars($jam['tutup']) : '';
        $jadwal[$hari] = "$jam_buka-$jam_tutup";
    }
    $jadwal_string = implode(', ', array_map(function ($hari, $jam) {
        return "$hari: $jam";
    }, array_keys($jadwal), $jadwal));

    // Proses gambar baru
    $gambar_baru_array = [];
    if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
        foreach ($_FILES['gambar']['name'] as $key => $nama_gambar_baru) {
            $ekstensi_file = strtolower(pathinfo($nama_gambar_baru, PATHINFO_EXTENSION));

            if (!in_array($ekstensi_file, $ekstensi_diperbolehkan)) {
                $_SESSION['error'] = "Format file tidak valid. Hanya jpg, jpeg, dan png yang diperbolehkan.";
                header("Location: " . BASE_URL . "/admin/admin_wisata.php");
                exit();
            }

            if ($_FILES['gambar']['size'][$key] > 2000000) { // Maksimal 2MB
                $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
                header("Location: " . BASE_URL . "/admin/admin_wisata.php");
                exit();
            }

            $unique_name = uniqid() . '_' . basename($nama_gambar_baru);
            $target_file = "../public/gambar/" . $unique_name;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'][$key], $target_file)) {
                $gambar_baru_array[] = $unique_name;
            }
        }
    }

    // Gabungkan gambar lama dan baru
    $gambar_final = implode(',', array_filter(array_merge(explode(',', $gambar_lama), $gambar_baru_array)));


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

        header("Location:" . BASE_URL . "/admin/admin_wisata.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
