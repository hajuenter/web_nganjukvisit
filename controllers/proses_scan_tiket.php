<?php
session_start();
include("../koneksi.php");
include("../base_url.php");
$conn = $koneksi;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_detail_tiket = $_POST['barcodeInput'];

    // Ambil data tiket berdasarkan id_detail_tiket
    $stmt = $conn->prepare("SELECT dt.*, dw.nama_wisata, dw.id_wisata FROM detail_tiket dt 
                            JOIN detail_wisata dw ON dt.id_wisata = dw.id_wisata 
                            WHERE dt.id_detail_tiket = ?");
    $stmt->bind_param("i", $id_detail_tiket);
    $stmt->execute();
    $result = $stmt->get_result();
    $tiket = $result->fetch_assoc();

    if ($tiket) {
        // Ambil user_id dari session untuk validasi akses
        $user_id = $_SESSION['user_id'];

        // Query untuk mendapatkan id_wisata dari tabel user berdasarkan user_id
        $queryWisata = "SELECT ket_wisata FROM user WHERE id_user = ?";
        $stmtWisata = $conn->prepare($queryWisata);
        $stmtWisata->bind_param("i", $user_id);
        $stmtWisata->execute();
        $resultWisata = $stmtWisata->get_result();
        $ket_wisata = $resultWisata->fetch_assoc()['ket_wisata'];

        // Cek apakah pengelola bisa memindai tiket ini (akses berdasarkan ket_wisata)
        if ($tiket['id_wisata'] != $ket_wisata) {
            echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan atau Anda tidak memiliki akses untuk memindai tiket ini.']);
            exit();
        }

        // Validasi status harus "berhasil"
        if ($tiket['status'] !== 'berhasil') {
            echo json_encode(['success' => false, 'message' => 'Tiket belum dikonfirmasi.']);
            exit();
        }

        // Validasi kadaluarsa berdasarkan tanggal_tiket
        $tanggal_tiket = strtotime($tiket['tanggal']);
        $tanggal_sekarang = strtotime(date('Y-m-d')); // Hanya membandingkan tanggal, bukan waktu

        if ($tanggal_sekarang > $tanggal_tiket) {
            echo json_encode(['success' => false, 'message' => 'Tiket sudah kadaluarsa.']);
            exit();
        }

        // Cek apakah tiket sudah pernah di-scan sebelumnya
        if ($tiket['status'] === 'digunakan') {
            echo json_encode(['success' => false, 'message' => 'Tiket ini sudah pernah di-scan.']);
            exit();
        }

        // Update status menjadi "digunakan"
        $stmt = $conn->prepare("UPDATE detail_tiket SET status = 'digunakan' WHERE id_detail_tiket = ?");
        $stmt->bind_param("i", $id_detail_tiket);
        $stmt->execute();

        echo json_encode([
            'success' => true,
            'message' => 'Tiket berhasil di-scan.',
            'nama_wisata' => $tiket['nama_wisata'],
            'harga' => $tiket['harga'],
            'jumlah' => $tiket['jumlah'],
            'total' => $tiket['total']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan.']);
    }
}
?>
