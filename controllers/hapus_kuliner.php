<?php
include("../koneksi.php");

$conn = $koneksi;

if (!isset($conn)) {
    die("Koneksi database tidak tersedia.");
}

if (isset($_POST['id_kuliner'])) {
    $id_kuliner = $_POST['id_kuliner'];

    // Query untuk mendapatkan semua gambar berdasarkan id_kuliner
    $sql_get_gambar = "SELECT gambar FROM detail_kuliner WHERE id_kuliner = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_kuliner);
    $stmt_get_gambar->execute();
    $result = $stmt_get_gambar->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gambar = $row['gambar']; // Ambil semua nama gambar yang dipisahkan dengan koma

        // Pisahkan nama-nama gambar menjadi array
        $gambar_array = explode(',', $gambar);

        // Hapus setiap gambar di folder
        foreach ($gambar_array as $gambar_file) {
            $file_path = "../public/gambar/" . $gambar_file;
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar
            }
        }

        // Hapus data dari database
        $sql_delete = "DELETE FROM detail_kuliner WHERE id_kuliner = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $id_kuliner);

        if ($stmt_delete->execute()) {
            header("Location: ../admin/kuliner_admin.php?delete=success");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt_delete->close();
    } else {
        echo "Data tidak ditemukan.";
    }

    $stmt_get_gambar->close();
}

$conn->close();
