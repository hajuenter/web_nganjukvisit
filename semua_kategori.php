<style>
    .text-justify {
        text-align: justify;
    }

    .carousel-item img {
        width: 100%;
        height: 250px;
        /* Ganti dengan tinggi yang Anda inginkan */
        object-fit: cover;
        /* Gambar akan dipotong untuk mengisi area secara proporsional */
    }

    @media (max-width: 768px) {
        .carousel-item img {
            height: 200px;
            /* Sesuaikan tinggi gambar untuk tampilan mobile */
        }
    }
</style>
<div class="container">
    <!-- Title -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="fs-1" data-aos="zoom-in"
                data-aos-duration="2000">Terpopuler di Kota Nganjuk</h2>
            <p class="mb-0" data-aos="zoom-in"
                data-aos-duration="2500">Beragam Kuliner, Wisata, Penginapan yang ada di Nganjuk</p>
        </div>
    </div>

    <!-- Tabs all -->
    <ul class="nav nav-pills justify-content-center mb-4 px-2 d-flex flex-wrap gap-3" id="course-pills-tab" role="tablist">
        <!-- Tab item kuliner -->
        <li class="nav-item text-center" data-aos="zoom-in"
            data-aos-duration="2100" role="presentation">
            <button class="nav-link mb-2 mb-md-0 active bg-primary" id="course-pills-tab-1" data-bg="bg-primary" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-1" type="button" role="tab" aria-controls="course-pills-tabs-1" aria-selected="true">Kuliner</button>
        </li>
        <!-- Tab item wisata -->
        <li class="nav-item text-center" data-aos="zoom-in"
            data-aos-duration="2200" role="presentation">
            <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2" data-bg="bg-success" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-2" type="button" role="tab" aria-controls="course-pills-tabs-2" aria-selected="false">Wisata</button>
        </li>
        <!-- Tab item hotel -->
        <li class="nav-item text-center" data-aos="zoom-in"
            data-aos-duration="2300" role="presentation">
            <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-3" data-bg="bg-warning" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-3" type="button" role="tab" aria-controls="course-pills-tabs-3" aria-selected="false">Hotel</button>
        </li>
    </ul>
    <!-- Tabs all end -->

    <!-- Tabs isi content all -->
    <div class="tab-content" id="course-pills-tabContent">
        <!-- php fav kuliner -->
        <?php
        include("koneksi.php");
        $conn = $koneksi;

        // Query untuk mengambil data kuliner yang difavoritkan
        $sql = "SELECT dk.id_kuliner, dk.nama_kuliner, dk.deskripsi, dk.gambar FROM detail_kuliner AS dk INNER JOIN fav_kuliner AS fk ON dk.id_kuliner = fk.id_kuliner";
        $result = $conn->query($sql);

        $dataKuliner = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Hapus koma di awal dan di akhir dari string gambar
                $row['gambar'] = trim($row['gambar'], ',');
                $dataKuliner[] = $row;
            }
        }
        $conn->close();
        ?>
        <!-- php fav kuliner end -->

        <!-- Content kuliner -->
        <div class="tab-pane fade active show" id="course-pills-tabs-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
            <div class="row g-4">
                <?php if (!empty($dataKuliner)): ?>
                    <?php foreach ($dataKuliner as $row): ?>
                        <?php
                        // Pisahkan gambar berdasarkan koma
                        $gambarArray = array_filter(explode(',', $row['gambar']));
                        $carouselId = "kulinerSlider-" . $row['id_kuliner']; // ID unik untuk setiap slider
                        ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3" data-aos="zoom-in"
                            data-aos-duration="2600">
                            <div class="card bg-light shadow h-100 hvr-grow">
                                <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($gambarArray as $index => $gambar): ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo "./public/gambar/" . trim($gambar); ?>" class="d-block mx-auto img-fluid" alt="Gambar Kuliner" style="max-height: 200px; object-fit: cover;">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div class="card-body pb-0">
                                    <h5 class="card-title fw-normal">
                                        <a class="text-black text-decoration-none">Nama : <?php echo htmlspecialchars($row['nama_kuliner']); ?></a>
                                    </h5>
                                    <p class="mb-2 text-black text-truncate-2">Deskripsi : <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">Tidak ada data kuliner yang difavoritkan.</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Content kuliner end -->

        <!-- php gae fav wisata -->
        <?php
        include("koneksi.php");
        $conn = $koneksi;

        // Query untuk mengambil data dari detail_wisata yang difavoritkan
        $sql = "SELECT dw.id_wisata, dw.nama_wisata, dw.deskripsi, dw.alamat, dw.gambar FROM detail_wisata AS dw INNER JOIN fav_wisata AS fw ON dw.id_wisata = fw.id_wisata";
        $result = $conn->query($sql);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Hapus koma di awal dan di akhir dari string gambar
                $row['gambar'] = trim($row['gambar'], ',');
                $data[] = $row;
            }
        }
        $conn->close();
        ?>
        <!-- php gae fav wisata end -->

        <!-- content wisata fav -->
        <div class="tab-pane fade" id="course-pills-tabs-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
            <div class="row g-4">
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <?php
                        // Pecah string gambar menjadi array setelah di-trim, dan filter jika ada elemen kosong
                        $gambarArray = array_filter(explode(',', $row['gambar']));
                        $carouselId = "carousel-" . $row['id_wisata']; // Pastikan id unik untuk setiap slider
                        ?>
                        <div class="col-sm-6 col-lg-6 col-xl-6" data-aos="zoom-in"
                            data-aos-duration="2600">
                            <div class="card shadow h-100 hvr-grow">
                                <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($gambarArray as $index => $gambar): ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo "./public/gambar/" . trim($gambar); ?>" class="d-block w-100 img-fluid" alt="Gambar Wisata" style="max-height: 400px; object-fit: cover;">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div class="card-body bg-light pb-2">
                                    <h5 class="card-title fw-normal">
                                        <a href="#" class="text-black text-decoration-none">Nama Wisata : <?php echo htmlspecialchars($row['nama_wisata']); ?></a>
                                    </h5>
                                    <p class="text-truncate-2 text-black mb-2 text-justify">Deskripsi : <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item text-black ms-0 h6 fw-light mb-0">Alamat : <?php echo htmlspecialchars($row['alamat']); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">Tidak ada data</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- content wisata fav end -->

        <!-- php fav hotel -->
        <?php
        include("koneksi.php");
        $conn = $koneksi;

        // Query untuk mengambil data hotel yang difavoritkan
        $sql = "SELECT dh.id_penginapan, dh.nama_penginapan, dh.deskripsi, dh.gambar, dh.lokasi FROM detail_penginapan AS dh INNER JOIN fav_penginapan AS fh ON dh.id_penginapan = fh.id_penginapan";
        $result = $conn->query($sql);

        $dataHotel = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Hapus koma di awal dan di akhir dari string gambar
                $row['gambar'] = trim($row['gambar'], ',');
                $dataHotel[] = $row;
            }
        }
        $conn->close();
        ?>
        <!-- php fav hotel end -->

        <!-- Content hotel -->
        <div class="tab-pane fade" id="course-pills-tabs-3" role="tabpanel" aria-labelledby="course-pills-tab-3">
            <div class="row g-4">
                <?php if (!empty($dataHotel)): ?>
                    <?php foreach ($dataHotel as $row): ?>
                        <?php
                        // Pisahkan gambar berdasarkan koma
                        $gambarArray = array_filter(explode(',', $row['gambar']));
                        $carouselId = "hotelSlider-" . $row['id_penginapan']; // ID unik untuk setiap slider
                        ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3" data-aos="zoom-in"
                            data-aos-duration="2600">
                            <div class="card shadow h-100 hvr-grow">
                                <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($gambarArray as $index => $gambar): ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo "./public/gambar/" . trim($gambar); ?>" class="d-block mx-auto img-fluid" alt="Gambar Hotel" style="max-height: 200px; object-fit: cover;">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <div class="card-body pb-2 bg-light">
                                    <h5 class="card-title fw-normal">
                                        <a class="text-black text-decoration-none">Nama : <?php echo htmlspecialchars($row['nama_penginapan']); ?></a>
                                    </h5>
                                    <p class="mb-2 text-black text-truncate-2">Deskripsi : <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                    <p class="mb-2 text-black text-truncate-2">Alamat : <?php echo htmlspecialchars($row['lokasi']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">Tidak ada data hotel yang tersedia.</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Content hotel end -->

    </div> <!-- Tabs isi content all end -->
</div>

<script>
    document.querySelectorAll('.nav-link').forEach(button => {
        button.addEventListener('shown.bs.tab', function() {
            // Hapus semua kelas bg-* dari tombol tab
            document.querySelectorAll('.nav-link').forEach(btn => {
                btn.classList.remove('bg-primary', 'bg-success', 'bg-warning');
            });

            // Tambahkan kelas bg-* sesuai dengan data-bg dari tombol yang aktif
            this.classList.add(this.getAttribute('data-bg'));
        });
    });
</script>