<?php
// Database connection configuration
$host = 'localhost';     // Usually 'localhost' for XAMPP
$username = 'root';      // Default XAMPP MySQL username
$password = '';          // Default XAMPP MySQL password (usually blank)
$database = 'nganjukvisit';  // Replace with your actual database name

// Establish connection
$koneksi = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
