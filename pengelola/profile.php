<?php
include("../koneksi.php");

$conn = $koneksi;
$id_user = $_SESSION['user_id'];

$sql = "SELECT email, nama, role, alamat, gambar, no_hp FROM user WHERE id_user = ?";
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
$no_hp = $user['no_hp'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid w-100 img-thumbnail" style="max-width: 150px; height: auto;" src="<?= htmlspecialchars($gambar_profil); ?>" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center mt-2"><?= htmlspecialchars($nama); ?></h3>
                    <p class="text-muted text-center">Pengelola Wisata Nganjuk Visit</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item mb-3">
                            <b>Role</b> <a class="float-end"><?= htmlspecialchars($role); ?></a>
                        </li>
                    </ul>
                    <form class="form-horizontal" action="../controllers/pengelola_edit_profile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <label for="formFile" class="form-label">Unggah Foto Profil</label>
                            <input class="form-control" type="file" id="formFile" name="foto" accept="image/*">
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link text-black fw-bold">Pengaturan</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <?php
                        if (isset($_SESSION['profile_update'])) : ?>
                            <div class="mt-2 alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['profile_update']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['profile_update']); ?>
                        <?php endif; ?>
                        <?php
                        if (isset($_SESSION['profile_gagal'])) : ?>
                            <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['profile_gagal']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['profile_gagal']); ?>
                        <?php endif; ?>
                        <div class="tab-pane active" id="settings">
                            <div class="mb-3 row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" required id="inputEmail" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required id="inputName" name="name" placeholder="Nama" value="<?= htmlspecialchars($nama) ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience" required name="alamat" placeholder="Alamat"><?= htmlspecialchars($alamat); ?></textarea>
                                </div>
                            </div>
                            <!-- NO HP -->
                            <div class="mb-3 row">
                                <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="number" class="form-control" id="no_hp" name="no_hp" required placeholder="Masukkan nomor HP tanpa 0 di depan" value="<?= htmlspecialchars($no_hp) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('no_hp').addEventListener('input', function() {
        let input = this.value;

        // Hapus angka 0 di depan jika ada
        if (input.startsWith('0')) {
            input = input.substring(1);
        }

        // Periksa apakah sudah ada kode negara '62'
        if (!input.startsWith('62')) {
            this.value = '62' + input;
        }
    });
</script>