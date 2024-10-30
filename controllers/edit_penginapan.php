<?php
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_penginapan = $_POST['id_penginapan'];
    $nama_penginapan = htmlspecialchars($_POST['nama_penginapan']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = htmlspecialchars($_POST['harga']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $telepon = htmlspecialchars($_POST['telepon']);

    // Variabel untuk nama file gambar
    $gambar_files = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_array = [];

    // Ambil gambar yang sudah ada di database
    $sql_get_gambar = "SELECT gambar FROM detail_penginapan WHERE id_penginapan = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_penginapan);
    $stmt_get_gambar->execute();
    $stmt_get_gambar->bind_result($existing_gambar);
    $stmt_get_gambar->fetch();
    $stmt_get_gambar->close();

    // Jika ada gambar yang sudah ada, pisahkan menjadi array
    if ($existing_gambar) {
        $gambar_array = explode(',', trim($existing_gambar, ','));
    }

    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar_files[0])) {
        // Tentukan folder tempat menyimpan gambar
        $target_dir = "../public/gambar/";

        foreach ($gambar_files as $key => $gambar) {
            // Buat nama file unik
            $unique_name = uniqid() . '_' . basename($gambar);
            $target_file = $target_dir . $unique_name;

            // Pindahkan file gambar ke folder target
            if (move_uploaded_file($gambar_tmp[$key], $target_file)) {
                // Jika file berhasil diunggah, tambahkan nama file ke array
                $gambar_array[] = $unique_name; // Simpan nama file unik
            } else {
                echo "Error: Gagal mengunggah gambar.";
                exit();
            }
        }
    }

    // Gabungkan semua nama gambar menjadi string untuk disimpan di database, dan pastikan tidak ada koma di awal/akhir
    $gambar_string = trim(implode(',', $gambar_array), ',');

    // Update data penginapan dengan gambar baru dan gambar lama
    $sql = "UPDATE detail_penginapan SET nama_penginapan = ?, deskripsi = ?, harga = ?, lokasi = ?, gambar = ?, telepon = ? WHERE id_penginapan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssi', $nama_penginapan, $deskripsi, $harga, $lokasi, $gambar_string, $telepon, $id_penginapan);

    if ($stmt->execute()) {
        header("Location:" . BASE_URL . "/admin/admin_penginapan.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
