<?php
include("../koneksi.php");

$conn = $koneksi;

// Mendapatkan kategori dari request
$category = $_GET['category'] ?? '';

// Menyiapkan query SQL berdasarkan kategori yang dipilih
$sql = '';
if ($category === 'ulasan_wisata') {
    $sql = "SELECT id_ulasan_w AS id_ulasan, nama AS nama_pengulas, kategori, komentar AS isi_ulasan, tanggal, id_user FROM ulasan_wisata";
} elseif ($category === 'ulasan_penginapan') {
    $sql = "SELECT id_ulasan_p AS id_ulasan, nama AS nama_pengulas, kategori, komentar AS isi_ulasan, tanggal, id_user FROM ulasan_penginapan";
} else {
    // Jika tidak ada kategori yang dipilih, tampilkan data dari dua tabel yang ada
    $sql = "
        SELECT id_ulasan_w AS id_ulasan, nama AS nama_pengulas, kategori, komentar AS isi_ulasan, tanggal, id_user FROM ulasan_wisata
        UNION
        SELECT id_ulasan_p AS id_ulasan, nama AS nama_pengulas, kategori, komentar AS isi_ulasan, tanggal, id_user FROM ulasan_penginapan
    ";
}

// Jalankan query dan simpan hasilnya
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_ulasan']}</td>
                <td>{$row['id_user']}</td>
                <td>{$row['nama_pengulas']}</td>
                <td>{$row['kategori']}</td>
                <td>{$row['isi_ulasan']}</td>
                <td>{$row['tanggal']}</td>
                <td>
                 <button class='btn btn-danger px-2 btn-sm' 
                    data-bs-toggle='modal' 
                    data-bs-target='#confirmDeleteModal' 
                    data-category='{$row['kategori']}' 
                    data-id='{$row['id_ulasan']}'>
                <i class='fas fa-trash'></i> Hapus
            </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Tidak ada ulasan ditemukan.</td></tr>";
}

$conn->close();
