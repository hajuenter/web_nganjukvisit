<?php

$host = "127.0.0.1:3306";
$username = "u137138991_B3nganjukvisit";
$password = "v?[=?cQM4T";
$database = "u137138991_nganjukvisit";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "DELETE FROM notifikasi WHERE waktu < NOW() - INTERVAL 7 DAY";

if ($conn->query($sql) === TRUE) {
    echo "Notifikasi lama berhasil dihapus.\n";
} else {
    echo "Error: " . $conn->error . "\n";
}
$conn->close();
?>
