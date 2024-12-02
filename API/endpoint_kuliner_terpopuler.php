<?php
include '../koneksi.php';

header("Content-Type: application/json");

$query = "SELECT * FROM detail_kuliner ORDER BY total_rating DESC LIMIT 10";
$result = mysqli_query($koneksi, $query);

$kuliner = array();
while ($row = mysqli_fetch_assoc($result)) {
    $kuliner[] = $row;
}

echo json_encode(["status" => "success", "data" => $kuliner]);
?>