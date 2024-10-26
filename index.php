<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect berdasarkan role pengguna
    if ($_SESSION['role'] === 'admin') {
        header("Location: /nganjukvisit/admin/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'pengelola') {
        header("Location: /nganjukvisit/pengelola/index.php");
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
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/font-size/font-size.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/padding/padding.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/hover-min.css">
    <style>
        .text-custom {
            color: #0C3924;
        }

        .text-custom-bold {
            color: #0C3924;
            font-weight: bold;
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
                        <a class="nav-link ms-lg-5" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-lg-3" aria-current="page" href="#kategori">Kategori</a>
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
                        <a class="nav-link ms-lg-3" aria-current="page" href="#tentang_kami">Tentang Kami</a>
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
                    <div class="col-lg-6 mt-lg-5 pt-lg-5 pt-2" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="500">
                        <h1 class="text-center pt-3 pt-lg-0 fw-bold">
                            Selamat Datang Di Kota
                        </h1>
                        <h1 class="text-center fw-bold">
                            <span class="text-primary" id="demo"></span>
                        </h1>
                        <p class="text-center pt-lg-3" style="font-family: 'Poppins', sans-serif; font-size: 1.2rem;">
                            Nganjuk Visit memberikan pengalaman yang pastinya keren dan tak terlupakan dengan keindahan dan keistimewaan kota Nganjuk.
                        </p>
                        <img src="./img/app_mobile.png" alt="app" class="img-fluid hvr-bob d-block mx-auto mt-lg-5 mt-1" style="max-width: 300px;">
                    </div>
                    <div class="col-lg-6 mt-2 pt-2 mt-lg-4" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="500">
                        <img src="./img/Group 46.png" class="img-fluid floating-full" alt="nav-header" style="max-width: 100%;">
                    </div>
                </div>
            </section>
        </div>
    </header>
    <!-- header end -->

    <!-- sesi kategori -->
    <section id="kategori" class="mt-lg-2 pt-lg-2 bg-light pb-5">
        <div class="container-fluid overflow-hidden mt-5 pb-5">
            <div class="row shadow justify-content-center mx-3 bg-white rounded-3 pb-4 mt-3 mb-2 mx-lg-5 mx-lg-5 px-lg-5">
                <h1 class="text-center mt-5 pt-5" data-aos="fade-zoom-in" data-aos-duration="200" data-aos-easing="ease-in-back" data-aos-delay="200" data-aos-offset="0">KATEGORI</h1>
                <section class="py-0 py-xl-3">
                    <!-- container -->
                    <div class="container">
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
    <section id="tentang_kami" class="pb-2 pt-5 bg-white px-lg-3">
        <div class="container-fluid pb-2 pt-3">
            <div class="row justify-content-center mt-5 mb-5" data-aos="fade-up"
                data-aos-duration="2000">
                <h1 class="text-center text-custom display-4">NGANJUK VISIT</h1>
                <!-- <div class="col-12 pt-5 d-flex justify-content-center">
                    <img src="./img/logo_nav.png" alt="Nganjuk Visit Logo" class="img-fluid" style="max-width: 200px;">
                </div> -->
            </div>

            <!-- Keindahan Wisata Kota Nganjuk -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-1 order-1 text-center" data-aos="fade-up"
                    data-aos-duration="2000">
                    <img src="./img/index-aaa.png" alt="Keindahan Wisata Kota Nganjuk" class="img-fluid rounded shadow hvr-bob" style="max-width: 100%;">
                </div>
                <div class="col-lg-6 order-lg-2 order-2" data-aos="fade-up"
                    data-aos-duration="2000">
                    <h2 class="text-custom-bold text-lg-start text-center mt-3 mt-lg-0">Keindahan Wisata Kota Nganjuk</h2>
                    <p class="fs-5 text-lg-start text-center">
                        Kota Nganjuk, dikenal sebagai Kota Angin, menawarkan beragam destinasi wisata alam yang menakjubkan. Dari pesona Air Terjun Sedudo yang memukau,
                        hingga panorama alam perbukitan Wilis yang memanjakan mata. Nikmati suasana sejuk dan asri yang membuat Anda betah berlama-lama di setiap sudut
                        keindahan Nganjuk.
                    </p>
                </div>
            </div>

            <!-- Kuliner Khas Nganjuk -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-2 order-1 text-center" data-aos="fade-up"
                    data-aos-duration="2000">
                    <img src="./img/index-bbb.png" alt="Kuliner Khas Nganjuk" class="hvr-bob img-fluid rounded shadow" style="max-width: 100%;">
                </div>
                <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-up"
                    data-aos-duration="2000">
                    <h2 class="text-custom-bold text-center text-lg-start mt-3 mt-lg-0">Kuliner Khas Nganjuk</h2>
                    <p class="fs-5 text-center text-lg-start">
                        Nganjuk juga kaya akan cita rasa kuliner tradisional yang menggugah selera. Cobalah Nasi Pecel Tumpang yang legendaris,
                        atau Manisan Mangga yang segar dan lezat. Setiap gigitan dari kuliner khas Nganjuk membawa Anda ke dalam pengalaman kuliner
                        yang autentik dan penuh kehangatan.
                    </p>
                </div>
            </div>

            <!-- Penginapan Nyaman di Kota Nganjuk -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-1 order-1 text-center" data-aos="fade-up"
                    data-aos-duration="2000">
                    <img src="./img/index-ccc.png" alt="Penginapan di Nganjuk" class="hvr-bob img-fluid rounded shadow" style="max-width: 100%;">
                </div>
                <div class="col-lg-6 order-lg-2 order-2" data-aos="fade-up"
                    data-aos-duration="2000">
                    <h2 class="text-custom-bold text-center text-lg-start mt-3 mt-lg-0">Penginapan Nyaman di Kota Nganjuk</h2>
                    <p class="fs-5 text-center text-lg-start">
                        Temukan penginapan yang nyaman di Nganjuk, mulai dari hotel berbintang hingga homestay dengan suasana rumah yang ramah.
                        Setiap penginapan menawarkan fasilitas lengkap dengan pelayanan yang hangat, memastikan perjalanan Anda semakin nyaman
                        dan berkesan.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Sesi Tentang Kami End -->


    <!-- footer -->
    <?php include("footer.php"); ?>
    <!-- footer end -->

    <!-- script jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- script jquery cdn end-->

    <!-- script js bootstrap -->
    <script src="./bootstrap/js/bootstrap.bundle.js"></script>
    <!-- script js bootstrap end-->

    <!-- script aos -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- script aos end -->

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

</body>

</html>