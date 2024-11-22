<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
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
    $koordinat = htmlspecialchars($_POST['koordinat']);
    $link_maps = htmlspecialchars($_POST['link_maps']);

    // Validasi format koordinat
    if (!preg_match('/^-?([1-8]?[0-9](\.\d+)?|90(\.0+)?),\s?-?(180(\.0+)?|((1[0-7][0-9])|([0-9]?[0-9]))(\.\d+)?)$/', $koordinat)) {
        $_SESSION['error'] = "Koordinat harus dalam format latitude, longitude. Contoh: -6.175392, 106.827153";
        header("Location: " . BASE_URL . "/admin/admin_penginapan.php");
        exit();
    }

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
            // Buat nama file yang unik
            $unique_name = uniqid() . '_' . basename($value); // menambahkan ID unik ke nama file
            $target_file = $target_dir . $unique_name;
            $target_files[] = $unique_name; // Simpan nama file unik ke array

            // Pindahkan file gambar ke folder target
            if (!move_uploaded_file($gambar_tmp[$key], $target_file)) {
                echo "Error: Gagal mengunggah gambar.";
                exit();
            }
        }

        // Gabungkan semua nama file gambar menjadi satu string, dipisahkan oleh koma
        $gambar_string = trim(implode(',', $target_files), ',');

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO detail_penginapan (nama_penginapan, id_user, deskripsi, harga, lokasi, gambar, telepon, koordinat, link_maps) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssss', $nama_penginapan, $id_user, $deskripsi, $harga, $lokasi, $gambar_string, $telpon, $koordinat, $link_maps);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location:" . BASE_URL . "/admin/admin_penginapan.php?tambah=success");
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
