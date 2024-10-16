<?php
include("koneksi.php");

$conn = $koneksi;

// Ambil semua data dari tabel detail_wisata
$query = "SELECT id_wisata, nama_wisata, alamat, harga_tiket, jadwal, deskripsi, gambar FROM detail_wisata";
$result = mysqli_query($conn, $query);

$wisata_data = [];

// Masukkan data ke dalam array
while ($row = mysqli_fetch_assoc($result)) {
    // Hapus koma di awal dan di akhir dari string gambar
    $row['gambar'] = trim($row['gambar'], ',');
    $wisata_data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Nganjuk Visit</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(-45deg, #FFE0B2, #FFCCBC, #B2DFDB, #FFF9C4);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: 100px;">
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

    <div class="container mb-3" style="margin-top: 8rem;">
        <div class="row g-5">
            <?php foreach ($wisata_data as $wisata): ?>
                <?php
                // Pisahkan gambar berdasarkan koma
                $gambar_array = explode(',', $wisata['gambar']);
                $id_wisata = $wisata['id_wisata'];
                ?>

                <!-- Card untuk setiap id_wisata -->
                <div class="col-lg-6 col-md-6 mb-1 col-sm-12">
                    <div class="card shadow-lg border-0 h-100" style="background-color: #f5f5f5; border-radius: 15px; overflow: hidden;">
                        <!-- Slider Gambar -->
                        <div id="wisataSlider<?= $id_wisata ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <?php foreach ($gambar_array as $index => $gambar): ?>
                                    <button type="button" data-bs-target="#wisataSlider<?= $id_wisata ?>" data-bs-slide-to="<?= $index ?>" class="<?= $index == 0 ? 'active' : '' ?>" aria-current="<?= $index == 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
                                <?php endforeach; ?>
                            </div>
                            <div class="carousel-inner" style="border-radius: 15px;">
                                <?php foreach ($gambar_array as $index => $gambar): ?>
                                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                        <img src="./public/gambar/<?= trim($gambar) ?>" class="d-block w-100" style="aspect-ratio: 16/9; object-fit: cover; max-width: 1280px;" alt="Gambar Wisata <?= $id_wisata ?> - <?= $index + 1 ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#wisataSlider<?= $id_wisata ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#wisataSlider<?= $id_wisata ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <!-- Deskripsi Wisata -->
                        <div class="card-body">
                            <h5 class="card-title text-success">Nama Wisata : <?= htmlspecialchars($wisata['nama_wisata']) ?></h5>
                            <p class="card-text"><i class="bi bi-geo-alt-fill text-danger">Alamat :</i> <?= htmlspecialchars($wisata['alamat']) ?></p>
                            <p class="card-text"><i class="bi bi-clock-fill text-primary">Jam Operasioal :</i> <?= htmlspecialchars($wisata['jadwal']) ?></p>
                            <p class="card-text"><i class="bi bi-currency-dollar text-warning">Harga Tiket :</i> Rp <?= number_format($wisata['harga_tiket'], 0, ',', '.') ?></p>
                            <p class="card-text">Deskripsi : <?= htmlspecialchars($wisata['deskripsi']) ?></p>
                            <a href="#" class="btn btn-success btn-sm mt-2" style="transition: transform 0.2s;">Explore More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>



    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>