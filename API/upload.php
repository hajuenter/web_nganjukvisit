<?php

include "../koneksi.php";

$action = htmlspecialchars($_POST['action']);

$response = array("success" => FALSE);

if ($action == "multipart") {
    if ($_FILES["photo"]["error"] > 0) {
        $response["success"] = FALSE;
        $response["message"] = "Upload Failed";
    } else {
        $name_file = htmlspecialchars($_FILES['photo']['name']);

        if (@getimagesize($_FILES["photo"]["tmp_name"]) !== false) {

            move_uploaded_file($_FILES["photo"]["tmp_name"], "../public/gambar/" . $name_file);

            $response["success"] = TRUE;
            $response["message"] = "Upload Successfull";

        } else {
            $response["success"] = FALSE;
            $response["message"] = "Upload Failed";
        }

        echo json_encode($response);
    }
} else if ($action == "base64") {
    $idUser = $_POST["id_user"];
    $photo = htmlspecialchars($_POST["photo"]);

    // Menghapus prefix base64 (data:image/png;base64,)
    $photo = str_replace('data:image/png;base64,', '', $photo);
    $photo = str_replace(' ', '+', $photo);

    // Decode base64 menjadi data binary
    $data = base64_decode($photo);

    // Menghasilkan nama file yang unik
    $file = uniqid() . '.png';

    // Tentukan path untuk menyimpan file
    $filePath = "../public/gambar/" . $file;

    // Simpan gambar dan update database
    if (file_put_contents($filePath, $data)) {
        // Panggil fungsi untuk memperbarui gambar di database dengan nama file yang benar
        $response = updateUserImage($idUser, $file);
    } else {
        $response = array("status" => "error", "message" => "Gagal menyimpan file");
    }

    // Kirim respons JSON
    echo json_encode($response);
}

function updateUserImage($idUser, $file)
{
    global $koneksi;

    $sqlqueryupload = "UPDATE `user` SET `gambar` = '$file' WHERE `user`.`id_user` = $idUser";
    if ($koneksi->query($sqlqueryupload)) {
        return array("status" => "success", "message" => $file);
    } else {
        return array("status" => "error", "message" => "Gagal mengupdate database");
    }
}

?>