<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.home') }}" class="brand-link text-center font-weight-bold">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-normal">Navil Store Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="mt-3 pb-3 mb-3 d-flex">
        
      </div>
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Cari Halaman" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw nav-icon"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item  {{ Request::is('admin/dashboard*') ? 'menu-open' : '' }}">
            
            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ Request::is('admin/produk*') ? 'menu-open' : '' }}">
            <a class="nav-link {{ Request::is('admin/produk*') ? 'active' : '' }}" href="">
              <i class="fas fa-shopping-basket nav-icon nav-icon"></i>
              <p>
                Produk
                {{-- <span class="right badge badge-danger">New</span> --}}
                <i class="right fas fa-angle-left nav-icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.produk.index') }}" class="nav-link {{ Request::is('admin/produk') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon nav-icon"></i>
                  <p>Data Produk <span class="right badge badge-light">{{ App\Product::count() }}</span></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.produk.create') }}" class="nav-link {{ Request::is('admin/produk/create') ? 'active' : '' }}">
                  <i class="fas fa-plus nav-icon nav-icon"></i>
                  <p>Tambah Produk</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('admin.pesanan.index') }}" class="nav-link {{ Request::is('admin/pesanan*') ? 'active' : '' }}">
              <i class="fas fa-boxes nav-icon"></i>
              <p>Pesanan <span class="right badge badge-light">{{ App\Transaction::count() }}</span></p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('admin/point-reseller*') ? 'menu-open' : '' }}">
            <a class="nav-link {{ Request::is('admin/point-reseller*') ? 'active' : '' }}" href="">
              <i class="fas fa-coins nav-icon nav-icon"></i>
              <p>
                Point Reseller
                {{-- <span class="right badge badge-danger">New</span> --}}
                <i class="right fas fa-angle-left nav-icon"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.point-reseller') }}" class="nav-link {{ Request::is('admin/point-reseller') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon nav-icon"></i>
                  <p>Data Point Reseller</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.point-reseller.riwayat') }}" class="nav-link {{ Request::is('admin/point-reseller/riwayat') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon nav-icon"></i>
                  <p>Riwayat point</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.point.index') }}" class="nav-link {{ Request::is('admin/point*') ? 'active' : '' }}">
              <i class="fas fa-clipboard-check nav-icon"></i>
              <p>Point</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.pelanggan.index') }}" class="nav-link {{ Request::is('admin/pelanggan*') ? 'active' : '' }}">
              <i class="fas fa-users nav-icon"></i>
              <p>Pelanggan</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>