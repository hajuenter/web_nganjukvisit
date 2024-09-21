<?php

include("../koneksi.php");

$conn = $koneksi;

if (!isset($conn)) {
    die("Koneksi database tidak tersedia.");
}

if (isset($_POST['id_kuliner'])) {
    $id_kuliner = $_POST['id_kuliner'];

    // Query untuk menghapus data berdasarkan id_kuliner
    $sql = "DELETE FROM detail_kuliner WHERE id_kuliner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_kuliner);

    if ($stmt->execute()) {
        header("Location: ../admin/kuliner_admin.php?delete=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
