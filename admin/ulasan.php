<div class="container-fluid">
    <h1 class="mb-4">Menu Data Ulasan Nganjuk Visit</h1>
    <p class="mb-5">Kelola ulasan wisata, hotel, atau kuliner dari pengunjung Nganjuk Visit di sini.</p>
    <!-- alert hapus -->
    <?php if (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & refresh -->
    <div class="row mb-2 align-items-center">
        <div class="col-md-4 d-flex align-items-center">
            <select class="form-select me-2" id="categoryFilter">
                <option selected value="">Filter Kategori</option>
                <option value="ulasan_wisata">Wisata</option>
                <option value="ulasan_penginapan">Hotel</option>
                <option value="ulasan_kuliner">Kuliner</option>
            </select>
            <button class='btn btn-info' onclick="window.location.href='admin_ulasan.php'">
                <i class="fas fa-sync"></i>
            </button>
        </div>
    </div>

    <!-- Table Ulasan (Responsive) -->
    <div class="card">
        <div class="card-header">
            <h5>Data Ulasan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Id Ulasan</th>
                            <th>Id User</th>
                            <th>Nama Pengulas</th>
                            <th>Kategori</th>
                            <th>Isi Ulasan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ulasanTableBody">
                        <tr>
                            <td colspan="6" class="text-center">Pilih kategori untuk menampilkan data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus ulasan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- njikok data ulasan -->
<script>
    // Fungsi untuk mengambil data ulasan
    function loadData(category = '') {
        $.ajax({
            url: '../controllers/get_data_ulasan.php',
            type: 'GET',
            data: {
                category: category
            },
            success: function(response) {
                $('#ulasanTableBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }

    // Memuat semua data ulasan saat halaman pertama kali dimuat
    $(document).ready(function() {
        loadData(); // Memuat semua data ulasan

        // Ketika kategori diubah
        $('#categoryFilter').change(function() {
            var category = $(this).val();
            loadData(category); // Memuat data berdasarkan kategori
        });
    });
</script>

<!-- nyekel data ulasan pas arep di hapus -->
<script>
    // Fungsi untuk menangkap data ulasan yang akan dihapus
    $(document).on('click', '.btn-danger', function() {
        // Ambil data dari atribut data-category dan data-id
        categoryToDelete = $(this).data('category');
        idToDelete = $(this).data('id');

        // Tampilkan modal konfirmasi
        $('#confirmDeleteModal').modal('show');
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        // Pastikan kategori dan id sudah terisi sebelum redirect
        if (categoryToDelete && idToDelete) {
            window.location.href = "../controllers/hapus_ulasan.php?category=" + categoryToDelete + "&id_ulasan=" + idToDelete;
        }
    });
</script>