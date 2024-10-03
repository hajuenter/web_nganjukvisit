<?php
include("../koneksi.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_event = $_POST['id_event'];
    $nama = $_POST['nama'];
    $deskripsi_event = $_POST['deskripsi_event'];

    // Variabel untuk nama file gambar
    $gambar_files = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
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
        $gambar_array = explode(',', $existing_gambar);
    }

    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar_files[0])) { // Cek jika ada setidaknya satu file yang diupload
        // Tentukan folder tempat menyimpan gambar
        $target_dir = "../public/gambar/";

        foreach ($gambar_files as $key => $gambar) {
            $target_file = $target_dir . basename($gambar);

            // Pindahkan file gambar ke folder target
            if (move_uploaded_file($gambar_tmp[$key], $target_file)) {
                // Jika file berhasil diunggah, tambahkan nama file ke array
                $gambar_array[] = $gambar; // Menambahkan gambar baru
            } else {
                echo "Error: Gagal mengunggah gambar.";
                exit();
            }
        }
    }

    // Gabungkan semua nama gambar menjadi string untuk disimpan di database
    $gambar_string = implode(',', $gambar_array);
    $tanggal_event = $_POST['tanggal_event'];
    // Update data kuliner dengan gambar baru dan gambar lama
    $sql = "UPDATE detail_event SET nama = ?, deskripsi_event = ?, gambar = ?, tanggal_event = ? WHERE id_event = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $nama, $deskripsi_event, $gambar_string, $tanggal_event, $id_event);

    if ($stmt->execute()) {
        header("Location: ../admin/admin_event.php?update=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
