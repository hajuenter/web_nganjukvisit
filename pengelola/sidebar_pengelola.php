   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center">
           <div class="sidebar-brand-icon rotate-n-15">
               <img src="../public/assets/logo-sidebar.png" alt="">
           </div>
           <div class="sidebar-brand-text mx-3">Pengelola <sup>Nganjuk Visit</sup></div>
       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">


       <!-- Divider -->
       <hr class="sidebar-divider">

       <div class="sidebar-heading mt-5">
           Pengelola Wisata
       </div>

       <?php
        // Mendapatkan nama file saat ini
        $currentPage = basename($_SERVER['PHP_SELF']);

        // Fungsi untuk mengecek apakah halaman saat ini aktif
        function isActive($page)
        {
            global $currentPage;
            return $currentPage === $page ? 'active' : '';
        }
        ?>

       <!-- Nav Item - Wisata Nganjuk Visit -->
       <li class="nav-item <?= isActive('index.php') ?>">
           <a class="nav-link" href="index.php">
               <i class="fas fa-fw fa-map-signs"></i>
               <span>Wisata Nganjuk Visit</span>
           </a>
       </li>

       <!-- Heading -->
       <div class="sidebar-heading mt-3">
           Pengelola Tiket Wisata
       </div>

       <!-- Nav Item - Tiket Wisata Nganjuk Visit -->
       <li class="nav-item <?= isActive('pengelola_konfir_tiket.php') ?>">
           <a class="nav-link" href="pengelola_konfir_tiket.php">
               <i class="fas fa-fw fas fa-tags"></i>
               <span>Tiket Wisata</span>
           </a>
       </li>
       <li class="nav-item <?= isActive('pengelola_scan_tiket.php') ?>">
           <a class="nav-link" href="pengelola_scan_tiket.php">
               <i class="fas fa-fw fas fa-qrcode"></i>
               <span>Scan Tiket</span>
           </a>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider d-none d-md-block">

       <!-- Sidebar Toggler (Sidebar) -->
       <div class="text-center d-none d-md-inline">
           <button class="rounded-circle border-0" id="sidebarToggle"></button>
       </div>


   </ul>
   <!-- End of Sidebar -->