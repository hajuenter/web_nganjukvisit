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
    $query_wisata = "SELECT nama_wisata, deskripsi, alamat, harga_tiket, jadwal, gambar FROM detail_wisata WHERE id_wisata = ?";
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
        $gambar = $row_wisata['gambar']; // Misalkan kolom gambar menyimpan nama gambar yang dipisah dengan koma
        $gambar_array = explode(',', $gambar); // Mengubah string gambar menjadi array
    } else {
        // Menangani jika tidak ada wisata ditemukan
        $nama_wisata = '';
        $deskripsi = '';
        $alamat = '';
        $gambar_array = [];
    }
} else {
    // Menangani jika tidak ada pengguna ditemukan
    $nama_wisata = '';
    $deskripsi = '';
    $alamat = '';
    $gambar_array = [];
}
?>

<div class="container-fluid">
    <h1 class="text-center">Menu Pengelola Wisata Nganjuk Visit</h1>
    <hr>
    <h2 class="text-center">Form Detail Wisata</h2>
    <form class="pb-3">
        <div class="mb-3">
            <label for="namaWisata" class="form-label">Nama Wisata</label>
            <input type="text" class="form-control" id="namaWisata" name="namaWisata" value="<?php echo htmlspecialchars($nama_wisata); ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga_tiket" class="form-label">harga_tiket</label>
            <input type="text" class="form-control" id="harga_tiket" name="harga_tiket" value="<?php echo htmlspecialchars($harga_tiket); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jadwal" class="form-label">jadwal</label>
            <input type="text" class="form-control" id="jadwal" name="jadwal" value="<?php echo htmlspecialchars($jadwal); ?>" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
    <hr>
    <!-- Tambahkan image slider -->
    <h3 class="text-center">Gambar Wisata</h3>
    <div class="mb-4 mt-2 pb-4">
        <div id="carouselGambarWisata" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($gambar_array)) : ?>
                    <?php foreach ($gambar_array as $index => $img) : ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="../public/gambar/<?php echo htmlspecialchars(trim($img)); ?>" class="d-block w-100" alt="Gambar Wisata" style="max-height: 400px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="carousel-item active">
                        <img src="../public/gambar/default.jpg" class="d-block w-100" alt="Gambar Tidak Tersedia" style="max-height: 400px; object-fit: cover;">
                    </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselGambarWisata" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" style="background-color: black; width: 40px; height: 40px; border-radius: 50%;" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselGambarWisata" data-bs-slide="next">
                <span class="carousel-control-next-icon" style="background-color: black; width: 40px; height: 40px; border-radius: 50%;" aria-hidden="true"></span>
                <span class="visually-hidden">Selanjutnya</span>
            </button>
        </div>
    </div>
    <hr>
    
</div>