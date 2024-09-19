<?php

$hostdb = "localhost";
$userdb = "root";
$passdb = "";
$namadb = "nganjuknew";

$koneksi = mysqli_connect($hostdb, $userdb, $passdb, $namadb);

if (!$koneksi) {
    die("error adalah :" . mysqli_connect_error());
}
