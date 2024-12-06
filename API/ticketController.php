<?php
include '../koneksi.php';
$conn = $koneksi;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan tiket yang statusnya berhasil
$sql = "SELECT * FROM detail_tiket WHERE status = 'berhasil'";
$result = $conn->query($sql);

// Membuat array untuk menyimpan tiket yang diperbarui
$updatedTickets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $updatedTickets[] = $row; // Menyimpan tiket yang statusnya berhasil
    }
}

$conn->close();

// Keluarkan hasilnya sebagai JSON
echo json_encode($updatedTickets);
?>