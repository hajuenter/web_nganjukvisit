<?php
header("Content-Type: application/json");
include_once '../koneksi.php';
include 'jsonResponse.php';

// Mendapatkan parameter `action`
$action = $_GET['action'] ?? '';

switch ($action) {
    // Rekomendasi
    case 'rekomendasi_penginapan':
    case 'rekomendasi_wisata':
    case 'rekomendasi_kuliner':
    case 'rekomendasi_event':
        $kategori = str_replace('rekomendasi_', '', $action);
        getRekomendasi($kategori);
        break;

    // Detail
    case 'detail_penginapan':
    case 'detail_wisata':
    case 'detail_kuliner':
    case 'detail_event':
        $kategori = str_replace('detail_', '', $action);
        getDetailById($kategori);
        break;

    // Ulasan
    case 'get_all_ulasan':
        getAllUlasan();
        break;
    case 'add_ulasan':
        addUlasan();
        break;
    case 'edit_ulasan':
        editUlasan();
        break;
    case 'delete_ulasan':
        deleteUlasan();
        break;

    // Pencarian berdasarkan key dan value
    case 'search_home':
        searchInTables();
        break;
    case 'search_all':
        searchAllColumns();
        break;
    case 'notif':
        Notifikasi();
        break;

    default:
        jsonResponse(400, 'Aksi tidak dikenali');
}

// Fungsi Rekomendasi
function getRekomendasi($kategori)
{
    global $koneksi;

    switch ($kategori) {
        case 'penginapan':
            $data = getPenginapanTerpopuler($koneksi);
            break;
        case 'wisata':
            $data = getWisataTerpopuler($koneksi);
            break;
        case 'kuliner':
            $data = getKulinerTerpopuler($koneksi);
            break;
        case 'event':
            $data = getEventTerpopuler($koneksi);
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak dikenali');
            return;
    }

    jsonResponse('success', "Rekomendasi $kategori berhasil diambil", $data);
}

function getPenginapanTerpopuler($conn)
{
    $query = "SELECT * FROM detail_penginapan ORDER BY total_rating DESC LIMIT 10";
    return fetchData($conn, $query);
}

function getWisataTerpopuler($conn)
{
    $query = "SELECT * FROM detail_wisata ORDER BY total_rating DESC LIMIT 10";
    return fetchData($conn, $query);
}

function getKulinerTerpopuler($conn)
{

    $query = "
        SELECT dk.id_kuliner, dk.nama_kuliner, dk.deskripsi, dk.harga, dk.gambar, COUNT(fk.id_fav) AS jumlah_favorit
        FROM detail_kuliner dk
        LEFT JOIN fav_kuliner fk ON dk.id_kuliner = fk.id_kuliner
        GROUP BY dk.id_kuliner
        ORDER BY jumlah_favorit DESC";
    return fetchData($conn, $query);
}

function getEventTerpopuler($conn)
{
    $query = "SELECT * FROM detail_event ORDER BY tanggal_event DESC LIMIT 10";
    return fetchData($conn, $query);
}

// Fungsi untuk mengambil detail berdasarkan kategori dan id_detail
function getDetailById($kategori)
{
    global $koneksi;
    $id_detail = $_GET['id_detail'] ?? '';

    if (empty($id_detail)) {
        jsonResponse('invalid', 'ID detail tidak boleh kosong');
        return;
    }

    switch ($kategori) {
        case 'penginapan':
            $query = "SELECT * FROM detail_penginapan WHERE id_penginapan = ?";
            break;
        case 'wisata':
            $query = "SELECT * FROM detail_wisata WHERE id_wisata = ?";
            break;
        case 'kuliner':
            $query = "SELECT * FROM detail_kuliner WHERE id_kuliner = ?";
            break;
        case 'event':
            $query = "SELECT * FROM detail_event WHERE id_event = ?";
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak dikenali');
            return;
    }

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_detail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        jsonResponse('success', 'Detail berhasil diambil', $row);
    } else {
        jsonResponse('not_found', 'Detail tidak ditemukan');
    }
}


