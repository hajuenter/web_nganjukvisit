<?php
session_start(); // Pastikan session dimulai
include("../koneksi.php");
include("../base_url.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan value yang dipilih dari dropdown
    $wisata_data = $_POST['id_wisata'];
    list($id_wisata, $nama_wisata, $harga_tiket) = explode('-', $wisata_data);

    // Mengambil id_user dari session
    $id_user = $_SESSION['user_id'];

    // Mengonversi harga tiket menjadi float
    $harga_tiket = floatval($harga_tiket);

    // Mendapatkan nilai auto_increment berikutnya dari tabel tiket_wisata
    $result = $conn->query("SHOW TABLE STATUS LIKE 'tiket_wisata'");
    $row = $result->fetch_assoc();
    $next_id = $row['Auto_increment'];

    // Buat id_tiket dengan format "NgkWst" diikuti next_id
    $id_tiket = 'NgkWst' . $next_id;

    // Insert data ke tabel tiket_wisata dengan id_tiket yang sudah diformat
    $queryInsert = "INSERT INTO tiket_wisata (id_tiket, id_wisata, nama_wisata, harga_tiket, id_user) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);

    // Bind parameter
    $stmtInsert->bind_param("sisdi", $id_tiket, $id_wisata, $nama_wisata, $harga_tiket, $id_user); // Perbaiki ke "sisdi"

    if ($stmtInsert->execute()) {
        $_SESSION['bagus'] = "Tiket berhasil di tambahkan!";
        header("Location:" . BASE_URL . "/admin/admin_boking_tiket.php");
    } else {
        echo "Error: " . $stmtInsert->error; // Tampilkan pesan error
        exit();
    }
}
