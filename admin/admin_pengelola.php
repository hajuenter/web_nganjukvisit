<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, redirect ke halaman login
    header("Location: /nganjukvisitnew/login.php");
    exit;
}

// Cek apakah pengguna memiliki role admin
if ($_SESSION['role'] !== 'admin') {
    // Jika pengguna bukan admin, redirect ke halaman yang sesuai
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

    <title>Admin Nganjuk Visit</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../vendor/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include("sidebar.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include("nav.php"); ?>

                <?php include("menu_pengelola.php"); ?>

            </div>
        </div>


    </div>


    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../controllers/proseslogout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.js"></script>

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

</body>

</html>