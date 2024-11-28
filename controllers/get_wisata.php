<?php
include("../koneksi.php");
$conn = $koneksi;

if (isset($_POST['id_wisata'])) {
    $id_wisata = $_POST['id_wisata'];

    // Query untuk mendapatkan data wisata berdasarkan id_wisata
    $sql = "SELECT * FROM detail_wisata WHERE id_wisata = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_wisata);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Pisahkan jadwal menjadi array berdasarkan koma
        $jadwal_array = explode(',', $row['jadwal']);
        $jadwal_buka_tutup = array_fill(0, 14, '');

        // Proses untuk mendapatkan jam buka dan tutup
        foreach ($jadwal_array as $index => $jadwal) {
            $jadwal = trim($jadwal);
            if (preg_match('/(.*):\s*(\d{2}:\d{2})-(\d{2}:\d{2})/', $jadwal, $matches)) {
                $hari_index = $index * 2;
                $jadwal_buka_tutup[$hari_index] = htmlspecialchars($matches[2]);
                $jadwal_buka_tutup[$hari_index + 1] = htmlspecialchars($matches[3]);
            }
        }

        // Tampilkan form dengan data yang sudah diambil
        echo '
        <form id="form-edit" action="../controllers/edit_wisata.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_wisata" value="' . htmlspecialchars($row['id_wisata']) . '">
            <div class="mb-3">
                <label for="nama_wisata" class="form-label">Nama Wisata</label>
                <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" value="' . htmlspecialchars($row['nama_wisata']) . '">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">' . htmlspecialchars($row['deskripsi']) . '</textarea>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="' . htmlspecialchars($row['alamat']) . '">
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="text" class="form-control" id="harga_tiket" name="harga_tiket" value="' . htmlspecialchars($row['harga_tiket']) . '">
            </div>
            <div class="mb-3">
                <label class="form-label">Jadwal Buka Tutup</label>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="senin_buka" class="form-label">Senin Buka</label>
                        <input type="time" class="form-control" id="senin_buka" name="jadwal[senin][buka]" value="' . $jadwal_buka_tutup[0] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="senin_tutup" class="form-label">Senin Tutup</label>
                        <input type="time" class="form-control" id="senin_tutup" name="jadwal[senin][tutup]" value="' . $jadwal_buka_tutup[1] . '">
                    </div>
                </div>
                <!-- Tambahkan input untuk hari lain dengan format yang sama -->
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="selasa_buka" class="form-label">Selasa Buka</label>
                        <input type="time" class="form-control" id="selasa_buka" name="jadwal[selasa][buka]" value="' . $jadwal_buka_tutup[2] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="selasa_tutup" class="form-label">Selasa Tutup</label>
                        <input type="time" class="form-control" id="selasa_tutup" name="jadwal[selasa][tutup]" value="' . $jadwal_buka_tutup[3] . '">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="rabu_buka" class="form-label">Rabu Buka</label>
                        <input type="time" class="form-control" id="rabu_buka" name="jadwal[rabu][buka]" value="' . $jadwal_buka_tutup[4] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="rabu_tutup" class="form-label">Rabu Tutup</label>
                        <input type="time" class="form-control" id="rabu_tutup" name="jadwal[rabu][tutup]" value="' . $jadwal_buka_tutup[5] . '">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="kamis_buka" class="form-label">Kamis Buka</label>
                        <input type="time" class="form-control" id="kamis_buka" name="jadwal[kamis][buka]" value="' . $jadwal_buka_tutup[6] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="kamis_tutup" class="form-label">Kamis Tutup</label>
                        <input type="time" class="form-control" id="kamis_tutup" name="jadwal[kamis][tutup]" value="' . $jadwal_buka_tutup[7] . '">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="jumat_buka" class="form-label">Jumat Buka</label>
                        <input type="time" class="form-control" id="jumat_buka" name="jadwal[jumat][buka]" value="' . $jadwal_buka_tutup[8] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="jumat_tutup" class="form-label">Jumat Tutup</label>
                        <input type="time" class="form-control" id="jumat_tutup" name="jadwal[jumat][tutup]" value="' . $jadwal_buka_tutup[9] . '">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="sabtu_buka" class="form-label">Sabtu Buka</label>
                        <input type="time" class="form-control" id="sabtu_buka" name="jadwal[sabtu][buka]" value="' . $jadwal_buka_tutup[10] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="sabtu_tutup" class="form-label">Sabtu Tutup</label>
                        <input type="time" class="form-control" id="sabtu_tutup" name="jadwal[sabtu][tutup]" value="' . $jadwal_buka_tutup[11] . '">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="minggu_buka" class="form-label">Minggu Buka</label>
                        <input type="time" class="form-control" id="minggu_buka" name="jadwal[minggu][buka]" value="' . $jadwal_buka_tutup[12] . '">
                    </div>
                    <div class="col-md-6">
                        <label for="minggu_tutup" class="form-label">Minggu Tutup</label>
                        <input type="time" class="form-control" id="minggu_tutup" name="jadwal[minggu][tutup]" value="' . $jadwal_buka_tutup[13] . '">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Wisata</label>
                <input type="file" class="form-control" id="gambar" name="gambar[]" multiple accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Koordinat</label>
                <input type="text" class="form-control" id="koordinat" name="koordinat" value="' . htmlspecialchars($row['koordinat']) . '">
            </div>
            <div class="mb-3">
                <label for="link_maps" class="form-label">Link Maps</label>
                <input type="url" class="form-control" id="link_maps" name="link_maps" value="' . htmlspecialchars($row['link_maps']) . '">
            </div>
        </form>';
    } else {
        echo "Data tidak ditemukan.";
    }
}
