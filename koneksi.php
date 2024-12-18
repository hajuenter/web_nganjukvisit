<?php
require_once 'config/config.php';

// Mengambil konfigurasi maintenance
$maintenanceConfig = require 'maintenance_access.php';

// Cek status maintenance
if ($maintenanceConfig['maintenance_mode']) {
    // Jika maintenance mode aktif, arahkan ke halaman error_koneksi.php
    header("Location: maintenance.php");
    exit();
}

try {
    // Koneksi ke database
    $koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Cek koneksi
    if (!$koneksi) {
        throw new Exception("Koneksi gagal: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log error ke file atau sistem logging
    error_log($e->getMessage(), 3, 'logs/error.log');

    header("Location: error_db.php");
    exit();
}
