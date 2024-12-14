<div class="container-fluid pb-3" style="background-color: #f8f9fa;">
    <div class="container mt-lg-3">
        <!-- Judul dan Ikon -->
        <div class="text-center mb-lg-4">
            <h1 class="display-4">
                <i class="fas fa-user-circle fa-2x text-info"></i>
            </h1>
            <h2 class="font-weight-bold text-dark">Pengaturan Keamanan Password</h2>
            <p class="text-muted">Pastikan password baru Anda kuat dan aman.</p>
            <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#ketentuanModal">Baca ketentuan
                <i class="fas fa-info-circle"></i>
            </button>
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
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" required>
                            <button class="btn btn-outline-primary" type="button" onclick="togglePassword('password', 'toggleIconPassword')">
                                <i class="fas fa-eye" id="toggleIconPassword"></i>
                            </button>
                        </div>
                    </div>
            </div>

            <div class="col-md-6 mb-4">
                <h4 class="mb-3">Konfirmasi Password Baru</h4>
                <div class="form-group">
                    <label for="konfir_password">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="konfir_password" name="konfir_password" placeholder="Konfirmasi Password" required>
                        <button class="btn btn-outline-primary" type="button" onclick="togglePassword('konfir_password', 'toggleIconConfirm')">
                            <i class="fas fa-eye" id="toggleIconConfirm"></i>
                        </button>
                    </div>
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

<div class="modal fade" id="ketentuanModal" tabindex="-1" aria-labelledby="ketentuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ketentuanModalLabel">Syarat dan Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger">*<small class="text-black">Pastikan password baru dan konfirmasi password sama</small></p>
                <p class="text-danger">*<small class="text-black">Password harus mengandung huruf,angka, dan karakter unik</small></p>
                <p class="text-danger">*<small class="text-black">Password harus memiliki panjang antara 8 hingga 50 karakter</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>