// Fungsi Ulasan
function getAllUlasan()
{
    global $koneksi;
    $table = $_GET['table'] ?? ''; // Nama tabel ulasan
    $id_foreign = $_GET['id_foreign'] ?? ''; // ID entitas (wisata, kuliner, penginapan)
    $id_user = $_GET['id_user'] ?? ''; // ID user untuk filter ulasan pengguna

    if (!in_array($table, ['ulasan_wisata', 'ulasan_penginapan'])) {
        jsonResponse('invalid', 'Nama tabel ulasan tidak valid');
        return;
    }

    if (empty($id_foreign) && empty($id_user)) {
        jsonResponse('invalid', 'ID entitas atau ID user harus disediakan');
        return;
    }

    // Menentukan kolom foreign key berdasarkan tabel ulasan
    $foreign_key_column = match ($table) {
        'ulasan_wisata' => 'id_wisata',
        'ulasan_penginapan' => 'id_penginapan',
    };

    // Query dasar
    $query = "SELECT * FROM $table WHERE 1=1";
    $params = [];
    $types = "";

    // Menambahkan filter berdasarkan foreign key (entitas)
    if (!empty($id_foreign)) {
        $query .= " AND $foreign_key_column = ?";
        $params[] = $id_foreign;
        $types .= "i";
    }

    // Menambahkan filter berdasarkan ID user
    if (!empty($id_user)) {
        $query .= " AND id_user = ?";
        $params[] = $id_user;
        $types .= "i";
    }

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $ulasan = [];
    while ($row = $result->fetch_assoc()) {
        $ulasan[] = $row;
    }

    if (!empty($ulasan)) {
        jsonResponse('success', 'Ulasan berhasil diambil', $ulasan);
    } else {
        jsonResponse('not_found', 'Tidak ada ulasan yang sesuai');
    }
}



function addUlasan()
{
    global $koneksi;
    $table = $_POST['table'] ?? '';
    $fields = ['id_user', 'nama', 'komentar', 'rating', 'id_foreign'];

    if (!in_array($table, ['ulasan_wisata', 'ulasan_penginapan'])) {
        jsonResponse('invalid', 'Nama tabel ulasan tidak valid');
        return;
    }

    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            jsonResponse('invalid', "$field tidak boleh kosong");
            return;
        }
    }

    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $komentar = $_POST['komentar'];
    $rating = $_POST['rating'];
    $id_foreign = $_POST['id_foreign'];

    // Menentukan tanggal saat ini
    $tanggal = date('Y-m-d');

    $query = "INSERT INTO $table (id_user, nama, komentar, tanggal, rating, id_" . substr($table, 7) . ") 
              VALUES ('$id_user', '$nama', '$komentar', '$tanggal', '$rating', '$id_foreign')";
    executeQuery($koneksi, $query, $komentar, 'Gagal menambah data');
}


function editUlasan()
{
    global $koneksi;
    $table = $_POST['table'] ?? '';
    $fields = ['nama', 'komentar', 'rating'];

    if (!in_array($table, ['ulasan_wisata', 'ulasan_penginapan'])) {
        jsonResponse('invalid', 'Nama tabel ulasan tidak valid');
        return;
    }

    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            jsonResponse('invalid', "$field tidak boleh kosong");
            return;
        }
    }

    $id_ulasan = $_POST['id_ulasan'] ?? null;
    $nama = $_POST['nama'];
    $komentar = $_POST['komentar'];
    $tanggal = date('Y-m-d');
    $rating = $_POST['rating'];


    // Jika `id_ulasan` tidak diberikan, ambil `id_ulasan` terbesar
    if (!$id_ulasan) {
        $idColumn = "id_ulasan_" . substr($table, 7, 1); // Tentukan nama kolom id_ulasan berdasarkan tabel
        $queryLastId = "SELECT $idColumn FROM $table ORDER BY $idColumn DESC LIMIT 1";
        $result = $koneksi->query($queryLastId);
        if ($result && $row = $result->fetch_assoc()) {
            $id_ulasan = $row[$idColumn];
        } else {
            jsonResponse('error', 'Gagal mengambil ID ulasan terakhir');
            return;
        }
    }

    // Update data berdasarkan `id_ulasan`
    $idColumn = "id_ulasan_" . substr($table, 7, 1);
    $query = "UPDATE $table SET nama='$nama', komentar='$komentar', tanggal='$tanggal', rating='$rating' 
              WHERE $idColumn='$id_ulasan'";

    if ($koneksi->query($query)) {
        jsonResponse('success', 'Data berhasil diperbarui', ['id_ulasan' => $id_ulasan]);
    } else {
        jsonResponse('error', 'Gagal memperbarui data');
    }
}


