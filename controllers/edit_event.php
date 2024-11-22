<?php
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_event = $_POST['id_event'];
    $nama = htmlspecialchars($_POST['nama']);
    $deskripsi_event = htmlspecialchars($_POST['deskripsi_event']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $tanggal_event = $_POST['tanggal_event'];

    // Variabel untuk nama file gambar
    $gambar_array = [];

    // Ambil gambar yang sudah ada di database
    $sql_get_gambar = "SELECT gambar FROM detail_event WHERE id_event = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_event);
    $stmt_get_gambar->execute();
    $stmt_get_gambar->bind_result($existing_gambar);
    $stmt_get_gambar->fetch();
    $stmt_get_gambar->close();

    // Jika ada gambar yang sudah ada, pisahkan menjadi array
    if ($existing_gambar) {
        $gambar_array = explode(',', trim($existing_gambar, ','));
    }

    // Cek apakah ada gambar yang diunggah
    if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
        $gambar_files = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];

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
                echo "Error: Gagal mengunggah gambar " . htmlspecialchars($gambar);
                exit();
            }
        }
    }

    // Gabungkan semua nama gambar menjadi string untuk disimpan di database
    $gambar_string = implode(',', $gambar_array);

    // Update data event dengan gambar baru dan gambar lama
    $sql = "UPDATE detail_event SET nama = ?, deskripsi_event = ?, alamat = ?, gambar = ?, tanggal_event = ? WHERE id_event = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $nama, $deskripsi_event, $alamat, $gambar_string, $tanggal_event, $id_event);

    if ($stmt->execute()) {
        header("Location:" . BASE_URL . "/admin/admin_event.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
