<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganjuk Visit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="icon" href="./public/assets/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/font-size/font-size.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/padding/padding.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/hover-min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@1,300&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        /* Navbar transparan tanpa bayangan */
        @media (min-width: 992px) {

            /* Navbar transparan hanya pada layar besar */
            .navbar-transparent {
                background-color: transparent !important;
                box-shadow: none !important;
            }

            /* Navbar putih dengan bayangan hanya pada layar besar */
            .navbar-scrolled {
                background-color: white !important;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            }
        }

        @media (max-width: 991px) {

            /* Navbar putih dengan bayangan pada layar mobile */
            .navbar-transparent,
            .navbar-scrolled {
                background-color: white !important;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            }
        }

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

        .text-custom {
            color: #0C3924;
        }

        .floating-full {
            position: relative;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .thumbnail {
            width: 60px;
            /* Lebar kotak kecil */
            height: 60px;
            /* Tinggi kotak kecil */
            object-fit: cover;
            /* Crop gambar untuk mengisi kotak tanpa distorsi */
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 1px solid #ddd;
            /* Opsional: Menambahkan border */
            border-radius: 5px;
            /* Opsional: Sudut membulat */
        }

        .thumbnail:hover {
            transform: scale(1.1);
            /* Efek hover untuk memperbesar sedikit */
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav id="navbar" class="navbar navbar-expand-lg navbar-transparent z-3 fixed-top" style="z-index: 1050;">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="./public/assets/disporabudpar.png" alt="logo" class="ms-lg-5 img-fluid" style="width: 70px; height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ms-lg-5 ps-lg-5" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link ms-lg-5 fw-semibold" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3 fw-semibold" aria-current="page" href="#kategori">Kategori</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-semibold dropdown-toggle ms-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">Detail</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold" href="wisata_nganjuk.php">Wisata</a></li>
                            <li><a class="dropdown-item fw-semibold" href="kuliner_nganjuk.php">Kuliner</a></li>
                            <li><a class="dropdown-item fw-semibold" href="hotel_nganjuk.php">Penginapan</a></li>
                            <li><a class="dropdown-item fw-semibold" href="event_nganjuk.php">Event</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3 fw-semibold" aria-current="page" href="#tentang_kami">Layanan Nganjuk Visit</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn me-lg-5 btn-outline-primary mt-2 mt-lg-0 mx-auto px-5 px-lg-3">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <!-- header -->
    <header id="home" class="pt-5 z-1 container-fluid bg-white pb-5">
        <div class="container-fluid overflow-hidden">
            <section class="pt-4 mt-3">
                <div class="row">
                    <div class="col-lg-6 mt-lg-4 pt-lg-5" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="500">
                        <h1 class="text-center text-sm pt-3 pt-lg-0 fw-bold" style="font-family: 'Playwrite GB S', sans-serif;">
                            Selamat Datang Di Kota
                        </h1>
                        <h1 class="text-center fw-bold mt-lg-3 mt-1" style="font-family: 'Playwrite GB S', sans-serif;">
                            <span class="text-primary" id="demo"></span>
                        </h1>
                        <iframe class="img-fluid hvr-bob d-block mx-auto" src="https://lottie.host/embed/6f46ad7d-9522-47b2-9e62-843f412624d1/L9ja1gpUMT.json"></iframe>
                        <p class="text-center" style="font-family: 'Poppins', sans-serif; font-size: 1.2rem;">
                            Nganjuk Visit memberikan pengalaman yang pastinya keren dan tak terlupakan dengan keindahan dan keistimewaan kota Nganjuk.
                        </p>
                    </div>
                    <div class="col-lg-6 mt-lg-5" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="500">
                        <img src="./public/assets/header-img.png" class="img-fluid floating-full" alt="nav-header" style="max-width: 100%;">
                    </div>
                </div>
            </section>
        </div>
    </header>
    <!-- header end -->

    <!-- sesi kategori -->
    <section id="kategori" class="mt-lg-2 pt-3 pt-lg-2 bg-primary pb-5">
        <div class="container-fluid bg-primary overflow-hidden mt-5 pb-5">
            <div class="row shadow justify-content-center mx-3 bg-white rounded-3 pb-4 mt-3 mb-2 mx-lg-5 mx-lg-5 px-lg-5">
                <h1 class="text-center text-custom pt-4" data-aos="fade-zoom-in" data-aos-duration="200" data-aos-easing="ease-in-back" data-aos-delay="200" data-aos-offset="0">KATEGORI</h1>
                <div data-aos="fade-zoom-in" data-aos-duration="200" data-aos-easing="ease-in-back" data-aos-delay="200" data-aos-offset="0" class="bg-primary mx-auto" style="height: 4px; width: 50%; max-width: 150px; border-radius: 2px;"></div>
                <section class="py-0 py-xl-3">
                    <!-- container -->
                    <div class="container mt-1">
                        <div class="row g-3 mb-4">
                            <!-- item event -->
                            <div class="col-sm-6 col-lg-3 hvr-bob" data-aos="fade-right" data-aos-duration="700" data-aos-delay="600" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                <a href="event_nganjuk.php" class="text-decoration-none">
                                    <div class="d-flex justify-content-start align-items-center p-4 bg-warning bg-opacity-50 rounded-3">
                                        <span class="display-6 lh-1 text-warning mb-0">
                                            <svg width="60px" height="70px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 8C2.44772 8 2 8.44772 2 9V17C2 19.7614 4.23858 22 7 22H17C19.7614 22 22 19.7614 22 17V9C22 8.44772 21.5523 8 21 8H3Z" fill="#4296FF" />
                                                <path d="M7 2C7.55228 2 8 2.44772 8 3V4H16V3C16 2.44772 16.4477 2 17 2C17.5523 2 18 2.44772 18 3V4.10002C20.2822 4.56329 22 6.58104 22 9C22 9.55228 21.5523 10 21 10H3C2.44772 10 2 9.55228 2 9C2 6.58104 3.71776 4.56329 6 4.10002V3C6 2.44772 6.44772 2 7 2Z" fill="#152C70" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 13C7 12.4477 7.44772 12 8 12H16C16.5523 12 17 12.4477 17 13C17 13.5523 16.5523 14 16 14H8C7.44772 14 7 13.5523 7 13Z" fill="#152C70" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 17C7 16.4477 7.44772 16 8 16H12C12.5523 16 13 16.4477 13 17C13 17.5523 12.5523 18 12 18H8C7.44772 18 7 17.5523 7 17Z" fill="#152C70" />
                                            </svg>
                                        </span>
                                        <div class="ms-4 h6 fw-normal mb-0">
                                            <h5 class="purecounter mb-0 fw-bold text-black">Event Nganjuk</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- item event end -->

                            <!-- item hotel -->
                            <div class="col-sm-6 col-lg-3 hvr-bob" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                <a href="hotel_nganjuk.php" class="text-decoration-none">
                                    <div class="d-flex justify-content-center align-items-center p-4 bg-success bg-opacity-50 rounded-3">
                                        <span class="display-6 lh-1 text-blue mb-0">
                                            <svg width="60px" height="70px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M762.9 116.2c-7.2-14-25.9-25.5-41.7-25.5h-417c-15.8 0-34.5 11.5-41.7 25.5L176 285.3c-7.2 14-0.1 25.5 15.6 25.5h642.1c15.8 0 22.8-11.5 15.6-25.5l-86.4-169.1z" fill="#333E48" />
                                                <path d="M786.1 161.6H600.4v28.6h200.4l-14.7-28.6z m-561.4 28.7h200.4v-28.6H239.3l-14.6 28.6z" fill="" />
                                                <path d="M158.4 289.4h708.7v622.1H158.4z" fill="#00B3E3" />
                                                <path d="M766.3 377.5h100.8V426H766.3zM628.4 597.6h100.8v48.5H628.4zM504.1 376.7h100.8v48.5H504.1zM158.4 495h100.8v48.5H158.4zM237.5 332.9h100.8v48.5H237.5zM386.4 667.5h100.8V716H386.4z" fill="" />
                                                <path d="M208.7 799.2h100.8v48.5H208.7z" fill="#5D5D5D" />
                                                <path d="M766.3 796.5h100.8V845H766.3z" fill="" />
                                                <path d="M410.6 691.8h204.3v219.7H410.6z" fill="#FFFFFF" />
                                                <path d="M498.4 691.8H527V890h-28.6z" fill="" />
                                                <path d="M220.8 425.1h123.8v140H220.8z" fill="#FFFFFF" />
                                                <path d="M220.8 425.1h123.8V456H220.8z" fill="" />
                                                <path d="M220.8 480.7h123.8v28.6H220.8z" fill="#333E48" />
                                                <path d="M235.1 550.7h95.2V439.4h-95.2v111.3z m109.5 28.6H220.8c-7.9 0-14.3-6.4-14.3-14.3V425c0-7.9 6.4-14.3 14.3-14.3h123.8c7.9 0 14.3 6.4 14.3 14.3v140c0.1 7.9-6.4 14.3-14.3 14.3z" fill="#0071CE" />
                                                <path d="M450.8 425.1h123.8v140H450.8z" fill="#FFFFFF" />
                                                <path d="M450.8 425.1h123.8V456H450.8z" fill="" />
                                                <path d="M450.8 480.7h123.8v28.6H450.8z" fill="#333E48" />
                                                <path d="M465.1 550.7h95.2V439.4h-95.2v111.3z m109.5 28.6H450.8c-7.9 0-14.3-6.4-14.3-14.3V425c0-7.9 6.4-14.3 14.3-14.3h123.8c7.9 0 14.3 6.4 14.3 14.3v140c0 7.9-6.4 14.3-14.3 14.3z" fill="#0071CE" />
                                                <path d="M680.8 425.1h123.8v140H680.8z" fill="#FFFFFF" />
                                                <path d="M680.8 425.1h123.8V456H680.8z" fill="" />
                                                <path d="M680.8 480.7h123.8v28.6H680.8z" fill="#333E48" />
                                                <path d="M695.1 550.7h95.2V439.4h-95.2v111.3z m109.5 28.6H680.8c-7.9 0-14.3-6.4-14.3-14.3V425c0-7.9 6.4-14.3 14.3-14.3h123.8c7.9 0 14.3 6.4 14.3 14.3v140c0 7.9-6.4 14.3-14.3 14.3z" fill="#0071CE" />
                                                <path d="M220.8 621.8h123.8v140H220.8z" fill="#FFFFFF" />
                                                <path d="M220.8 621.8h123.8v30.9H220.8z" fill="" />
                                                <path d="M220.8 677.5h123.8v28.6H220.8z" fill="#333E48" />
                                                <path d="M235.1 747.4h95.2V636.1h-95.2v111.3z m109.5 28.7H220.8c-7.9 0-14.3-6.4-14.3-14.3v-140c0-7.9 6.4-14.3 14.3-14.3h123.8c7.9 0 14.3 6.4 14.3 14.3v140c0.1 7.9-6.4 14.3-14.3 14.3z" fill="#0071CE" />
                                                <path d="M680.8 621.8h123.8v140H680.8z" fill="#FFFFFF" />
                                                <path d="M680.8 621.8h123.8v30.9H680.8z" fill="" />
                                                <path d="M680.8 677.5h123.8v28.6H680.8z" fill="#333E48" />
                                                <path d="M695.1 747.4h95.2V636.1h-95.2v111.3z m109.5 28.7H680.8c-7.9 0-14.3-6.4-14.3-14.3v-140c0-7.9 6.4-14.3 14.3-14.3h123.8c7.9 0 14.3 6.4 14.3 14.3v140c0 7.9-6.4 14.3-14.3 14.3zM894.1 290.5c0-10.5-8.6-19.1-19.1-19.1H150.4c-10.5 0-19.1 8.6-19.1 19.1v23.2c0 10.5 8.6 19.1 19.1 19.1H875c10.5 0 19.1-8.6 19.1-19.1v-23.2z" fill="#0071CE" />
                                                <path d="M960.2 925.3c0 4.2-3.5 7.7-7.7 7.7H72.9c-4.2 0-7.7-3.5-7.7-7.7v-27.6c0-4.2 3.5-7.7 7.7-7.7h879.5c4.2 0 7.7 3.5 7.7 7.7v27.6z" fill="#333E48" />
                                                <path d="M349.9 889.9h325.7v43H349.9z" fill="#A4A9AD" />
                                                <path d="M545.2 121.4c-7.9 0-14.3 6.4-14.3 14.3v31h-36.3v-31c0-7.9-6.4-14.3-14.3-14.3s-14.3 6.4-14.3 14.3v90.7c0 7.9 6.4 14.3 14.3 14.3s14.3-6.4 14.3-14.3v-31h36.3v31c0 7.9 6.4 14.3 14.3 14.3s14.3-6.4 14.3-14.3v-90.7c0-7.9-6.4-14.3-14.3-14.3z" fill="#FFFFFF" />
                                            </svg>
                                        </span>
                                        <div class="ms-4 h6 fw-normal mb-0">
                                            <h5 class="purecounter mb-0 fw-bold text-black">Hotel Nganjuk</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- item hotel end -->

                            <!-- item kuliner -->
                            <div class="col-sm-6 col-lg-3 hvr-bob" data-aos="fade-left" data-aos-duration="500" data-aos-delay="500" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                <a href="kuliner_nganjuk.php" class="text-decoration-none">
                                    <div class="d-flex justify-content-center align-items-center p-4 bg-danger bg-opacity-50 rounded-3">
                                        <span class="display-6 lh-1 text-purple mb-0">
                                            <svg height="70px" width="70px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 512 512" xml:space="preserve">
                                                <path style="fill:#E0E0E2;" d="M503.291,48.732c-20.381,12.446-32.814,34.605-32.814,58.486v158.807h15.956h17.962V60.974V48.058L503.291,48.732z" />
                                                <path style="fill:#C6C5CB;" d="M504.396,60.974V48.058l-1.104,0.674c-20.381,12.446-32.814,34.605-32.814,58.486v158.807h15.956V107.218C486.432,89.873,492.996,73.441,504.396,60.974z" />
                                                <g>
                                                    <path style="fill:#E0E0E2;" d="M486.432,107.218v158.807h17.962V60.974C492.996,73.441,486.432,89.873,486.432,107.218z" />
                                                    <path style="fill:#E0E0E2;" d="M69.761,143.727H9.393H7.604v5.507c0,17.658,14.314,31.972,31.972,31.972l0,0c17.658,0,31.972-14.314,31.972-31.972v-5.507H69.761z" />
                                                </g>
                                                <path style="fill:#C6C5CB;" d="M39.577,165.155L39.577,165.155c-13.961,0-25.826-8.953-30.184-21.427H7.604v5.507c0,17.658,14.314,31.972,31.972,31.972l0,0c17.658,0,31.972-14.314,31.972-31.972v-5.507h-1.789C65.402,156.202,53.538,165.155,39.577,165.155z" />
                                                <circle style="fill:#D2E7F8;" cx="256.751" cy="282.159" r="187.745" />
                                                <circle style="fill:#B3D8F5;" cx="256.751" cy="282.159" r="118.424" />
                                                <path d="M256.747,86.809C149.033,86.809,61.4,174.442,61.4,282.156c0,107.715,87.633,195.348,195.347,195.348c107.715,0,195.347-87.633,195.347-195.348C452.094,174.441,364.462,86.809,256.747,86.809z M256.747,462.295c-99.328,0-180.138-80.81-180.138-180.139s80.81-180.138,180.138-180.138c99.329,0,180.138,80.809,180.138,180.138S356.076,462.295,256.747,462.295z" />
                                                <path d="M145.742,282.156c0-61.208,49.797-111.004,111.005-111.004c17.825,0,34.844,4.093,50.584,12.167l6.941-13.534c-17.908-9.185-37.262-13.842-57.524-13.842c-69.594,0-126.214,56.619-126.214,126.213c0,11.232,1.478,22.375,4.392,33.119l14.678-3.983C147.04,301.847,145.742,292.044,145.742,282.156z" />
                                                <path d="M156.761,330.436l-13.691,6.624c7.979,16.492,19.725,31.348,33.97,42.961l9.611-11.787C174.116,358.013,163.78,344.943,156.761,330.436z" />
                                                <path d="M333.721,182.124l-9.282,12.046c27.526,21.212,43.314,53.281,43.314,87.985c0,61.208-49.797,111.005-111.005,111.005c-21.791,0-42.88-6.309-60.991-18.241l-8.368,12.699c20.602,13.575,44.585,20.751,69.359,20.751c69.595,0,126.214-56.619,126.214-126.214C382.96,242.698,365.013,206.238,333.721,182.124z" />
                                                <path d="M79.097,151.331h0.057v-2.098v-13.111V48.058H63.945v88.065H47.181V48.058H31.972v88.065H15.209V48.058H0v88.065v13.111v2.098h0.057c0.96,18.283,14.386,33.312,31.916,36.738v281.83h15.209V188.07C64.71,184.643,78.136,169.615,79.097,151.331zM39.577,173.602c-12.73,0-23.211-9.813-24.278-22.27h48.557C62.787,163.789,52.306,173.602,39.577,173.602z" />
                                                <path d="M462.872,107.218V273.63h33.919V469.9H512v-196.27v-92.423V34.496l-12.672,7.747C476.841,55.975,462.872,80.87,462.872,107.218z M496.791,181.206v77.215h-18.711V107.217c0-16.624,6.948-32.525,18.711-43.896V181.206z" />
                                            </svg>
                                        </span>
                                        <div class="ms-4 h6 fw-normal mb-0">
                                            <h5 class="purecounter mb-0 fw-bold text-black">Kuliner Nganjuk</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- item kuliner end -->

                            <!-- item wisata -->
                            <div class="col-sm-6 col-lg-3 hvr-bob" data-aos="fade-left" data-aos-duration="700" data-aos-delay="600" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                <a href="wisata_nganjuk.php" class="text-decoration-none">
                                    <div class="d-flex justify-content-center align-items-center p-4 bg-primary bg-opacity-50 rounded-3">
                                        <span class="display-6 lh-1 text-primary mb-0">
                                            <svg width="70px" height="70px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 23H39V34C39 35.1046 38.1046 36 37 36H11C9.89543 36 9 35.1046 9 34V23Z" fill="#2F88FF" stroke="#000000" stroke-width="4" stroke-linejoin="round" />
                                                <path d="M9 8C9 6.89543 9.89543 6 11 6H37C38.1046 6 39 6.89543 39 8V23H9V8Z" stroke="#000000" stroke-width="4" stroke-linejoin="round" />
                                                <path d="M15 42C13.3431 42 12 40.6569 12 39V36H18V39C18 40.6569 16.6569 42 15 42Z" fill="#2F88FF" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M33 42C31.3431 42 30 40.6569 30 39V36H36V39C36 40.6569 34.6569 42 33 42Z" fill="#2F88FF" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6 12V16" stroke="#000000" stroke-width="4" stroke-linecap="round" />
                                                <path d="M42 12V16" stroke="#000000" stroke-width="4" stroke-linecap="round" />
                                                <circle cx="15" cy="30" r="2" fill="white" />
                                                <circle cx="33" cy="30" r="2" fill="white" />
                                                <path d="M31 6L22 16" stroke="#000000" stroke-width="4" stroke-linecap="round" />
                                                <path d="M38 7L33 13" stroke="#000000" stroke-width="4" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <div class="ms-4 h6 fw-normal mb-0">
                                            <h5 class="purecounter mb-0 fw-bold text-black">Wisata Nganjuk</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- item wisata end -->
                        </div>

                        <!-- sesi all menu -->
                        <?php include("semua_kategori.php"); ?>
                        <!-- sesi all menu end -->
                    </div>
                    <!-- end container -->
                </section>
            </div>
        </div>
    </section>
    <!-- sesi kategori end -->

    <!-- Sesi Tentang Kami -->
    <section id="tentang_kami" class="pb-2 pt-1 bg-white px-lg-3">
        <div class="container-fluid pb-2 pt-5">
            <div class="row justify-content-center mt-5 mb-3" data-aos="fade-up"
                data-aos-duration="2000">
                <h1 class="text-center text-custom display-4">NGANJUK VISIT</h1>
                <div class="bg-primary mx-auto" style="height: 4px; width: 50%; max-width: 300px; border-radius: 2px;"></div>
                <div class=" row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 align-items-start">

                    <div class="col-6 col-md-6 col-lg-3 mb-2" data-aos="fade-up-right" data-aos-duration="2500">
                        <div class="card h-100">
                            <img src="./public/assets/wisata.jpg" class="card-img-top img-fluid" alt="Image">
                            <div class="card-body text-center">
                                <h5 class="card-title">Layanan Wisata</h5>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#descriptionWisata" aria-expanded="false" aria-controls="descriptionWisata">
                                    Baca Selengkapnya <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse mt-2" id="descriptionWisata">
                                    <ul class="list-group list-group-flush text-start">
                                        <li class="list-group-item">Nganjuk Visit menyediakan informasi lengkap tentang wisata di Kota Nganjuk.</li>
                                        <li class="list-group-item">Anda dapat memberikan rating, ulasan, like, dan memesan tiket secara online melalui aplikasi Nganjuk Visit.</li>
                                        <li class="list-group-item">Anda dapat melihat lokasi wisata, deskripsi, harga tiket dan cuplikan informasi wisata.</li>
                                        <li class="list-group-item">Nikmati pengalaman wisata yang lebih mudah dan modern, temukan berbagai pilihan wisata dengan detail lengkap di satu tempat.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3 mb-2" data-aos="fade-up-right" data-aos-duration="1000">
                        <div class="card h-100">
                            <img src="./public/assets/kuliner.jpg" class="card-img-top img-fluid" alt="Image">
                            <div class="card-body text-center">
                                <h5 class="card-title">Layanan Kuliner</h5>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#descriptionKuliner" aria-expanded="false" aria-controls="descriptionKuliner">
                                    Baca Selengkapnya <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse mt-2" id="descriptionKuliner">
                                    <ul class="list-group list-group-flush text-start">
                                        <li class="list-group-item">Nganjuk Visit menyediakan informasi lengkap tentang kuliner di Kota Nganjuk.</li>
                                        <li class="list-group-item">Anda dapat menyukai dan memberi rating melalui aplikasi Nganjuk Visit.</li>
                                        <li class="list-group-item">Nikmati kuliner baik yang tradisional maupun yang modern, temukan berbagai pilihan kuliner dengan detail yang lengkap di Kota Nganjuk</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3 mb-2" data-aos="fade-up-left" data-aos-duration="1000">
                        <div class="card h-100">
                            <img src="./public/assets/hotel.jpg" class="card-img-top img-fluid" alt="Image">
                            <div class="card-body text-center">
                                <h5 class="card-title">Layanan Hotel</h5>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#descriptionHotel" aria-expanded="false" aria-controls="descriptionHotel">
                                    Baca Selengkapnya <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse mt-2" id="descriptionHotel">
                                    <ul class="list-group list-group-flush text-start">
                                        <li class="list-group-item">Nganjuk Visit menyediakan informasi lengkap tentang penginapan di Kota Nganjuk.</li>
                                        <li class="list-group-item">Anda dapat memberikan rating, ulasan, like, dan melihat lokasi melalui aplikasi Nganjuk Visit.</li>
                                        <li class="list-group-item">Anda dapat melihat nama, deskripsi, harga tiket dan cuplikan informasi penginapan.</li>
                                        <li class="list-group-item">Nikmati pengalaman menginapan di penginapan yang lebih mudah dan modern di Kota Nganjuk, temukan berbagai pilihan penginapan dengan detail lengkap di melalui Nganjuk Visit.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 col-lg-3 mb-2" data-aos="fade-up-left" data-aos-duration="2500">
                        <div class="card h-100">
                            <img src="./public/assets/event.jpg" class="card-img-top img-fluid" alt="Image">
                            <div class="card-body text-center">
                                <h5 class="card-title">Layanan Event</h5>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#descriptionEvent" aria-expanded="false" aria-controls="descriptionEvent">
                                    Baca Selengkapnya <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="collapse mt-2" id="descriptionEvent">
                                    <ul class="list-group list-group-flush text-start">
                                        <li class="list-group-item">Nganjuk Visit menyediakan informasi event dan acara yang ada di Kota Nganjuk.</li>
                                        <li class="list-group-item">Anda dapat melihat nama event, deskripsi, tanggal dan cuplikan informasi event yang ada.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row justify-content-center pt-lg-5 mt-3">
                <div class="col-12 col-md-10 text-center">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt text-primary fs-3"></i>
                            <h4 class="mt-2 mb-2">Alamat Kantor</h4>
                            <p class="mb-3">
                                Mangundikaran, Mangun Dikaran, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur 64419
                            </p>
                            <div class="bg-primary mx-auto" style="height: 4px; width: 50%; max-width: 200px; border-radius: 2px;"></div>
                        </div>
                        <!-- Peta Google Maps -->
                        <div class="ratio ratio-16x9 mt-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.270853382954!2d111.9027164!3d-7.601066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784ba9d9447a99:0x1e4f0169e2940678!2sGedung+Balai+Budaya+Mpu+Sendok!5e0!3m2!1sen!2sid!4v1666513915249"
                                allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sesi Tentang Kami End -->


    <!-- footer -->
    <?php include("footer.php"); ?>
    <!-- footer end -->

    <!-- Tombol Scroll to Top -->
    <button id="scrollTopBtn" class="btn btn-dark">
        <svg class="mx-auto" width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 19V5M12 5L5 12M12 5l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>


    <!-- script js bootstrap -->
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- script js bootstrap end-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- script jquery -->
    <script src="./js/jquery-3.7.1.min.js"></script>
    <!-- script jquery end-->

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                strings: ["Nganjuk", "Berbudaya", "Adipura"],
                typeSpeed: 100,
                backSpeed: 50,
                loop: true,
                backDelay: 2000,
                showCursor: true,
                cursorChar: '|',
                preStringTyped: (arrayPos) => {
                    const colors = ['text-primary', 'text-success', 'text-info'];
                    const element = document.getElementById('demo');

                    // Menghapus semua class warna sebelumnya
                    element.classList.remove(...colors);

                    // Menambahkan class warna sesuai index
                    element.classList.add(colors[arrayPos % colors.length]);
                }
            };

            new Typed("#demo", options);
        });
    </script>

    <!-- nav transparan ketika di top -->
    <script>
        // Mendapatkan elemen navbar
        const navbar = document.getElementById('navbar');

        // Fungsi untuk mengubah kelas navbar saat scroll
        function onScroll() {
            if (window.scrollY > 0) {
                navbar.classList.remove('navbar-transparent');
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('navbar-transparent');
            }
        }

        // Memanggil fungsi saat halaman di-scroll
        window.addEventListener('scroll', onScroll);

        // Memanggil fungsi saat pertama kali halaman dimuat
        document.addEventListener('DOMContentLoaded', onScroll);
    </script>

    <script>
        // Tampilkan tombol jika user scroll lebih dari 100px
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#scrollTopBtn').fadeIn();
            } else {
                $('#scrollTopBtn').fadeOut();
            }
        });

        // Smooth scroll ke atas saat tombol diklik
        $("#scrollTopBtn").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });

        // Seleksi tombol Scroll to Top
        const scrollTopBtn = document.getElementById("scrollTopBtn");

        // Event listener untuk mengembalikan warna tombol setelah klik
        scrollTopBtn.addEventListener("click", function() {
            // Ubah warna tombol kembali ke warna awal
            scrollTopBtn.style.backgroundColor = "white";
            scrollTopBtn.style.color = "black";

            // Arahkan halaman ke atas
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn[data-bs-toggle="collapse"]').on('click', function() {
                // Tutup semua collapse yang sedang terbuka, kecuali yang sedang diklik
                $('.collapse.show').not($(this).data('bs-target')).collapse('hide');
            });
        });
    </script>
</body>

</html>