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

    // Ambil data dari form dan sanitasi input
    $nama_penginapan = htmlspecialchars($_POST['nama']);
    $id_user = $_SESSION['user_id']; // Ambil user_id dari session
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = htmlspecialchars($_POST['harga']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $telpon = htmlspecialchars($_POST['telepon']);

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
        $sql = "INSERT INTO detail_penginapan (nama_penginapan, id_user, deskripsi, harga, lokasi, gambar, telepon) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $nama_penginapan, $id_user, $deskripsi, $harga, $lokasi, $gambar_string, $telpon);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location: ../admin/admin_penginapan.php?tambah=success");
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
