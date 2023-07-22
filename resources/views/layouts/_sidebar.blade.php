<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('jenis-approval*') ? 'active' : '' }}">
        <a class="nav-link" href="/jenis-approval">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Jenis Approval</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('karyawan*') ? 'active' : '' }}">
        <a class="nav-link" href="/karyawan">
            <i class="fas fa-fw fa-users"></i>
            <span>Karyawan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-user"></i>
            <span>Pengguna</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('pejabat-approval*') ? 'active' : '' }}">
        <a class="nav-link" href="/pejabat-approval">
            <i class="fas fa-fw fa-check"></i>
            <span>Pejabat Approval</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('jenis-transaksi-penerimaan*') || Request::is('jenis-transaksi-pengeluaran*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="false" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Jenis Transaksi</span>
        </a>
        <div id="collapseTwo" class="collapse {{ Request::is('jenis-transaksi-penerimaan*') || Request::is('jenis-transaksi-pengeluaran*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar"
            style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('jenis-transaksi-penerimaan*') ? 'active' : '' }}" href="/jenis-transaksi-penerimaan">Penerimaan</a>
                <a class="collapse-item {{ Request::is('jenis-transaksi-pengeluaran*') ? 'active' : '' }}" href="/jenis-transaksi-pengeluaran">Pengeluaran</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
