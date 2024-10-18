<?php
include("../koneksi.php");
$conn = $koneksi;

// Memulai sesi untuk mendapatkan ID pengguna
session_start();
$id_user = $_SESSION['user_id'];

// Fungsi untuk mengambil data pengguna dari database
function fetchUserData($conn, $id_user)
{
    $mysqlTampil = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($mysqlTampil);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Mengambil data pengguna saat ini
$user = fetchUserData($conn, $id_user);

// Set URL gambar profil
$urlGambar = !empty($user['gambar']) ? "../public/gambar/" . $user['gambar'] : "../public/gambar/avatar_profile.jpg";

// Menangani pengiriman form untuk memperbarui profil dan mengunggah gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = "pengelola";
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    // Validasi apakah email sudah digunakan oleh pengguna lain
    $emailQuery = "SELECT id_user FROM user WHERE email = ? AND id_user != ?";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param("si", $email, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['profile_update'] = "Email sudah digunakan oleh pengguna lain.";
        header("Location: ../pengelola/pengelola_profile.php");
        exit();
    }

    // Proses unggah gambar
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Generate nama file baru untuk menghindari konflik
            $newFileName = $id_user . '_' . time() . '.' . $fileExtension;
            $uploadFileDir = '../public/gambar/';
            $dest_path = $uploadFileDir . $newFileName;

            // Memindahkan file yang diunggah dan memperbarui database
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Hapus gambar lama jika bukan avatar default
                if (!empty($user['gambar']) && $user['gambar'] !== 'avatar_profile.jpg') {
                    $oldFilePath = $uploadFileDir . $user['gambar'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Menghapus gambar lama
                    }
                }

                // Update gambar di database
                $updateGambarQuery = "UPDATE user SET gambar = ? WHERE id_user = ?";
                $stmt = $conn->prepare($updateGambarQuery);
                $stmt->bind_param("si", $newFileName, $id_user);
                $stmt->execute();
                $urlGambar = "../public/gambar/" . $newFileName; // Update URL gambar
            } else {
                echo 'Error moving the uploaded file.';
            }
        } else {
            echo 'Invalid file type. Only JPG, JPEG, and PNG are allowed.';
        }
    }

    // Memperbarui detail pengguna di database
    $updateQuery = "UPDATE user SET nama = ?, role = ?, alamat = ?, email = ? WHERE id_user = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $name, $role, $alamat, $email, $id_user);
    $stmt->execute();

    // Mengambil data pengguna yang sudah diperbarui
    $user = fetchUserData($conn, $id_user);

    // Mengatur pesan berhasil dan mengarahkan ulang
    $_SESSION['profile_update'] = "Profil berhasil diperbarui.";
    header("Location: ../pengelola/pengelola_profile.php");
    exit();
}
