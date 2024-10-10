<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./style/register.css">
    <title>Login Nganjuk Visit</title>
</head>

<body class="bg-image">

    <!-- Register Form -->
    <div class="container mt-4 mb-4 d-flex justify-content-center align-items-center min-vh-100">
        <!-- Register container -->
        <div class="row border border-black rounded-5 p-3 bg-white shadow box-area">
            <!-- box kiri -->
            <div class="col-lg-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="./img/image_logos.png" class="img-fluid">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Nganjuk Visit</p>
                <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Destinasi wisata paling keren hanya ada di kota Nganjuk</small>
            </div>
            <!-- box kiri end -->

            <!-- box kanan -->
            <div class="col-lg-6 right-box">
                <!-- Alerts -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <!-- Form -->
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Daftar</h2>
                        <p>Masukkan data sesuai dengan ketentuan</p>
                    </div>
                    <form action="controllers/prosesregister.php" method="post">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Role -->
                        <!-- <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select w-100" id="role" name="role" required>
                                <option value="pengelola">Pengelola</option>
                            </select>
                        </div> -->

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <!-- NO HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Hp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" name="daftar" class="btn btn-primary">Daftar</button>
                        </div>
                        <div class="d-grid mt-3">
                            <button onclick="window.location.href='login.php';" name="hhh" class="btn btn-success">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- box kanan end -->
        </div>
        <!-- Register container end -->
    </div>
    <!-- Register end -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>