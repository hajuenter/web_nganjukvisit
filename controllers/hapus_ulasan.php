<?php
include("../koneksi.php");

$conn = $koneksi;
if (isset($_GET['category']) && isset($_GET['id_ulasan'])) {
    $category = $_GET['category'];
    $id_ulasan = $_GET['id_ulasan'];

    // Siapkan query berdasarkan kategori
    $stmt = null;
    if ($category === 'ulasan_wisata') {
        $stmt = $conn->prepare("DELETE FROM ulasan_wisata WHERE id_ulasan_w = ?");
    } elseif ($category === 'ulasan_penginapan') {
        $stmt = $conn->prepare("DELETE FROM ulasan_penginapan WHERE id_ulasan_p = ?");
    } elseif ($category === 'ulasan_kuliner') {
        $stmt = $conn->prepare("DELETE FROM ulasan_kuliner WHERE id_ulasan_k = ?");
    }

    if ($stmt) {
        $stmt->bind_param("i", $id_ulasan); // Menggunakan "i" untuk integer
        if ($stmt->execute()) {
            // Redirect with success parameter
            header("Location: ../admin/admin_ulasan.php?delete=success");
            exit();
        } else {
            // Redirect with failure parameter
            header("Location: ../admin/admin_ulasan.php?delete=failure");
            exit();
        }
    }
} else {
    // Redirect with failure parameter
    header("Location: ../admin/admin_ulasan.php?delete=failure");
    exit();
}

$conn->close();
?>
