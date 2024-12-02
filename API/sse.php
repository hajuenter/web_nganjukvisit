<?php
// Mengatur header untuk SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Memastikan eksekusi tidak berhenti
set_time_limit(0);

// Konfigurasi database
$host = "localhost"; // Ganti dengan nama host Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "nganjuknew"; // Ganti dengan nama database Anda

// Buat koneksi ke database MySQL
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$previousCount = 0;

while (true) {
    // Query untuk menghitung jumlah entri dengan status "berhasil"
    $sql = "SELECT COUNT(*) AS count FROM tiket_wisata WHERE status = 'berhasil'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $currentCount = (int) $row['count'];

    if ($currentCount > $previousCount) {
        echo "data: Ada entri baru dengan status berhasil\n\n";
        flush();
        $previousCount = $currentCount;
    }

    // Kirim heartbeat setiap 30 detik
    echo "event: heartbeat\n";
    echo "data: masih terhubung\n\n";
    flush();

    sleep(5); // Tunggu 5 detik sebelum memeriksa lagi
}
?>