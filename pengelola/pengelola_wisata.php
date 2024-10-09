<?php
include("../koneksi.php");

$conn = $koneksi;
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan `ket_wisata` dari tabel user
$query_user = "SELECT ket_wisata FROM user WHERE id_user = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $id_wisata = $row_user['ket_wisata'];

    // Query untuk mendapatkan detail wisata berdasarkan `id_wisata`
    $query_wisata = "SELECT nama_wisata, deskripsi, alamat, harga_tiket, jadwal, koordinat, link_maps, gambar FROM detail_wisata WHERE id_wisata = ?";
    $stmt_wisata = $conn->prepare($query_wisata);
    $stmt_wisata->bind_param("i", $id_wisata);
    $stmt_wisata->execute();
    $result_wisata = $stmt_wisata->get_result();

    if ($result_wisata->num_rows > 0) {
        $row_wisata = $result_wisata->fetch_assoc();
        $nama_wisata = $row_wisata['nama_wisata'];
        $deskripsi = $row_wisata['deskripsi'];
        $alamat = $row_wisata['alamat'];
        $harga_tiket = $row_wisata['harga_tiket'];
        $jadwal = $row_wisata['jadwal'];
        $koordinat = $row_wisata['koordinat'];
        $link_maps = $row_wisata['link_maps'];
        $gambar = trim($row_wisata['gambar'], ','); // Hilangkan koma di awal dan akhir
        $gambar_array = array_filter(explode(',', $gambar)); // Mengubah string gambar menjadi array dan buang elemen kosong
    } else {
        $nama_wisata = '';
        $deskripsi = '';
        $alamat = '';
        $gambar_array = [];
    }
} else {
    $nama_wisata = '';
    $deskripsi = '';
    $alamat = '';
    $gambar_array = [];
}
?>

<div class="container-fluid">
    <h1 class="text-center">Menu Pengelola Wisata Nganjuk Visit</h1>
    <hr>
    <h2 class="text-center">Form Detail Wisata <?php echo htmlspecialchars($nama_wisata); ?></h2>
    <form class="pb-3" action="../controllers/pengelola_edit_wisata.php" method="post" enctype="multipart/form-data">
        <?php
        if (isset($_SESSION['berhasil'])) : ?>
            <div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['berhasil']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['berhasil']); ?>
        <?php endif; ?>

        <?php
        if (isset($_SESSION['gagal'])) : ?>
            <div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['gagal']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['gagal']); ?>
        <?php endif; ?>
        <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($id_wisata); ?>">
        <div class="mb-2">
            <label for="namaWisata" class="form-label">Nama Wisata</label>
            <input type="text" class="form-control" id="namaWisata" name="namaWisata" value="<?php echo htmlspecialchars($nama_wisata); ?>" required>
        </div>
        <div class="mb-2">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
        </div>
        <div class="mb-2">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>" required>
        </div>
        <div class="mb-2">
            <label for="harga_tiket" class="form-label">Harga Tiket</label>
            <input type="text" class="form-control" id="harga_tiket" name="harga_tiket" value="<?php echo htmlspecialchars($harga_tiket); ?>" required>
        </div>
        <div class="mb-2">
            <label for="jadwal" class="form-label">Jadwal</label>
            <input type="text" class="form-control" id="jadwal" name="jadwal" value="<?php echo htmlspecialchars($jadwal); ?>" required>
        </div>
        <div class="mb-2">
            <label for="koordinat" class="form-label">Koordinat</label>
            <input type="text" class="form-control" id="koordinat" name="koordinat" value="<?php echo htmlspecialchars($koordinat); ?>" required>
        </div>
        <div class="mb-2">
            <label for="link_maps" class="form-label">Link Maps</label>
            <input type="text" class="form-control" id="link_maps" name="link_maps" value="<?php echo htmlspecialchars($link_maps); ?>" required>
        </div>
        <div class="mb-2">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
    <hr>
    <h3 class="text-center">Gambar Wisata</h3>
    <div class="row">
        <?php if (!empty($gambar_array)) : ?>
            <?php foreach ($gambar_array as $index => $img) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="../public/gambar/<?php echo htmlspecialchars(trim($img)); ?>" class="card-img-top" alt="Gambar Wisata">
                        <div class="card-body text-center">
                            <form action="../controllers/pengelola_hapus_gambar.php" method="post">
                                <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($id_wisata); ?>">
                                <input type="hidden" name="gambar" value="<?php echo htmlspecialchars(trim($img)); ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">Tidak ada gambar yang tersedia.</p>
        <?php endif; ?>
    </div>
</div>