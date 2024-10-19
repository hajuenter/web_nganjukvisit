<?php
// include("koneksi.php");

// $conn = $koneksi;

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
    <title>Event Nganjuk Visit</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
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
                        <a class="nav-link ms-lg-5" aria-current="page" href="index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3" aria-current="page" href="index.php#kategori">Kategori</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">Detail</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="wisata_nganjuk.php">Wisata</a></li>
                            <li><a class="dropdown-item" href="kuliner_nganjuk.php">Kuliner</a></li>
                            <li><a class="dropdown-item" href="hotel_nganjuk.php">Penginapan</a></li>
                            <li><a class="dropdown-item" href="event_nganjuk.php">Event</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3" aria-current="page" href="index.php#tentang_kami">Tentang Kami</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn me-lg-5 btn-outline-primary mt-2 mt-lg-0 mx-auto px-5 px-lg-3">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->


    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>