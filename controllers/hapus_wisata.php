<?php
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if (isset($_POST['id_wisata'])) {
    $id_wisata = $_POST['id_wisata'];

    // Query untuk mereset ket_wisata pada tabel user sebelum menghapus data wisata
    $query_reset_user = "UPDATE user SET ket_wisata = NULL WHERE ket_wisata = ?";
    $stmt_reset_user = $conn->prepare($query_reset_user);
    $stmt_reset_user->bind_param('i', $id_wisata);
    $stmt_reset_user->execute();
    $stmt_reset_user->close();

    // Query untuk mendapatkan semua gambar berdasarkan id_wisata
    $sql_get_gambar = "SELECT gambar FROM detail_wisata WHERE id_wisata = ?";
    $stmt_get_gambar = $conn->prepare($sql_get_gambar);
    $stmt_get_gambar->bind_param('i', $id_wisata);
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
        $sql_delete = "DELETE FROM detail_wisata WHERE id_wisata = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $id_wisata);

        if ($stmt_delete->execute()) {
            header("Location:" . BASE_URL . "/admin/admin_wisata.php?delete=success");
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
