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
    $nama = $_POST['nama'];
    $id_user = $_SESSION['user_id']; // Ambil user_id dari session
    $deskripsi_event = $_POST['deskripsi_event'];
    $alamat = $_POST['alamat'];

    // Variabel untuk nama file gambar
    $gambar = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png'];

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
                header("Location: " . BASE_URL . "/admin/admin_event.php");
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

        // Gabungkan semua nama file gambar menjadi satu string, dipisahkan oleh koma, dan trim jika ada koma di awal atau akhir
        $gambar_string = trim(implode(',', $target_files), ',');

        $tanggal_event = $_POST['tanggal_event'];
        // Query untuk menyimpan data ke database
        $sql = "INSERT INTO detail_event (nama, id_user, deskripsi_event, alamat, gambar, tanggal_event) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $nama, $id_user, $deskripsi_event, $alamat, $gambar_string, $tanggal_event);

        if ($stmt->execute()) {
            // Redirect ke halaman admin dengan pesan sukses
            header("Location:" . BASE_URL . "/admin/admin_event.php?tambah=success");
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
