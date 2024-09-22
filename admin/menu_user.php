<?php
include("../koneksi.php");

$conn = $koneksi;

$pengelolaQuery = "SELECT * FROM user WHERE role = 'user'";
$result = mysqli_query($conn, $pengelolaQuery);
$jumlahUser = mysqli_num_rows($result); // Count the number of rows
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data User</h1>
    <p class="mb-4">Informasi user Nganjuk Visit</p>
    <div class="mb-3">
        <span class="badge me-3 badge-success py-2 px-3 rounded-pill d-inline">Jumlah Pengguna : <?= $jumlahUser ?></span>
    </div>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Email</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Alamat</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td><span class="badge badge-info rounded-pill d-inline">' . htmlspecialchars($row['role']) . '</span></td>';
                    echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['gambar']) . '" alt="Gambar" style="width: 45px; height: 45px;" class="rounded-circle"></td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-link btn-sm btn-rounded">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">Tidak ada data pengguna.</td></tr>';
            }
            ?>
        </tbody>
        </tbody>
    </table>
</div>