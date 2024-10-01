<div class="container-fluid">
    <h2>Data Penginapan</h2>
    <p>Informasi penginapan atau hotel yang ada di kawasan Nganjuk</p>
    <form class="input-group mb-2" style="max-width: 700px;">
        <input type="search" class="form-control form-control-lg" placeholder="Search for something..." aria-label="Search" aria-describedby="button-addon2">
        <button class="btn btn-primary btn-lg" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
    </form>
    <!-- Button for Adding -->
    <button class="btn btn-success btn-md mb-lg-2" type="button" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> Add
    </button>
    <!-- Button for Refreshing -->
    <button class="btn btn-warning btn-md ms-2 mb-lg-2" onclick="window.location.href='admin_penginapan.php'" type="button">
        <i class="fas fa-sync-alt"></i> Refresh
    </button>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Lokasi</th>
                    <th>Gambar</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- modal tambahhh -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Penginapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="addForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>