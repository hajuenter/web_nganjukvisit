<?php
include '../koneksi.php';
$conn = $koneksi;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil notifikasi terbaru yang id_notif lebih besar dari ID terakhir yang diterima
$sql = "SELECT * FROM notifikasi WHERE id_notif > ? ORDER BY waktu DESC";
$stmt = $conn->prepare($sql);

// Ambil ID notifikasi terakhir yang diterima (misalnya, ID dari query parameter)
$lastNotificationId = isset($_GET['lastNotificationId']) ? intval($_GET['lastNotificationId']) : 0;
$stmt->bind_param("i", $lastNotificationId);

$stmt->execute();
$result = $stmt->get_result();

// Menyimpan notifikasi yang ditemukan
$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$conn->close();

// Keluarkan hasilnya sebagai JSON
echo json_encode($notifications);
?>