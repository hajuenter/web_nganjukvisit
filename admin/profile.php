<?php
$conn = $koneksi;
$id_user = $_SESSION['user_id'];

$sql = "SELECT email, nama, role, alamat, gambar FROM user WHERE id_user = ?";
$stm = $conn->prepare($sql);
$stm->bind_param("i", $id_user);
$stm->execute();
$result = $stm->get_result();
$user = $result->fetch_assoc();

$email = $user['email'];
$nama = $user['nama'];
$role = $user['role'];
$alamat = $user['alamat'];
// Ganti gambar default jika pengguna belum memiliki gambar
$gambar_profil = !empty($user['gambar']) ? "../public/gambar/" . $user['gambar'] : "../public/gambar/avatar_profile.jpg";

?>

<div class="container-fluid">
    <div class="container-xl px-4 mt-4">

        <?php if (isset($_SESSION['profile_update'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['profile_update']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['profile_update']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['profile_gagal'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['profile_gagal']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['profile_gagal']); ?>
        <?php endif; ?>

        <hr class="mt-0 mb-2">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Foto Profil</div>
                    <div class="card-body text-center mb-2">
                        <img class="img-account-profile img-fluid rounded-circle w-100"
                            src="<?= htmlspecialchars($gambar_profil) ?>"
                            alt="Foto Profil" style="max-width: 200px; height: auto;">
                        <div class="small font-italic text-muted mb-4">JPG atau PNG</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Detail Akun</div>
                    <div class="card-body">
                        <form method="post" action="../controllers/edit_profile.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="small mb-1" id="inputFoto">Upload Gambar Baru</label>
                                <input type="file" name="foto" class="form-control mb-3" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputName">Nama</label>
                                <input class="form-control" id="inputName" type="text" name="name" value="<?= htmlspecialchars($user['nama']) ?>" required>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputRole">Role</label>
                                    <input class="form-control" id="inputRole" type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputAlamat">Alamat</label>
                                    <input class="form-control" id="inputAlamat" type="text" name="alamat" value="<?= htmlspecialchars($user['alamat']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control" id="inputEmailAddress" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>