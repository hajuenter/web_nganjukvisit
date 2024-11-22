<?php
include("./base_url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nganjuk Visit | Page Not Found</title>
    <link rel="icon" href="./public/assets/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/404.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="bg-dark text-dark">
        <div class="d-flex align-items-center justify-content-center min-vh-100 px-2">
            <div class="text-center">
                <img src="./public/assets/disporabudpar.png" width="150px" alt="" class="img-fluid z-1">
                <h1 class="display-1 fw-bold text-white">404</h1>
                <p class="fs-2 fw-medium mt-4 text-white">Oops! Page not found</p>
                <p class="mt-4 mb-5 text-white">Nganjuk Visit is not found on your URL</p>
                <a href="<?= BASE_URL; ?>/index.php" class="btn btn-light text-white fw-semibold rounded-pill px-4 py-2 custom-btn">
                    Go Home
                </a>
            </div>
        </div>
    </div>

    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>