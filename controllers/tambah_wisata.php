<?php
session_start();
include("../koneksi.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah user_id ada di session
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User tidak terdaftar. Silakan login terlebih dahulu.";
        exit();
    }

    // Ambil data dari form
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $jadwal = $_POST['jadwal'];
    $koordinat = $_POST['koordinat'];
    $link_maps = $_POST['link_maps'];
    $id_user = $_SESSION['user_id']; // Ambil user_id dari session

    // Variabel untuk nama file gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];

    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar)) {
        // Tentukan folder tempat menyimpan gambar
        $target_dir = "../public/gambar/";
        $target_files = array();

        // Loop untuk menghandle multiple files
        foreach ($gambar as $key => $value) {
            $target_file = $target_dir . basename($value);
            $target_files[] = $value; // Hanya simpan nama file saja di array

            // Pindahkan file gambar ke folder target
            if (!move_uploaded_file($gambar_tmp[$key], $target_file)) {
                echo "Error: Gagal mengunggah gambar.";
                exit();
            }
        }

        // Gabungkan semua nama file gambar menjadi satu string, dipisahkan oleh koma
        $gambar_string = implode(',', $target_files);

        // Hapus koma di awal dan di akhir dari string gambar
        $gambar_string = trim($gambar_string, ',');

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO detail_wisata (nama_wisata, deskripsi, alamat, harga_tiket, jadwal, gambar, koordinat, link_maps, id_user) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssss', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $gambar_string, $koordinat, $link_maps, $id_user);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location: ../admin/admin_wisata.php?tambah=success");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Error: Gambar tidak boleh kosong.";
        exit();
    }
}

$conn->close();