function deleteUlasan()
{
    global $koneksi;
    $table = $_POST['table'] ?? '';
    $id_pengguna = $_POST['id_user'] ?? '';
    $id_foreign = $_POST['id_foreign'] ?? '';

    // Validasi parameter input
    if (!in_array($table, ['ulasan_wisata', 'ulasan_penginapan']) || empty($id_pengguna) || empty($id_foreign)) {
        jsonResponse('invalid', 'Parameter tidak valid');
        return;
    }

    // Tentukan nama kolom id_foreign berdasarkan tabel
    $foreignKey = match ($table) {
        'ulasan_wisata' => 'id_wisata',
        'ulasan_kuliner' => 'id_kuliner',
        'ulasan_penginapan' => 'id_penginapan',
        default => null,
    };
    $Key = match ($table) {
        'ulasan_wisata' => "w",
        'ulasan_penginapan' => "p",
        default => null,
    };

    if (is_null($foreignKey)) {
        jsonResponse('invalid', 'Tabel tidak valid');
        return;
    }

    // Query untuk mendapatkan id_ulasan terakhir berdasarkan id_pengguna dan id_foreign
    $queryGetId = "SELECT id_ulasan_" . substr($table, 7, 1) . " AS id_ulasan 
                   FROM $table 
                   WHERE id_user = '$id_pengguna' AND $foreignKey = '$id_foreign' 
                   ORDER BY id_ulasan_$Key DESC LIMIT 1";

    $result = mysqli_query($koneksi, $queryGetId);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $id_ulasan = $data['id_ulasan'];

        // Lakukan penghapusan berdasarkan id_ulasan dan id_foreign yang ditemukan
        $queryDelete = "DELETE FROM $table 
                        WHERE id_ulasan_" . substr($table, 7, 1) . "='$id_ulasan' 
                        AND $foreignKey = '$id_foreign'";
        executeQuery($koneksi, $queryDelete, 'Data berhasil dihapus', 'Gagal menghapus data');
    } else {
        jsonResponse('invalid', 'Ulasan tidak ditemukan untuk id_pengguna dan id_foreign ini');
    }
}

//Searching
function searchInTables()
{
    global $koneksi;
    $keyword = $_POST['keyword'];
    // Cek apakah keyword tidak kosong
    if (empty($keyword)) {
        jsonResponse('invalid', 'Kata kunci pencarian tidak boleh kosong');
        return;
    }

    // Buat array untuk menampung hasil pencarian
    $result = [];

    // Query pencarian di tabel penginapan
    $query_penginapan = "SELECT * FROM detail_penginapan WHERE nama LIKE ? OR deskripsi LIKE ?";
    $stmt = $koneksi->prepare($query_penginapan);
    $search_term = '%' . $keyword . '%';
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result_penginapan = $stmt->get_result();
    while ($row = $result_penginapan->fetch_assoc()) {
        $result['penginapan'][] = $row;
    }

    // Query pencarian di tabel wisata
    $query_wisata = "SELECT * FROM detail_wisata WHERE nama LIKE ? OR deskripsi LIKE ?";
    $stmt = $koneksi->prepare($query_wisata);
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result_wisata = $stmt->get_result();
    while ($row = $result_wisata->fetch_assoc()) {
        $result['wisata'][] = $row;
    }

    // Query pencarian di tabel kuliner
    $query_kuliner = "SELECT * FROM detail_kuliner WHERE nama LIKE ? OR deskripsi LIKE ?";
    $stmt = $koneksi->prepare($query_kuliner);
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result_kuliner = $stmt->get_result();
    while ($row = $result_kuliner->fetch_assoc()) {
        $result['kuliner'][] = $row;
    }

    // Jika ada hasil pencarian, kirimkan sebagai respons
    if (!empty($result)) {
        jsonResponse('success', 'Hasil pencarian ditemukan', $result);
    } else {
        jsonResponse('not_found', 'Tidak ada hasil yang ditemukan');
    }
}


