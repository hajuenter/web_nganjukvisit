<?php
include_once '../koneksi.php';

$action = $_POST['action'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$id_user = $_POST['id_user'] ?? '';

switch ($action) {
    case 'tambah':
        tambahFavorit($koneksi, $kategori, $id_user);
        break;
    case 'hapus':
        hapusFavorit($koneksi, $kategori, $id_user);
        break;
    case 'tampilkan':
        tampilkanFavorit($koneksi, $kategori, $id_user);
        break;
    case 'cek':
        cariFavorit($koneksi, $kategori, $id_user);
        break;
    default:
        jsonResponse(400, 'Aksi tidak dikenali');
}

function tambahFavorit($conn, $kategori, $id_user)
{
    $id_detail = $_POST['id_detail'] ?? '';

    switch ($kategori) {
        case 'wisata':
            $query = "INSERT INTO fav_wisata (id_wisata, id_user) VALUES (?, ?)";
            break;
        case 'kuliner':
            $query = "INSERT INTO fav_kuliner (id_kuliner, id_user) VALUES (?, ?)";
            break;
        case 'penginapan':
            $query = "INSERT INTO fav_penginapan (id_penginapan, id_user) VALUES (?, ?)";
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak valid');
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_detail, $id_user);

    if ($stmt->execute()) {
        jsonResponse('success', 'Favorit berhasil ditambahkan');
    } else {
        jsonResponse('gagal', 'Gagal menambah favorit');
    }
}

function hapusFavorit($conn, $kategori, $id_user)
{
    $id_detail = $_POST['id_detail'] ?? '';

    switch ($kategori) {
        case 'wisata':
            $query = "DELETE FROM fav_wisata WHERE id_user = ? AND id_wisata = ?";
            break;
        case 'kuliner':
            $query = "DELETE FROM fav_kuliner WHERE id_user = ? AND id_kuliner = ?";
            break;
        case 'penginapan':
            $query = "DELETE FROM fav_penginapan WHERE id_user = ? AND id_penginapan = ?";
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak valid');
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_user, $id_detail);

    if ($stmt->execute()) {
        jsonResponse('success', 'Favorit berhasil dihapus');
    } else {
        jsonResponse('gagal', 'Gagal menghapus favorit');
    }
}

function tampilkanFavorit($conn, $kategori, $id_user)
{
    switch ($kategori) {
        case 'wisata':
            $query = "SELECT dw.id_wisata, dw.nama_wisata, dw.deskripsi, dw.alamat , dw.gambar
                FROM fav_wisata fw
                JOIN detail_wisata dw ON fw.id_wisata = dw.id_wisata
                WHERE fw.id_user = ?";
            break;
        case 'kuliner':
            $query = "SELECT dk.id_kuliner, dk.nama_kuliner, dk.deskripsi , dk.gambar
            FROM fav_kuliner fk
            JOIN detail_kuliner dk ON fk.id_kuliner = dk.id_kuliner
            WHERE fk.id_user = ?";
            break;
        case 'penginapan':
            $query = "SELECT dp.id_penginapan, dp.nama_penginapan, dp.deskripsi, dp.lokasi , dp.gambar
            FROM fav_penginapan fp
            JOIN detail_penginapan dp ON fp.id_penginapan = dp.id_penginapan
            WHERE fp.id_user = ?";
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak valid');
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorit = [];
    while ($row = $result->fetch_assoc()) {
        $favorit[] = $row;
    }

    jsonResponse('success', 'Daftar favorit berhasil ditampilkan', $favorit);
}

function cariFavorit($conn, $kategori, $id_user)
{
    $id_detail = $_POST['id_detail'] ?? ''; // Dapatkan id_detail dari permintaan POST

    switch ($kategori) {
        case 'wisata':
            $query = "SELECT dw.id_wisata, dw.nama_wisata, dw.deskripsi, dw.alamat 
                FROM fav_wisata fw
                JOIN detail_wisata dw ON fw.id_wisata = dw.id_wisata
                WHERE fw.id_user = ? AND fw.id_wisata = ?";
            break;
        case 'kuliner':
            $query = "SELECT dk.id_kuliner, dk.nama_kuliner, dk.deskripsi 
            FROM fav_kuliner fk
            JOIN detail_kuliner dk ON fk.id_kuliner = dk.id_kuliner
            WHERE fk.id_user = ? AND fk.id_kuliner = ?";
            break;
        case 'penginapan':
            $query = "SELECT dp.id_penginapan, dp.nama_penginapan, dp.deskripsi, dp.lokasi 
            FROM fav_penginapan fp
            JOIN detail_penginapan dp ON fp.id_penginapan = dp.id_penginapan
            WHERE fp.id_user = ? AND fp.id_penginapan = ?";
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak valid');
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_user, $id_detail); // bind dengan id_user dan id_detail
    $stmt->execute();
    $result = $stmt->get_result();

    $favorit = [];
    if ($row = $result->fetch_assoc()) {
        $favorit[] = $row; // Hanya ambil satu hasil jika ada
        jsonResponse('alreadyex', 'Hasil pencarian favorit', $favorit);
    } else {
        // Jika tidak ada data ditemukan
        jsonResponse('notfound', 'Tidak ada favorit ditemukan', []);
    }
}

function jsonResponse($status, $message, $data = null)
{
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
}
?>