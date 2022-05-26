<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2 pb-4">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
            </a>
          </li>

          <li class="nav-header">MASTER</li>

          <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
              <i class="nav-icon fas fa-cube"></i><p>Kategori</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i><p>Produk</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-id-card"></i><p>Member</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-truck"></i><p>Supplier</p>
            </a>
          </li>

          <li class="nav-header">TRANSAKSI</li>

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i><p>Pengeluaran</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-download"></i><p>Pembelian</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-upload"></i><p>Penjualan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i><p>Transaksi Lama</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i><p>Transaksi Baru</p>
            </a>
          </li>

          <li class="nav-header">REPORT</li>

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i><p>Laporan</p>
            </a>
          </li>

          <li class="nav-header">SYSTEM</li>

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-users"></i><p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i><p>Setting</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="$('#logout-form').submit()">
              <i class="nav-icon fas fa-sign-out-alt"></i><p>Log Out</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <form method="post" action="{{ route('logout') }}" id="logout-form" class="d-none">
    @csrf
  </form>