// Fungsi untuk mencari data pada semua kolom berdasarkan key dan value
function searchAllColumns()
{
    global $koneksi;

    $key = $_GET['key'] ?? '';  // Nama kategori (wisata, penginapan, kuliner)
    $value = $_GET['value'] ?? '';  // Nilai yang dicari

    if (empty($key) || empty($value)) {
        jsonResponse('invalid', 'Key dan value harus disediakan');
        return;
    }

    // Menentukan nama tabel berdasarkan key
    switch ($key) {
        case 'wisata':
            $table = 'detail_wisata';
            $columns = ['nama_wisata', 'deskripsi', 'alamat', 'harga_tiket', 'jadwal', 'gambar', 'koordinat', 'link_maps', 'no_hp_pengelola'];
            break;
        case 'penginapan':
            $table = 'detail_penginapan';
            $columns = ['nama_penginapan', 'deskripsi', 'lokasi', 'harga', 'gambar', 'link_maps'];
            break;
        case 'kuliner':
            $table = 'detail_kuliner';
            $columns = ['nama_kuliner', 'deskripsi', 'harga', 'gambar'];
            break;
        default:
            jsonResponse('invalid', 'Kategori tidak dikenali');
            return;
    }

    // Mencari di semua kolom yang relevan
    $query = "SELECT * FROM $table WHERE CONCAT_WS(' ', " . implode(', ', $columns) . ") LIKE ?";
    $stmt = $koneksi->prepare($query);
    $searchTerm = "%" . $value . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (!empty($data)) {
        jsonResponse('success', 'Data berhasil ditemukan', $data);
    } else {
        jsonResponse('not_found', 'Data tidak ditemukan');
    }
}
function Notifikasi()
{
    global $koneksi;

    // Mendapatkan parameter yang diterima dari request (misalnya GET)
    $judul = isset($_GET['judul']) ? $_GET['judul'] : '';  // Untuk pencarian berdasarkan judul
    $id_user = isset($_GET['id_user']) ? $_GET['id_user'] : '';  // Untuk pencarian berdasarkan id_user jika judul 'Tiket Wisata'
    $tipe = isset($_GET['tipe']) ? $_GET['tipe'] : '';  // Jenis notifikasi ('event' atau 'tiket')

    // Menyusun query berdasarkan kondisi yang diberikan
    if ($tipe == 'event') {
        // Jika tipe adalah 'event', kita hanya mencari yang berjudul "Event Baru"
        $query = "SELECT * FROM notifikasi WHERE judul LIKE ?";
        $param = "%Event Baru%";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param('s', $param);  // Menggunakan satu parameter 'judul'
    } elseif ($tipe == 'tiket') {
        // Jika tipe adalah 'tiket', kita mencari yang berjudul "Tiket Wisata" berdasarkan id_user
        $query = "SELECT * FROM notifikasi WHERE judul LIKE ? AND id_user = ?";
        $param = "%Tiket Wisata%";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param('si', $param, $id_user);  // Menggunakan dua parameter: 'judul' dan 'id_user'
    } else {
        // Jika tipe tidak valid atau kosong, kita bisa mengembalikan semua data
        // atau mengembalikan error jika tipe tidak ditemukan.
        $query = "SELECT * FROM notifikasi";
        $stmt = $koneksi->prepare($query);
    }

    // Eksekusi query
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Mengecek apakah ada data yang ditemukan
    if ($result->num_rows > 0) {
        $notifikasi = [];
        while ($row = $result->fetch_assoc()) {
            $notifikasi[] = $row;
        }
        // Menampilkan data dalam format JSONResponse
        echo jsonResponse('success', 'Data ditemukan', $notifikasi);
    } else {
        // Jika tidak ada data, tampilkan pesan
        echo jsonResponse('kosong', 'Tidak ada notifikasi');
    }

    // Menutup statement
    $stmt->close();
}



// Fungsi Utilitas
function fetchData($conn, $query)
{
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function executeQuery($conn, $query, $successMessage, $errorMessage)
{
    if ($conn->query($query)) {
        jsonResponse('success', $successMessage);
    } else {
        jsonResponse('error', $errorMessage);
    }
}
?>