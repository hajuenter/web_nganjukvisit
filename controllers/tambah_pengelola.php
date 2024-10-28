<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $ket_wisata = mysqli_real_escape_string($conn, $_POST['pilih_untuk_mengelola']); // ID wisata dari dropdown

    // Validasi panjang password dan kombinasi huruf dan angka
    if (strlen($password) < 8 || strlen($password) > 50 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $_SESSION['error_konfir'] = "Password harus memiliki panjang minimal 8 karakter, maksimal 50 karakter, dan harus mengandung huruf dan angka.";
        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
        exit();
    }

    // Cek apakah email sudah digunakan
    $query_check_email = "SELECT email FROM user WHERE email = ?";
    if ($stmt_check = mysqli_prepare($conn, $query_check_email)) {
        mysqli_stmt_bind_param($stmt_check, 's', $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // Jika email sudah terdaftar
            $_SESSION['error_konfir'] = "Email sudah digunakan. Silakan gunakan email lain.";
            mysqli_stmt_close($stmt_check); // Tutup $stmt_check setelah digunakan
            header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
            exit();
        }

        mysqli_stmt_close($stmt_check); // Pastikan ditutup di sini
    }

    // Enkripsi password
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
        $gambarBaru = uniqid() . "." . $gambarExt;
        $targetFile = $targetDir . $gambarBaru;

        // Validasi jenis file gambar
        $allowedExt = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($gambarExt), $allowedExt)) {
            if (move_uploaded_file($gambarTmp, $targetFile)) {
                // Simpan data ke database
                $query = "INSERT INTO user (email, nama, password, alamat, gambar, role, status, ket_wisata) 
                          VALUES (?, ?, ?, ?, ?, 'pengelola', 'active', ?)";

                if ($stmt = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_bind_param($stmt, 'ssssss', $email, $nama, $hashedPassword, $alamat, $gambarBaru, $ket_wisata);

                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['success_konfir'] = "Pengelola berhasil ditambahkan.";
                        mysqli_stmt_close($stmt); // Tutup statement $stmt setelah digunakan
                        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
                        exit();
                    } else {
                        $_SESSION['error_konfir'] = "Gagal menambahkan pengelola.";
                        mysqli_stmt_close($stmt); // Tutup $stmt di sini juga untuk mencegah kebocoran
                        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['error_konfir'] = "Gagal mengupload gambar.";
                header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
                exit();
            }
        } else {
            $_SESSION['error_konfir'] = "Jenis file gambar tidak valid. Hanya jpg, jpeg, dan png yang diperbolehkan.";
            header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
            exit();
        }
    } else {
        $_SESSION['error_konfir'] = "Harap upload gambar yang valid.";
        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
        exit();
    }
}

mysqli_close($conn);
