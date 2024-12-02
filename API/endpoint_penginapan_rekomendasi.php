<?php
include '../koneksi.php';

header('Content-Type: application/json');

$query = "SELECT * FROM detail_penginapan ORDER BY total_rating DESC LIMIT 10";
$result = mysqli_query($koneksi, $query);

$penginapan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $penginapan[] = $row;
}

echo json_encode(["status" => "success", "data" => $penginapan]);
?>