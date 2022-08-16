<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <i class="fas fa-warehouse"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Inventori</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  @if (auth()->user()->level == 1)
  <!-- Heading -->
  <div class="sidebar-heading">
    Manajemen User
  </div>

  <!-- Nav Item - Tables -->
  <li class="nav-item {{ Request::is('dashboard/user') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/user">
      <i class="fas fa-fw fa-user"></i>
      <span>User</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  @endif

  @if (auth()->user()->level == 2)

  <!-- Heading -->
  <div class="sidebar-heading">
    Data Master
  </div>

  <!-- Nav Item - Charts -->
  <li class="nav-item {{ Request::is('dashboard/jenbar') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/jenbar">
      <i class="fas fa-th-large"></i>
      <span>Jenis Barang</span></a>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item {{ Request::is('dashboard/nambar') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/nambar">
      <i class="fas fa-fw fa-table"></i>
      <span>Nama Barang</span></a>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item {{ Request::is('dashboard/inventaris') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/inventaris">
      <i class="fa fa-boxes "></i>
      <span>Inventaris</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  @endif

  <!-- Heading -->
  <div class="sidebar-heading">
    Data Transaksi
  </div>
  @if (auth()->user()->level == 2)
  <!-- Nav Item - Charts -->
  <li class="nav-item {{ Request::is('dashboard/barang-masuk') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/barang-masuk">
      <i class="fas fa-plus-circle"></i>
      <span>Barang Masuk</span></a>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item {{ Request::is('dashboard/barang-keluar') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/barang-keluar">
      <i class="fas fa-minus-circle"></i>
      <span>Barang Keluar</span></a>
  </li>
  @endif

  <!-- Nav Item - Tables -->
  <li class="nav-item {{ Request::is('dashboard/laporan') ? 'active' : '' }}">
    <a class="nav-link" href="/dashboard/laporan">
      <i class="fas fa-file-alt"></i>
      <span>Laporan</span></a>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>