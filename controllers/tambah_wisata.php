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

    // Ambil data dari form
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = $_POST['deskripsi'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $koordinat = $_POST['koordinat'];
    $link_maps = $_POST['link_maps'];
    $id_user = $_SESSION['user_id']; // Ambil user_id dari session

    // Variabel untuk nama file gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png'];

    // Validasi format koordinat
    if (!preg_match('/^-?([1-8]?[0-9](\.\d+)?|90(\.0+)?),\s?-?(180(\.0+)?|((1[0-7][0-9])|([0-9]?[0-9]))(\.\d+)?)$/', $koordinat)) {
        $_SESSION['error'] = "Koordinat harus dalam format latitude, longitude. Contoh: -6.175392, 106.827153";
        header("Location: " . BASE_URL . "/admin/admin_wisata.php");
        exit();
    }

    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar)) {
        // Tentukan folder tempat menyimpan gambar
        $target_dir = "../public/gambar/";
        $target_files = array();

        // Loop untuk menghandle multiple files
        foreach ($gambar as $key => $value) {
            // Cek ekstensi file
            $ekstensi_file = strtolower(pathinfo($value, PATHINFO_EXTENSION));
            if (!in_array($ekstensi_file, $ekstensi_diperbolehkan)) {
                $_SESSION['error'] = "Format file tidak valid. Hanya diperbolehkan jpg, jpeg, dan png.";
                header("Location: " . BASE_URL . "/admin/admin_wisata.php");
                exit();
            }

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

        // Ambil jadwal buka-tutup dari form dan gabungkan menjadi string
        $jadwal = "Senin: " . $_POST['buka_senin'] . "-" . $_POST['tutup_senin'] . ", " .
            "Selasa: " . $_POST['buka_selasa'] . "-" . $_POST['tutup_selasa'] . ", " .
            "Rabu: " . $_POST['buka_rabu'] . "-" . $_POST['tutup_rabu'] . ", " .
            "Kamis: " . $_POST['buka_kamis'] . "-" . $_POST['tutup_kamis'] . ", " .
            "Jumat: " . $_POST['buka_jumat'] . "-" . $_POST['tutup_jumat'] . ", " .
            "Sabtu: " . $_POST['buka_sabtu'] . "-" . $_POST['tutup_sabtu'] . ", " .
            "Minggu: " . $_POST['buka_minggu'] . "-" . $_POST['tutup_minggu'];

        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO detail_wisata (nama_wisata, deskripsi, alamat, harga_tiket, jadwal, gambar, koordinat, link_maps, id_user) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssss', $nama_wisata, $deskripsi, $alamat, $harga_tiket, $jadwal, $gambar_string, $koordinat, $link_maps, $id_user);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location:" . BASE_URL . "/admin/admin_wisata.php?tambah=success");
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
