<style>
    .text-justify {
        text-align: justify;
    }
</style>
<div class="container">
    <!-- Title -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="fs-1">Terpopuler di Kota Nganjuk</h2>
            <p class="mb-0">Beragam Kuliner, Wisata, Penginapan yang ada di Mganjuk</p>
        </div>
    </div>

    <!-- Tabs all -->
    <ul class="nav nav-pills justify-content-center mb-4 px-2 d-flex flex-wrap gap-3" id="course-pills-tab" role="tablist">
        <!-- Tab item kuliner -->
        <li class="nav-item text-center" role="presentation">
            <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-1" type="button" role="tab" aria-controls="course-pills-tabs-1" aria-selected="true">Kuliner</button>
        </li>
        <!-- Tab item wisata -->
        <li class="nav-item text-center" role="presentation">
            <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-2" type="button" role="tab" aria-controls="course-pills-tabs-2" aria-selected="false" tabindex="-1">Wisata</button>
        </li>
        <!-- Tab item hotel -->
        <li class="nav-item text-center" role="presentation">
            <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-3" data-bs-toggle="pill" data-bs-target="#course-pills-tabs-3" type="button" role="tab" aria-controls="course-pills-tabs-3" aria-selected="false" tabindex="-1">Hotel</button>
        </li>
    </ul>
    <!-- Tabs all end -->

    <!-- Tabs isi content all -->
    <div class="tab-content" id="course-pills-tabContent">

        <!-- Content kuliner -->
        <div class="tab-pane fade active show" id="course-pills-tabs-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
            <div class="row g-4">
                <!-- Card item kuliner -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card shadow h-100">
                        <!-- Image kuliner -->
                        <img src="./img/nasipecel.jpg" class="card-img-top" alt="course image">
                        <!-- Card body -->
                        <div class="card-body pb-0">
                            <!-- Title -->
                            <h5 class="card-title fw-normal"><a href="#">Nasi Pecel Goat</a></h5>
                            <p class="mb-2 text-truncate-2">Sebuah hidangan makanan yang berupa nasi dibalut dengan sambal kacang</p>
                            <!-- Rating star -->
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item ms-0 h6 fw-light mb-0">4.0/5.0</li>
                            </ul>
                        </div>
                        <!-- Card footer -->
                        <div class="card-footer pt-0 pb-3">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>12h 56m</span>
                                <span class="h6 fw-light mb-0"><i class="fas fa-table text-orange me-2"></i>15 lectures</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card item kuliner end -->

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card shadow h-100">
                        <!-- Image kuliner -->
                        <img src="./img/nasipecel.jpg" class="card-img-top" alt="course image">
                        <!-- Card body -->
                        <div class="card-body pb-0">
                            <!-- Title -->
                            <h5 class="card-title fw-normal"><a href="#">Sayur Asem</a></h5>
                            <p class="mb-2 text-truncate-2">Makanan sehat dengan kandungan yang bergizi dan tentunya enak</p>
                            <!-- Rating star -->
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item ms-0 h6 fw-light mb-0">4.0/5.0</li>
                            </ul>
                        </div>
                        <!-- Card footer -->
                        <div class="card-footer pt-0 pb-3">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>12h 56m</span>
                                <span class="h6 fw-light mb-0"><i class="fas fa-table text-orange me-2"></i>15 lectures</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- hh -->
            </div>
        </div>
        <!-- Content kuliner end -->

        <?php
        include("koneksi.php");
        $conn = $koneksi;

        // Query untuk mengambil data
        $sql = "SELECT nama_wisata, deskripsi, alamat, harga_tiket, jadwal, gambar FROM detail_wisata";
        $result = $conn->query($sql);

        $data = [];
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
        $conn->close();
        ?>

        <!-- Content wisata -->
        <div class="tab-pane fade" id="course-pills-tabs-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
            <div class="row g-4">
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <?php $gambar = "./public/gambar/" . $row['gambar']; ?>
                        <div class="col-sm-6 col-lg-6 col-xl-6">
                            <div class="card shadow h-100">
                                <img src="<?php echo $gambar; ?>" class="card-img-top" alt="course image">
                                <div class="card-body pb-0">
                                    <h5 class="card-title fw-normal"><a href="#" class="text-black text-decoration-none"><?php echo $row['nama_wisata']; ?></a></h5>
                                    <p class="text-truncate-2 mb-2 text-justify"><?php echo $row['deskripsi']; ?></p>
                                    <p class="text-truncate-2 mb-2 text-justify"><?php echo $row['alamat']; ?></p>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item ms-0 h6 fw-light mb-0"><?php echo $row['harga_tiket']; ?></li>
                                    </ul>
                                </div>
                                <div class="card-footer pt-0 pb-3">
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="h6 fw-light mb-0"><i class="fas fa-table text-orange me-2"></i><?= $row['jadwal']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">Tidak ada data</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Content wisata end -->


        <!-- Content hotel -->
        <div class="tab-pane fade" id="course-pills-tabs-3" role="tabpanel" aria-labelledby="course-pills-tab-3">
            <div class="row g-4">
                <!-- Card item hotel -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card shadow h-100">
                        <!-- Image -->
                        <img src="./img/nasipecel.jpg" class="card-img-top" alt="course image">
                        <div class="card-body pb-0">
                            <!-- Title -->
                            <h5 class="card-title fw-normal"><a href="#">The Farrel Hotel</a></h5>
                            <p class="text-truncate-2 mb-2">Tempat beristirahat yang sangat nyaman dengan kualitas bintang 5</p>
                            <!-- Rating star -->
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item ms-0 h6 fw-light mb-0">4.0/5.0</li>
                            </ul>
                        </div>
                        <!-- Card footer hotel -->
                        <div class="card-footer pt-0 pb-3">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>12h 56m</span>
                                <span class="h6 fw-light mb-0"><i class="fas fa-table text-orange me-2"></i>15 lectures</span>
                            </div>
                        </div>
                        <!-- Card footer hotel end -->
                    </div>
                </div>
                <!-- Card item hotel end -->
            </div>
        </div>
        <!-- Content hotel end -->


    </div> <!-- Tabs isi content all end -->
</div>