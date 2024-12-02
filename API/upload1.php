<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); // Memperbaiki penulisan

include 'koneksi1.php'; // include database connection file

$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

$id_user = $data['id_user']; // Dapatkan ID user dari input JSON
$photo = $data['photo']; // Dapatkan foto dalam format base64 dari input JSON

// Mengecek apakah foto telah diberikan
if (empty($photo)) {
    $errorMSG = json_encode(array("message" => "Please select an image", "status" => false));
    echo $errorMSG;
} else {
    // Menghapus prefix base64 (data:image/png;base64,)
    $photo = str_replace('data:image/png;base64,', '', $photo);
    $photo = str_replace(' ', '+', $photo); // Memperbaiki spasi yang hilang

    // Decode base64 menjadi data binary
    $data = base64_decode($photo);

    // Membuat nama file yang unik
    $fileName = uniqid() . '.png';

    // Tentukan path untuk menyimpan file
    $upload_path = '../public/gambar/' . $fileName;

    // Simpan gambar di folder public/gambar/
    if (file_put_contents($upload_path, $data)) {
        // Update database dengan nama file yang baru
        $query = mysqli_query($koneksi, "UPDATE `user` SET `gambar` = '$fileName' WHERE `id_user` = $id_user");

        if ($query) {
            echo json_encode(array("message" => "Image Uploaded and Profile Updated Successfully", "status" => true));
        } else {
            $errorMSG = json_encode(array("message" => "Failed to update database", "status" => false));
            echo $errorMSG;
        }
    } else {
        $errorMSG = json_encode(array("message" => "Failed to save image", "status" => false));
        echo $errorMSG;
    }
}

?>