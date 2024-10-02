<?php
include("../koneksi.php");
$conn = $koneksi;

$id_user = $_SESSION['user_id'];

// Fetch user data from the database
function fetchUserData($conn, $id_user)
{
    $mysqlTampil = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($mysqlTampil);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$user = fetchUserData($conn, $id_user);

// Set the profile picture URL
$urlGambar = !empty($user['gambar']) ? "../public/gambar/" . $user['gambar'] : "../public/gambar/avatar_profile.jpg";

// Handle form submission for updating profile and uploading image
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    // Process image upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Generate new file name
            $newFileName = $id_user . '_' . time() . '.' . $fileExtension;
            $uploadFileDir = '../public/gambar/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the uploaded file and update the database
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Hapus gambar lama jika bukan avatar default
                if (!empty($user['gambar']) && $user['gambar'] !== 'avatar_profile.jpg') {
                    $oldFilePath = $uploadFileDir . $user['gambar'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Hapus gambar lama
                    }
                }

                // Update gambar di database
                $updateGambarQuery = "UPDATE user SET gambar = ? WHERE id_user = ?";
                $stmt = $conn->prepare($updateGambarQuery);
                $stmt->bind_param("si", $newFileName, $id_user);
                $stmt->execute();
                $urlGambar = "../public/gambar/" . $newFileName; // Update image URL
            } else {
                echo 'Error moving the uploaded file.';
            }
        } else {
            echo 'Invalid file type. Only JPG, JPEG, and PNG are allowed.';
        }
    }

    // Update user details in the database
    $updateQuery = "UPDATE user SET nama = ?, role = ?, alamat = ?, email = ? WHERE id_user = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $name, $role, $alamat, $email, $id_user);
    $stmt->execute();

    // Fetch the updated user data
    $user = fetchUserData($conn, $id_user);

    $_SESSION['profile_update'] = "Profil berhasil diperbarui.";
}
?>

<div class="container-fluid">
    <div class="container-xl px-4 mt-4">

        <?php if (isset($_SESSION['profile_update'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['profile_update']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['profile_update']); ?>
        <?php endif; ?>

        <hr class="mt-0 mb-2">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Foto Profil</div>
                    <div class="card-body text-center mb-2">
                        <img class="img-account-profile img-fluid rounded-circle w-100"
                            src="<?= htmlspecialchars($urlGambar) ?>"
                            alt="Foto Profil" style="max-width: 200px; height: auto;">
                        <div class="small font-italic text-muted mb-4">JPG atau PNG</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Detail Akun</div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="small mb-1" id="inputFoto">Upload Gambar Baru</label>
                                <input type="file" name="foto" class="form-control mb-3" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputName">Nama</label>
                                <input class="form-control" id="inputName" type="text" name="name" value="<?= htmlspecialchars($user['nama']) ?>" required>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputRole">Role</label>
                                    <input class="form-control" id="inputRole" type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputAlamat">Alamat</label>
                                    <input class="form-control" id="inputAlamat" type="text" name="alamat" value="<?= htmlspecialchars($user['alamat']) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control" id="inputEmailAddress" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>