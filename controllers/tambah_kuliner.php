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
    $nama_kuliner = $_POST['nama_kuliner'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
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

        // Gabungkan semua nama file gambar menjadi satu string, dipisahkan oleh koma, dan hapus koma di awal/akhir
        $gambar_string = trim(implode(',', $target_files), ',');

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO detail_kuliner (nama_kuliner, deskripsi, harga, gambar, id_user) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $nama_kuliner, $deskripsi, $harga, $gambar_string, $id_user);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location: ../admin/admin_kuliner.php?tambah=success");
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
?>
