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
            <select class="form-select">
                <option selected>Filter Kategori</option>
                <option value="1">Wisata</option>
                <option value="2">Hotel</option>
                <option value="3">Kuliner</option>
            </select>
        </div>
    </div>

    <!-- Table Ulasan (Responsive) -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Data Ulasan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Id Ulasan</th>
                            <th>Nama Pengulas</th>
                            <th>Kategori</th>
                            <th>Isi Ulasan</th>
                            <th>Tanggal</th>
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
                            <td>
                                <button class="btn btn-primary btn-sm mb-1 mb-lg-1"><i class="fas fa-eye"></i> Detail</button>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                        <!-- Tambahkan data ulasan lainnya di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>