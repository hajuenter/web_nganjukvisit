<?php
include("../koneksi.php");


$conn = $koneksi;
$id_user = $_SESSION['user_id'];

// Ambil data pengguna dari database
$sql = "SELECT nama, gambar FROM user WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$nama_ya = $user['nama'];
// Ganti gambar default jika pengguna belum memiliki gambar
$gambar_profil = !empty($user['gambar']) ? "../public/gambar/" . $user['gambar'] : "../public/gambar/avatar_profile.jpg";

// Tambahkan timestamp agar browser memuat ulang gambar terbaru
$gambar_profil .= '?v=' . time();

// Ambil notifikasi pengelola baru
$sqlinfo = "SELECT id_user, nama, role, status FROM user WHERE role = 'pengelola' AND status = 'inactive'";
$stmtinfor = $conn->prepare($sqlinfo);
$stmtinfor->execute();
$resultinfor = $stmtinfor->get_result();
$notifications = $resultinfor->fetch_all(MYSQLI_ASSOC);

// Simpan notifikasi dalam session jika belum dibaca
$_SESSION['notifications'] = $notifications;


$notifCount = isset($_SESSION['notifications']) ? count($_SESSION['notifications']) : 0;
$badgeVisible = !isset($_SESSION['notifications_read']);
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php if ($badgeVisible && $notifCount > 0): ?>
                    <span class="badge badge-danger badge-counter"><?= $notifCount ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Pemberitahuan
                </h6>
                <?php if ($notifCount > 0): ?>
                    <?php foreach ($_SESSION['notifications'] as $notif): ?>
                        <a href="admin_pengelola.php" class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fa fa-exclamation-circle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?= date('d F Y') ?></div>
                                <span class="font-weight-bold">Pengelola baru (<?= $notif['nama'] ?>) membutuhkan konfirmasi.</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="dropdown-item text-center">Tidak ada pemberitahuan.</div>
                <?php endif; ?>
                <div class="dropdown-item text-center">
                    <button id="markAsRead" class="btn btn-sm btn-link">Tandai sudah dibaca</button>
                </div>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= htmlspecialchars($nama_ya); ?></span>
                <!-- Gambar Profil di Navbar -->
                <img id="profileNavImage" class="img-profile rounded-circle" src="<?= htmlspecialchars($gambar_profil); ?>" alt="Foto Profil">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="admin_profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="admin_ganti_password.php">
                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ganti Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih keluar jika Anda ingin keluar dan menghapus semua sesi Anda</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <a class="btn btn-primary" href="../controllers/proseslogout.php">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('markAsRead').addEventListener('click', function() {
        fetch('../controllers/mark_notifications_read.php', {
                method: 'POST',
                body: new URLSearchParams({
                    markAsRead: true
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hapus badge notifikasi
                    const badge = document.querySelector('.badge-counter');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>