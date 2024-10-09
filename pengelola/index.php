<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, redirect ke halaman login
    header("Location: /nganjukvisitnew/login.php");
    exit;
}

// Cek apakah pengguna memiliki role pengelola
if ($_SESSION['role'] !== 'pengelola') {
    // Jika pengguna bukan pengelola, redirect ke halaman yang sesuai
    header("Location: /nganjukvisitnew/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pengelola Nganjuk Visit</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="../vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("sidebar_pengelola.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include("nav_pengelola.php"); ?>

                <?php include("pengelola_wisata.php"); ?>

            </div>
        </div>

    </div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- script js bootstrap -->
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <!-- script js bootstrap end-->

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../vendor/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../vendor/js/demo/chart-area-demo.js"></script>
    <script src="../vendor/js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- script jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- script jquery cdn end-->
</body>

</html>