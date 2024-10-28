<?php
session_start();
session_unset(); // Hapus semua variabel session
session_destroy();
include("../base_url.php");
header("Location:" . BASE_URL . "/login.php"); // Redirect ke halaman login
exit;
