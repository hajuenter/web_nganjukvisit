<?php
session_start();
include("../koneksi.php");

$conn = $koneksi;

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaWisata = $_POST['namaWisata'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $jadwal = $_POST['jadwal'];
    $koordinat = $_POST['koordinat'];
    $link_maps = $_POST['link_maps'];
    $id_wisata = $_POST['id_wisata'];

    // Memeriksa apakah ada file gambar yang diunggah
    $gambar_baru = [];
    if (!empty($_FILES['gambar']['name'][0])) {
        $target_dir = "../public/gambar/";
        foreach ($_FILES['gambar']['name'] as $key => $file_name) {
            $file_tmp = $_FILES['gambar']['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_name_new = uniqid() . '.' . $file_ext;
            $target_file = $target_dir . $file_name_new;

            // Pindahkan file ke direktori tujuan
            if (move_uploaded_file($file_tmp, $target_file)) {
                $gambar_baru[] = $file_name_new;
            }
        }
    }

    // Ambil gambar lama dari database
    $query_gambar_lama = "SELECT gambar FROM detail_wisata WHERE id_wisata = ?";
    $stmt_gambar_lama = $conn->prepare($query_gambar_lama);
    $stmt_gambar_lama->bind_param("i", $id_wisata);
    $stmt_gambar_lama->execute();
    $result_gambar_lama = $stmt_gambar_lama->get_result();
    $row_gambar_lama = $result_gambar_lama->fetch_assoc();
    $gambar_lama = explode(',', $row_gambar_lama['gambar']);

    // Jika ada gambar baru, gabungkan gambar lama dan baru
    $gambar_terbaru = array_merge($gambar_lama, $gambar_baru);
    $gambar_terbaru_string = implode(',', $gambar_terbaru);

    // Hapus koma di awal dan di akhir string gambar
    $gambar_terbaru_string = trim($gambar_terbaru_string, ',');

    // Update data wisata
    $query_update = "
        UPDATE detail_wisata 
        SET nama_wisata = ?, deskripsi = ?, alamat = ?, harga_tiket = ?, jadwal = ?, koordinat = ?, link_maps = ?, gambar = ?
        WHERE id_wisata = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ssssssssi", $namaWisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $koordinat, $link_maps, $gambar_terbaru_string, $id_wisata);

    if ($stmt_update->execute()) {
        // Redirect ke halaman sukses atau tampilkan pesan sukses
        $_SESSION['berhasil'] = "Data wisata berhasil diperbarui.";
        header("Location: ../pengelola/index.php");
        exit();
    } else {
        // Tampilkan pesan error jika update gagal
        $_SESSION['gagal'] = "Terjadi kesalahan saat memperbarui data wisata.";
        header("Location: ../pengelola/index.php");
        exit();
    }
}
