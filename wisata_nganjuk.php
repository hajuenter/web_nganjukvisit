<?php
session_start();
include("koneksi.php");
include("./base_url.php");

// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect berdasarkan role pengguna
    if ($_SESSION['role'] === 'admin') {
        header("Location:" . BASE_URL . "/admin/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'pengelola') {
        header("Location:" . BASE_URL . "/pengelola/index.php");
        exit;
    }
}

$conn = $koneksi;

// // Ambil semua data dari tabel detail_wisata
// $query = "SELECT id_wisata, nama_wisata, alamat, harga_tiket, jadwal, deskripsi, gambar FROM detail_wisata";
// $result = mysqli_query($conn, $query);

// $wisata_data = [];

// // Masukkan data ke dalam array
// while ($row = mysqli_fetch_assoc($result)) {
//     // Hapus koma di awal dan di akhir dari string gambar
//     $row['gambar'] = trim($row['gambar'], ',');
//     $wisata_data[] = $row;
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganjuk Visit</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <style>
        /* Styling tombol scroll to top */
        #scrollTopBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99;
            border: 2px solid black;
            padding: 12px;
            border-radius: 50%;
            background-color: white;
            color: black;
            font-size: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
            transition: opacity 0.3s, transform 0.3s;
        }

        /* Hover effect tetap sama */
        #scrollTopBtn:hover {
            background-color: black;
            color: white;
            transform: scale(1.1);
        }

        /* Penyesuaian untuk layar mobile */
        @media (max-width: 768px) {
            #scrollTopBtn {
                width: 40px;
                /* Sesuaikan ukuran pada layar kecil */
                height: 40px;
                bottom: 15px;
                /* Sesuaikan posisi */
                right: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm z-3 fixed-top" style="z-index: 1050;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/logo_nav.png" alt="logo" class="ms-lg-5 img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold ms-lg-5" aria-current="page" href="index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold ms-lg-3" aria-current="page" href="index.php#kategori">Kategori</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold ms-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">Detail</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold" href="wisata_nganjuk.php">Wisata</a></li>
                            <li><a class="dropdown-item fw-semibold" href="kuliner_nganjuk.php">Kuliner</a></li>
                            <li><a class="dropdown-item fw-semibold" href="hotel_nganjuk.php">Penginapan</a></li>
                            <li><a class="dropdown-item fw-semibold" href="event_nganjuk.php">Event</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold ms-lg-3" aria-current="page" href="index.php#tentang_kami">Tentang Kami</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn me-lg-5 btn-outline-primary mt-2 mt-lg-0 mx-auto px-5 px-lg-3">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="container my-5" style="padding-top: 3.8rem;">
        <h2 class="text-center mb-4">Wisata Nganjuk</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/1280x720" class="card-img-top" alt="Kuliner 1">
                    <div class="card-body">
                        <h5 class="card-title">Kuliner 1</h5>
                        <p class="card-text">Deskripsi singkat mengenai kuliner ini. Citarasa yang khas dan unik dari Nganjuk.</p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/1280x720" class="card-img-top" alt="Kuliner 2">
                    <div class="card-body">
                        <h5 class="card-title">Kuliner 2</h5>
                        <p class="card-text">Deskripsi singkat mengenai kuliner ini. Sajian nikmat yang menggugah selera.</p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/1280x720" class="card-img-top" alt="Kuliner 3">
                    <div class="card-body">
                        <h5 class="card-title">Kuliner 3</h5>
                        <p class="card-text">Deskripsi singkat mengenai kuliner ini. Cocok dinikmati bersama keluarga.</p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Tombol Scroll to Top -->
    <button id="scrollTopBtn" class="btn btn-dark">
        <svg class="mx-auto" width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 19V5M12 5L5 12M12 5l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>