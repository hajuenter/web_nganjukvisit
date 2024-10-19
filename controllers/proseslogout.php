<?php
session_start();
session_unset(); // Hapus semua variabel session
session_destroy(); // Hancurkan session
header("Location: /nganjukvisit/login.php"); // Redirect ke halaman login
exit;
