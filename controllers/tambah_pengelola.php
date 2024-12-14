<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
include("../config/encryption_helper.php");
include("../config/key.php");

$conn = $koneksi;

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $ket_wisata = mysqli_real_escape_string($conn, $_POST['pilih_untuk_mengelola']); // ID wisata dari dropdown

    // Validasi pola password (kombinasi huruf dan angka)
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,50}$/', $password)) {
    $_SESSION['error'] = "Password harus mengandung huruf, angka, karakter unik, dan panjang antara 8 hingga 50 karakter.";
    header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
    exit;
    }

    // Validasi nomor HP
    if (!preg_match('/^[0-9]{10,15}$/', $no_hp)) {
        $_SESSION['error_konfir'] = "Nomor HP harus terdiri dari angka, panjang minimal 10 karakter dan maksimal 15 karakter.";
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
            mysqli_stmt_close($stmt_check);
            header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
            exit();
        }

        mysqli_stmt_close($stmt_check);
    }

    $encrypted_no_hp = encryptData($no_hp, ENCRYPTION_KEY);

    // Cek apakah nomor HP sudah digunakan
    $query_check_no_hp = "SELECT no_hp FROM user WHERE no_hp = ?";
    if ($stmt_check_no_hp = mysqli_prepare($conn, $query_check_no_hp)) {
        mysqli_stmt_bind_param($stmt_check_no_hp, 's', $encrypted_no_hp);
        mysqli_stmt_execute($stmt_check_no_hp);
        mysqli_stmt_store_result($stmt_check_no_hp);

        if (mysqli_stmt_num_rows($stmt_check_no_hp) > 0) {
            // Jika nomor HP sudah terdaftar
            $_SESSION['error_konfir'] = "Nomor HP sudah digunakan. Silakan gunakan nomor HP lain.";
            mysqli_stmt_close($stmt_check_no_hp);
            header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
            exit();
        }

        mysqli_stmt_close($stmt_check_no_hp);
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
                $query = "INSERT INTO user (email, nama, password, alamat, no_hp, gambar, role, status, ket_wisata) 
                          VALUES (?, ?, ?, ?, ?, ?, 'pengelola', 'active', ?)";

                if ($stmt = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_bind_param($stmt, 'sssssss', $email, $nama, $hashedPassword, $alamat, $encrypted_no_hp, $gambarBaru, $ket_wisata);

                    if (mysqli_stmt_execute($stmt)) {
                        // Ambil ID pengelola yang baru saja dimasukkan
                        $id_pengelola = mysqli_insert_id($conn);

                        // Update tabel detail_wisata
                        $query_update_detail_wisata = "UPDATE detail_wisata 
                                                       SET id_pengelola = ?, no_hp_pengelola = ? 
                                                       WHERE id_wisata = ?";
                        if ($stmt_update = mysqli_prepare($conn, $query_update_detail_wisata)) {
                            mysqli_stmt_bind_param($stmt_update, 'iss', $id_pengelola, $encrypted_no_hp, $ket_wisata);

                            if (mysqli_stmt_execute($stmt_update)) {
                                $_SESSION['success_konfir'] = "Pengelola berhasil ditambahkan dan detail wisata diperbarui.";
                            } else {
                                $_SESSION['error_konfir'] = "Pengelola berhasil ditambahkan, namun detail wisata gagal diperbarui.";
                            }

                            mysqli_stmt_close($stmt_update);
                        } else {
                            $_SESSION['error_konfir'] = "Pengelola berhasil ditambahkan, namun query untuk update detail wisata gagal disiapkan.";
                        }

                        mysqli_stmt_close($stmt);
                        header("Location:" . BASE_URL . "/admin/admin_pengelola.php");
                        exit();
                    } else {
                        $_SESSION['error_konfir'] = "Gagal menambahkan pengelola.";
                        mysqli_stmt_close($stmt);
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
