<?php
require_once 'koneksi.php';

// Cek koneksi
if ($koneksi) {
    echo 'connected';
} else {
    echo 'error';
}
