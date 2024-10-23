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
        $gambar = trim($row_wisata['gambar'], ','); 
        $gambar_array = array_filter(explode(',', $gambar)); 
    } else {
        $nama_wisata = $deskripsi = $alamat = '';
        $gambar_array = [];
    }
} else {
    $nama_wisata = $deskripsi = $alamat = '';
    $gambar_array = [];
}

// Pisahkan jadwal menjadi array berdasarkan koma
$jadwal_array = explode(',', $jadwal);
$jadwal_buka_tutup = array_fill(0, 14, ''); // Siapkan array untuk jam buka dan tutup

// Proses untuk mendapatkan jam buka dan tutup
foreach ($jadwal_array as $index => $jadwal_item) {
    $jadwal_item = trim($jadwal_item);
    if (preg_match('/(.*):\s*(\d{2}:\d{2})-(\d{2}:\d{2})/', $jadwal_item, $matches)) {
        $hari_index = $index * 2;
        $jadwal_buka_tutup[$hari_index] = htmlspecialchars($matches[2]);
        $jadwal_buka_tutup[$hari_index + 1] = htmlspecialchars($matches[3]);
    }
}
?>

<div class="container-fluid">
    <h1 class="text-center text-black fw-bold">Menu Pengelola Wisata Nganjuk Visit</h1>
    <hr>
    <h2 class="text-center text-black fw-bold">Form Detail Wisata <?php echo htmlspecialchars($nama_wisata); ?></h2>
    <form class="pb-3" action="../controllers/pengelola_edit_wisata.php" method="post" enctype="multipart/form-data">
        <?php if (isset($_SESSION['berhasil'])) : ?>
            <div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['berhasil']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['berhasil']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['gagal'])) : ?>
            <div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['gagal']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['gagal']); ?>
        <?php endif; ?>

        <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($id_wisata); ?>">
        
        <div class="mb-2">
            <label for="namaWisata" class="form-label text-black">Nama Wisata</label>
            <input type="text" class="form-control text-black" id="namaWisata" name="namaWisata" value="<?php echo htmlspecialchars($nama_wisata); ?>" required>
        </div>
        
        <div class="mb-2">
            <label for="deskripsi" class="form-label text-black">Deskripsi</label>
            <textarea class="form-control text-black" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
        </div>
        
        <div class="mb-2">
            <label for="alamat" class="form-label text-black">Alamat</label>
            <input type="text" class="form-control text-black" id="alamat" name="alamat" value="<?php echo htmlspecialchars($alamat); ?>" required>
        </div>
        
        <div class="mb-2">
            <label for="harga_tiket" class="form-label text-black">Harga Tiket</label>
            <input type="text" class="form-control text-black" id="harga_tiket" name="harga_tiket" value="<?php echo htmlspecialchars($harga_tiket); ?>" required>
        </div>
        
        <div class="mb-2">
            <label class="form-label text-black">Jadwal Buka dan Tutup</label>
            <?php
            $hari_hari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
            foreach ($hari_hari as $index => $hari) : ?>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="<?php echo $hari; ?>_buka" class="form-label"><?php echo ucfirst($hari); ?> Buka</label>
                        <input type="time" class="form-control text-black" id="<?php echo $hari; ?>_buka" name="jadwal[<?php echo $hari; ?>][buka]" value="<?php echo $jadwal_buka_tutup[$index * 2]; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="<?php echo $hari; ?>_tutup" class="form-label"><?php echo ucfirst($hari); ?> Tutup</label>
                        <input type="time" class="form-control text-black" id="<?php echo $hari; ?>_tutup" name="jadwal[<?php echo $hari; ?>][tutup]" value="<?php echo $jadwal_buka_tutup[$index * 2 + 1]; ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mb-2">
            <label for="koordinat" class="form-label text-black">Koordinat</label>
            <input type="text" class="form-control text-black" id="koordinat" name="koordinat" value="<?php echo htmlspecialchars($koordinat); ?>" required>
        </div>
        
        <div class="mb-2">
            <label for="link_maps" class="form-label text-black">Link Maps</label>
            <input type="text" class="form-control text-black" id="link_maps" name="link_maps" value="<?php echo htmlspecialchars($link_maps); ?>" required>
        </div>
        
        <div class="mb-4">
            <label for="gambar" class="form-label text-black">Gambar</label>
            <input type="file" class="form-control text-black" id="gambar" name="gambar[]" multiple accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-info fw-bold">Perbarui</button>
    </form>
    
    <hr>
    <h3 class="text-center text-black fw-bold">Gambar Wisata</h3>
    <div class="row">
        <?php if (!empty($gambar_array)) : ?>
            <?php foreach ($gambar_array as $img) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card">
                        <img src="../public/gambar/<?php echo htmlspecialchars(trim($img)); ?>"
                            class="card-img-top"
                            alt="Gambar Wisata"
                            style="aspect-ratio: 16/9; object-fit: cover; width: 100%; height: auto; max-width: 1280px;">
                        <div class="card-body text-center">
                            <form action="../controllers/pengelola_hapus_gambar.php" method="post">
                                <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($id_wisata); ?>">
                                <input type="hidden" name="gambar" value="<?php echo htmlspecialchars(trim($img)); ?>">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
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
