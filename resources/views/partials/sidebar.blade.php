<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/sb-admin/img/ship.png') }}" alt="Logo" width="30"> <!-- Ganti dengan path logo Anda -->
        </div>
        <div class="sidebar-brand-text mx-3">Perkapalan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen
    </div>

    <!-- Nav Item - Absensi -->
    <li class="nav-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('absensi.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Absensi</span>
        </a>
    </li>

    <!-- Nav Item - Anggota -->
    <li class="nav-item {{ request()->routeIs('anggota.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('anggota.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Anggota</span>
        </a>
    </li>

    <!-- Nav Item - Slip Gaji -->
    <li class="nav-item {{ request()->routeIs('gaji.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gaji.index') }}">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Slip Gaji</span>
        </a>
    </li>

    <!-- Nav Item - Informasi -->
    <li class="nav-item {{ request()->routeIs('informasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('informasi.index') }}">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Informasi</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->