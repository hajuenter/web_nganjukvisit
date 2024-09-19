<?php

include("../koneksi.php");

$conn = $koneksi;

if (!isset($conn)) {
    die("Koneksi database tidak tersedia.");
}

if (isset($_POST['id_wisata'])) {
    $id_wisata = $_POST['id_wisata'];

    // Query untuk menghapus data berdasarkan id_wisata
    $sql = "DELETE FROM detail_wisata WHERE id_wisata = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_wisata);

    if ($stmt->execute()) {
        header("Location: ../admin/wisata_admin.php?delete=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
