<?php
include("../koneksi.php");

$conn = $koneksi;

//total event
$sqlEvent = "SELECT COUNT(*) AS total_event FROM detail_event";
$hasil1 = $conn->query($sqlEvent);

$total_event = 0;
if ($hasil1->num_rows > 0) {
    $row = $hasil1->fetch_assoc();
    $total_event = $row['total_event'];
}

//total wisata
$sqlWisata = "SELECT COUNT(*) AS total_wisata FROM detail_wisata";
$hasil2 = $conn->query($sqlWisata);

$total_wisata = 0;
if ($hasil2->num_rows > 0) {
    $row = $hasil2->fetch_assoc();
    $total_wisata = $row['total_wisata'];
}

//total kuliner
$sqlKuliner = "SELECT COUNT(*) AS total_kuliner FROM detail_kuliner";
$hasil3 = $conn->query($sqlKuliner);

$total_kuliner = 0;
if ($hasil3->num_rows > 0) {
    $row = $hasil3->fetch_assoc();
    $total_kuliner = $row['total_kuliner'];
}

//total penginapan
$sqlPenginapan = "SELECT COUNT(*) AS total_penginapan FROM detail_penginapan";
$hasil4 = $conn->query($sqlPenginapan);

$total_penginapan = 0;
if ($hasil3->num_rows > 0) {
    $row = $hasil4->fetch_assoc();
    $total_penginapan = $row['total_penginapan'];
}

$conn->close();
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-calendar-alt fa-sm text-white-50 ms-1"></i>
            <span id="currentDateTime"><?= date('d-m-Y'); ?></span>
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total (Event)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_event; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total (Penginapan)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_penginapan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total (Kuliner)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kuliner; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total (Wisata)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_wisata; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-mountain fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->

    <div class="row pb-5">

        <!-- tabel -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Peta Nganjuk</h4>
                </div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253096.35950745232!2d111.78245695484192!3d-7.615110864478897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784be1466228d1%3A0x3027a76e352bdc0!2sKabupaten%20Nganjuk%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1699187134161!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- tabel end -->


        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <!-- Card Body -->
            <div class="pt-4 pb-2">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data PHP ke JavaScript
    var totalEvent = <?php echo $total_event; ?>;
    var totalWisata = <?php echo $total_wisata; ?>;
    var totalKuliner = <?php echo $total_kuliner; ?>;
    var totalPenginapan = <?php echo $total_penginapan; ?>;

    // Buat Pie Chart
    var ctx = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Event", "Wisata", "Kuliner", "Penginapan"],
            datasets: [{
                data: [totalEvent, totalWisata, totalKuliner, totalPenginapan],
                backgroundColor: ['#007bff', '#28a745', '#17a2b8', '#ffc107'],
                hoverBackgroundColor: ['#0056b3', '#218838', '#138496', '#e0a800'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 0,
        },
    });
</script>

<!-- <script>
    // Fungsi untuk mengupdate waktu setiap detik
    function updateTime() {
        var now = new Date();
        var dateTimeString = now.getFullYear() + '-' +
            ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
            ('0' + now.getDate()).slice(-2) + ' ' +
            ('0' + now.getHours()).slice(-2) + ':' +
            ('0' + now.getMinutes()).slice(-2) + ':' +
            ('0' + now.getSeconds()).slice(-2);

        document.getElementById('currentDateTime').textContent = dateTimeString;
    }

    // Update waktu setiap detik
    setInterval(updateTime, 1000);
</script> -->