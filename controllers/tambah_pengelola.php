<?php
session_start();
// Include file koneksi database
include("../koneksi.php");

$conn = $koneksi;

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Validasi panjang password dan kombinasi huruf dan angka
    if (strlen($password) < 8 || strlen($password) > 50 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $_SESSION['error_konfir'] = "Password harus memiliki panjang minimal 8 karakter, maksimal 50 karakter, dan harus mengandung huruf dan angka.";
        header("Location: ../admin/admin_pengelola.php");
        exit();
    }

    // Enkripsi password (gunakan password_hash untuk keamanan)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah ada gambar yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $gambar = $_FILES['gambar'];

        // Ambil informasi file gambar
        $gambarNama = $gambar['name'];
        $gambarTmp = $gambar['tmp_name'];
        $gambarUkuran = $gambar['size'];
        $gambarExt = pathinfo($gambarNama, PATHINFO_EXTENSION);

        // Tentukan lokasi penyimpanan gambar
        $targetDir = "../public/gambar/";
        $gambarBaru = uniqid() . "." . $gambarExt; // Generate nama unik untuk file gambar
        $targetFile = $targetDir . $gambarBaru;

        // Validasi jenis file gambar (hanya jpg, jpeg, png yang diizinkan)
        $allowedExt = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($gambarExt), $allowedExt)) {
            // Pindahkan file gambar ke folder tujuan
            if (move_uploaded_file($gambarTmp, $targetFile)) {
                // Jika gambar berhasil diupload, lanjutkan dengan menyimpan data ke database
                $query = "INSERT INTO user (email, nama, password, alamat, gambar, role, status) VALUES (?, ?, ?, ?, ?, 'pengelola', 'active')";

                // Persiapan statement
                if ($stmt = mysqli_prepare($conn, $query)) {
                    // Bind parameter ke query
                    mysqli_stmt_bind_param($stmt, 'sssss', $email, $nama, $hashedPassword, $alamat, $gambarBaru);

                    // Eksekusi query
                    if (mysqli_stmt_execute($stmt)) {
                        // Jika berhasil, redirect ke halaman sebelumnya dengan pesan sukses
                        $_SESSION['success_konfir'] = "Pengelola berhasil ditambahkan.";
                        header("Location: ../admin/admin_pengelola.php");
                        exit();
                    } else {
                        // Jika terjadi error pada query
                        $_SESSION['error_konfir'] = "Gagal menambahkan pengelola. Silakan coba lagi.";
                        header("Location: ../admin/admin_pengelola.php");
                        exit();
                    }
                } else {
                    // Jika terjadi error pada persiapan query
                    $_SESSION['error_konfir'] = "Terjadi kesalahan pada server. Silakan coba lagi.";
                    header("Location: ../admin/admin_pengelola.php");
                    exit();
                }

                // Tutup statement
                mysqli_stmt_close($stmt);
            } else {
                // Jika gagal memindahkan file gambar
                $_SESSION['error_konfir'] = "Gagal mengupload gambar.";
                header("Location: ../admin/admin_pengelola.php");
                exit();
            }
        } else {
            // Jika jenis file tidak diizinkan
            $_SESSION['error_konfir'] = "Jenis file gambar tidak valid. Hanya jpg, jpeg, dan png yang diperbolehkan.";
            header("Location: ../admin/admin_pengelola.php");
            exit();
        }
    } else {
        // Jika gambar tidak diupload atau terjadi error
        $_SESSION['error_konfir'] = "Harap upload gambar yang valid.";
        header("Location: ../admin/admin_pengelola.php");
        exit();
    }
}

// Tutup koneksi
mysqli_close($conn);
