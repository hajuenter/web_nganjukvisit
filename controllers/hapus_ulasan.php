<?php
include("../koneksi.php");
include("../base_url.php");

$conn = $koneksi;

if (isset($_GET['category']) && isset($_GET['id_ulasan'])) {
    $category = $_GET['category'];
    $id_ulasan = $_GET['id_ulasan'];

    // Validasi kategori yang diizinkan
    $allowedCategories = ['ulasan_wisata', 'ulasan_penginapan'];
    if (!in_array($category, $allowedCategories)) {
        header("Location:" . BASE_URL . "/admin/admin_ulasan.php?delete=failure");
        exit();
    }

    // Siapkan query berdasarkan kategori
    $stmt = null;
    if ($category === 'ulasan_wisata') {
        $stmt = $conn->prepare("DELETE FROM ulasan_wisata WHERE id_ulasan_w = ?");
    } elseif ($category === 'ulasan_penginapan') {
        $stmt = $conn->prepare("DELETE FROM ulasan_penginapan WHERE id_ulasan_p = ?");
    }

    if ($stmt) {
        $stmt->bind_param("i", $id_ulasan); // Menggunakan "i" untuk integer
        if ($stmt->execute()) {
            // Redirect dengan parameter sukses
            header("Location:" . BASE_URL . "/admin/admin_ulasan.php?delete=success");
            exit();
        } else {
            // Redirect dengan parameter gagal
            header("Location:" . BASE_URL . "/admin/admin_ulasan.php?delete=failure");
            exit();
        }
    }
} else {
    // Redirect dengan parameter gagal
    header("Location:" . BASE_URL . "/admin/admin_ulasan.php?delete=failure");
    exit();
}

$conn->close();
