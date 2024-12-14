<?php
function encryptData($data, $key)
{
    $cipher = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = random_bytes($iv_length);
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($encryptedData, $key)
{
    $cipher = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($cipher);
    $data = base64_decode($encryptedData);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
}
