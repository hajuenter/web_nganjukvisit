<div class="container-fluid pb-3" style="background-color: #f8f9fa;">
    <div class="container mt-lg-3">
        <!-- Judul dan Ikon -->
        <div class="text-center mb-lg-4">
            <h1 class="display-4">
                <i class="fas fa-user-circle fa-2x text-info"></i>
            </h1>
            <h2 class="font-weight-bold text-dark">Pengaturan Keamanan Password</h2>
            <p class="text-muted">Pastikan password baru Anda kuat dan aman.</p>
            
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
            <hr class="border border-primary">
        </div>

        <!-- Form Password -->
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <h4 class="mb-3">Password Baru</h4>
                <form action="../controllers/perbarui_password.php" method="POST">
                    <div class="form-group">
                        <label for="password">Masukkan Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" required>
                    </div>
            </div>

            <div class="col-md-6 mb-4">
                <h4 class="mb-3">Konfirmasi Password Baru</h4>
                <div class="form-group">
                    <label for="konfir_password">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="konfir_password" name="konfir_password" placeholder="Konfirmasi Password" required>
                </div>
            </div>
        </div>

        <!-- Button Submit -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-check-circle"></i> Perbarui Password
            </button>
        </div>
        </form>
    </div>
</div>