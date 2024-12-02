<?php
include '../koneksi.php';

header("Content-Type: application/json");

$query = "SELECT * FROM detail_wisata ORDER BY total_rating DESC LIMIT 10";
$result = mysqli_query($koneksi, $query);

$wisata = array();
while ($row = mysqli_fetch_assoc($result)) {
    $wisata[] = $row;
}

echo json_encode(["status" => "success", "data" => $wisata]);
?>