<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="../public/assets/logo-sidebar.png" alt="logo-sidebare">
        </div>
        <div class="sidebar-brand-text mx-3">Nganjuk<sup>Visit</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Menu</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nganjuk Visit:</h6>
                <a class="collapse-item" href="admin_wisata.php">Wisata</a>
                <a class="collapse-item" href="admin_kuliner.php">Kuliner</a>
                <a class="collapse-item" href="admin_penginapan.php">Penginapan</a>
                <a class="collapse-item" href="admin_event.php">Event</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-users"></i>
            <span>Pengguna</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Role</h6>
                <a class="collapse-item" href="admin_pengelola.php">Pengelola</a>
                <a class="collapse-item" href="admin_user.php">User</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Ulasan
    </div>
    <li class="nav-item">
        <a class="nav-link" href="admin_ulasan.php">
            <i class="fas fa-fw fa-comment-alt"></i>
            <span>Ulasan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tiket
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="admin_boking_tiket.php">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Tiket Wisata</span></a>
    </li>
    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="admin_laporan_tiket.php">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan Data Tiket Wisata</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>