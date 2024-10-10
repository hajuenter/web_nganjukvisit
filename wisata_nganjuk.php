<?php
include("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Nganjuk Visit</title>
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
                        <a class="nav-link dropdown-toggle ms-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">Detaill</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="wisata_nganjuk.php">Wisata</a></li>
                            <li><a class="dropdown-item" href="kuliner_nganjuk.php">Kuliner</a></li>
                            <li><a class="dropdown-item" href="hotel_nganjuk.php">Penginapan</a></li>
                            <li><a class="dropdown-item" href="event_nganjuk.php">Event</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3" aria-current="page" href="#tentang_kami">Tentang Kami</a>
                    </li>
                </ul>
                <form class="d-flex me-lg-2" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <div class="d-flex">
                    <a href="login.php" class="btn me-lg-5 btn-outline-primary mt-2 mt-lg-0 mx-auto px-5 px-lg-3">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="container pt-5 mt-5 pt-lg-5 mt-lg-5 mb-3">
        <div class="row">
            <!-- Image Slider -->
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div id="wisataSlider" class="carousel slide mt-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#wisataSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#wisataSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#wisataSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <img src="./public/gambar/lupa_password.drawio.png" class="d-block mx-auto" style="max-width: 80%;" alt="Gambar Wisata 1">
                        </div>
                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <img src="./public/gambar/login.drawio.png" class="d-block mx-auto" style="max-width: 80%;" alt="Gambar Wisata 2">
                        </div>
                        <!-- Slide 3 -->
                        <div class="carousel-item">
                            <img src="./public/gambar/dashboard.drawio.png" class="d-block mx-auto" style="max-width: 80%;" alt="Gambar Wisata 3">
                        </div>
                    </div>
                    <!-- Previous Button -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#wisataSlider" data-bs-slide="prev" style="color: black; font-size: 2rem;">
                        <span class="carousel-control-prev-icon visually-hidden">Prev</span>
                        <span aria-hidden="true">&lt;</span> <!-- Icon "<" -->
                    </button>
                    <!-- Next Button -->
                    <button class="carousel-control-next" type="button" data-bs-target="#wisataSlider" data-bs-slide="next" style="color: black; font-size: 2rem;">
                        <span class="carousel-control-next-icon visually-hidden">Next</span>
                        <span aria-hidden="true">&gt;</span> <!-- Icon ">" -->
                    </button>
                </div>
            </div>

            <!-- Descriptions -->
            <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nama Wisata: Wisata Alam</h5>
                        <p class="card-text"><strong>Alamat:</strong> Jalan Pegunungan, Kota A</p>
                        <p class="card-text"><strong>Jam Operasional:</strong> 08:00 - 17:00</p>
                        <p class="card-text"><strong>Harga Tiket:</strong> Rp 50.000</p>
                        <p class="card-text"><strong>Deskripsi:</strong> Wisata alam ini menawarkan pemandangan yang luar biasa dan udara yang sejuk. Sangat cocok untuk tempat rekreasi bersama keluarga dan teman-teman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>


    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>