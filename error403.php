<?php
include("./base_url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganjuk Visit | Page Not Found</title>
    <link rel="icon" href="<?= BASE_URL; ?>/public/assets/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="bg-dark text-dark">
        <div class="d-flex align-items-center justify-content-center min-vh-100 px-2">
            <div class="text-center">
                <img src="<?= BASE_URL; ?>/public/assets/disporabudpar.png" width="150px" alt="" class="img-fluid z-1">
                <h1 class="display-1 fw-bold text-white">403</h1>
                <p class="fs-2 fw-medium mt-4 text-white">Oops! Access Denied.</p>
                <p class="mt-4 mb-5 text-white">Access to Nganjuk Visit is forbidden.</p>
                <a href="<?= BASE_URL; ?>/index.php" class="btn btn-danger text-white fw-semibold rounded-pill px-4 py-2 custom-btn">
                    Go Home
                </a>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL; ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>