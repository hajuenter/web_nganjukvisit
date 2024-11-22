<?php
session_start();

// Jika menerima request POST untuk tandai notifikasi sebagai sudah dibaca
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['markAsRead'])) {
    // Tidak menghapus data notifikasi dari session, hanya menandai badge sebagai sudah dibaca
    $_SESSION['notifications_read'] = true;

    // Kembalikan respons JSON
    echo json_encode(['success' => true]);
    exit;
}

// Jika bukan request POST, tampilkan error
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
