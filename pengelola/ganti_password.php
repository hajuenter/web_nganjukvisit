<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']); // Hapus pesan setelah ditampilkan
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <h1 class="text-info mb-3">
                <i class="fa-solid fa-lock"></i> Password Baru
            </h1>
            <form action="../controllers/pengelola_ganti_password.php" method="post">
                <div class="mb-3">
                    <label for="new-password" class="form-label">
                        <i class="fa-solid fa-key"></i> Password Baru
                    </label>
                    <input type="password" id="new-password" name="pass" class="form-control" placeholder="Masukkan password baru" required>
                </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <h1 class="text-info mb-3">
                <i class="fa-solid fa-lock"></i> Konfirmasi Password
            </h1>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">
                    <i class="fa-solid fa-key"></i> Konfirmasi Password Baru
                </label>
                <input type="password" id="confirm-password" name="konfir_pass" class="form-control" placeholder="Masukkan kembali password baru" required>
            </div>
            <button type="submit" class="btn btn-info w-100">
                <i class="fa-solid fa-refresh"></i> Perbarui
            </button>
            </form>
        </div>
    </div>
</div>