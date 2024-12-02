<?php
function jsonResponse($status, $message, $data = null)
{
    // Mengatur header respons sebagai JSON
    header('Content-Type: application/json');

    // Struktur respons
    $response = [
        'status' => $status,
        'message' => $message,
    ];

    // Menambahkan data jika ada
    if ($data !== null) {
        $response['data'] = $data;
    }

    // Mengirim respons dalam format JSON
    echo json_encode($response);
    exit;
}
// Fungsi untuk validasi email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) && str_ends_with($email, '@gmail.com');
}

// Fungsi untuk validasi password
function validatePassword($password)
{
    return strlen($password) >= 8 && strlen($password) <= 50 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
}

// Fungsi untuk memeriksa kunci input yang diperbolehkan
function validateInputKeys($inputKeys, $allowedKeys)
{
    foreach ($inputKeys as $key) {
        if (!in_array($key, $allowedKeys)) {
            jsonResponse(false, 'Invalid input key: ' . $key);
        }
    }
}
?>