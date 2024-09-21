<?php
include("../koneksi.php");

$conn = $koneksi;

$pengelolaQuery = "SELECT * FROM user WHERE role = 'pengelola'";
$result = mysqli_query($conn, $pengelolaQuery);
$jumlahPengelola = mysqli_num_rows($result); // Count the number of rows
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Pengelola</h1>
    <p class="mb-4">Informasi pengelola Nganjuk Visit</p>
    <div class="mb-3">
        <span class="badge me-3 badge-primary p-2 px-3 rounded-pill d-inline"><?= $jumlahPengelola ?></span>
        <div class="btn-group" role="group"
            aria-label="Basic outlined example">
            <button type="button" class="btn btn-lg btn-outline-danger">
                <i class="fa fa-bug"></i> Report Bug
            </button>
        </div>
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
                    echo '<td><span class="badge badge-success rounded-pill d-inline">' . htmlspecialchars($row['role']) . '</span></td>';
                    echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['gambar']) . '" alt="Gambar" style="width: 45px; height: 45px;" class="rounded-circle"></td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-link btn-sm btn-rounded">Edit</button>';
                    echo '<button type="button" class="btn btn-link btn-sm btn-rounded">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">Tidak ada data pengelola.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img
                            src="https://mdbootstrap.com/img/new/avatars/6.jpg"
                            class="rounded-circle"
                            alt=""
                            style="width: 45px; height: 45px" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1">Alex Ray</p>
                            <p class="text-muted mb-0">alex.ray@gmail.com</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1">Consultant</p>
                    <p class="text-muted mb-0">Finance</p>
                </td>
                <td>
                    <span class="badge badge-primary rounded-pill d-inline">Onboarding</span>
                </td>
                <td>Junior</td>
                <td>
                    <button
                        type="button"
                        class="btn btn-link btn-rounded btn-sm fw-bold"
                        data-mdb-ripple-color="dark">
                        Edit
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img
                            src="https://mdbootstrap.com/img/new/avatars/7.jpg"
                            class="rounded-circle"
                            alt=""
                            style="width: 45px; height: 45px" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1">Kate Hunington</p>
                            <p class="text-muted mb-0">kate.hunington@gmail.com</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1">Designer</p>
                    <p class="text-muted mb-0">UI/UX</p>
                </td>
                <td>
                    <span class="badge badge-warning rounded-pill d-inline">Awaiting</span>
                </td>
                <td>Senior</td>
                <td>
                    <button
                        type="button"
                        class="btn btn-link btn-rounded btn-sm fw-bold"
                        data-mdb-ripple-color="dark">
                        Edit
                    </button>
                </td>
            </tr> -->
<?php
mysqli_close($conn);
?>