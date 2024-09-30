<div class="container-fluid">
    <h1 class="mb-4">Menu Data Ulasan Nganjuk Visit</h1>
    <p class="mb-5">Kelola ulasan wisata, hotel, atau kuliner dari pengunjung Nganjuk Visit di sini.</p>

    <!-- Filter & Search -->
    <div class="row mb-2">
        <form class="col-sm-4 mb-2 d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        <div class="col-md-4">
            <select class="form-select" id="categoryFilter">
                <option selected value="">Filter Kategori</option>
                <option value="ulasan_wisata">Wisata</option>
                <option value="ulasan_penginapan">Hotel</option>
                <option value="ulasan_kuliner">Kuliner</option>
            </select>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Fungsi untuk mengambil data ulasan
    function loadData(category = '') {
        $.ajax({
            url: '../controllers/get_data_ulasan.php',
            type: 'GET',
            data: { category: category },
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
        loadData();  // Memuat semua data ulasan

        // Ketika kategori diubah
        $('#categoryFilter').change(function() {
            var category = $(this).val();
            loadData(category);  // Memuat data berdasarkan kategori
        });
    });
</script>
