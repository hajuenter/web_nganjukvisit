<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tiket = $_POST['id_tiket'];
    // $nama_wisata = $_POST['nama_wisata'];
    $harga_tiket = $_POST['harga_tiket'];

    // Update tiket di tabel tiket_wisata
    $queryUpdateTiket = "UPDATE tiket_wisata SET harga_tiket = ? WHERE id_tiket = ?";
    $stmtUpdateTiket = $conn->prepare($queryUpdateTiket);
    $stmtUpdateTiket->bind_param("is", $harga_tiket, $id_tiket);

    // Eksekusi update tiket
    if ($stmtUpdateTiket->execute()) {
        // Update harga_tiket di tabel detail_wisata
        // Asumsikan id_wisata diambil dari id_tiket
        $queryUpdateDetailWisata = "UPDATE detail_wisata SET harga_tiket = ? WHERE id_wisata = (SELECT id_wisata FROM tiket_wisata WHERE id_tiket = ?)";
        $stmtUpdateDetailWisata = $conn->prepare($queryUpdateDetailWisata);
        $stmtUpdateDetailWisata->bind_param("is", $harga_tiket, $id_tiket);

        if ($stmtUpdateDetailWisata->execute()) {
            $_SESSION['bagus'] = "Tiket berhasil di perbarui!";
            header("Location:" . BASE_URL . "/admin/admin_boking_tiket.php");
        } else {
            $_SESSION['gagal'] = "Tiket tidak berhasil di perbarui!";
            header("Location:" . BASE_URL . "/admin/admin_boking_tiket.php");
        }
    } else {
        $_SESSION['gagal'] = "Error brooo!";
        header("Location:" . BASE_URL . "/admin/admin_boking_tiket.php");
    }

    exit();
}
