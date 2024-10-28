<?php
session_start();
include("../koneksi.php");
include("../base_url.php");

$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    $getUserQuery = "SELECT gambar FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($getUserQuery);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (!empty($user['gambar']) && $user['gambar'] !== 'avatar_profile.jpg') {
            $filePath = "../public/gambar/" . $user['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $deleteQuery = "DELETE FROM user WHERE id_user = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id_user);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Data berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus user.";
        }
    } else {
        $_SESSION['error'] = "User tidak ditemukan.";
    }

    header("Location:" . BASE_URL . "/admin/admin_user.php");
    exit();
}
