

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center justify-content-between">

    <h1 class="logo"><a href="{{ route('user.home') }}">Navil Store</a></h1>
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.html" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt="" class="img-fluid"></a>-->

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto {{ Request::is('/') ? 'active' : '' }}" href="{{ route('user.home') }}">Home</a></li>
        <li><a class="nav-link scrollto {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('user.produk') }}">Produk</a></li>
        <li><a class="nav-link scrollto" href="#about">Tentang Kami</a></li>
        <li><a class="nav-link scrollto" href="#contact">Kontak</a></li>
        @auth
        <li><a class="nav-link scrollto {{ Request::is('keranjang*') ? 'active' : '' }}" href="{{ route('user.keranjang') }}">Keranjang ({{ Auth::user()->keranjang()->count() }})</a></li>
        <li class="dropdown"><a href="#"><span>{{ Auth::user()->nama }}</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="{{ route('user.point') }}">Point Saya {{ Auth::user()->user_points()->get()->last() ? Auth::user()->user_points()->get()->last()->total_point : 0 }}</a></li>
            <li><a href="{{ route('user.profil') }}">Profil</a></li>
            <li><a href="{{ route('user.pesanan') }}">Pesanan Saya ({{ Auth::user()->transaction()->count() }})</a></li>
            <li><a href="{{ route('user.tukarPoint') }}">Tukar Poin</a></li>
            <li>
              <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
            </li>
          </ul>
        </li>
        @else

        <li><a class="getstarted-login btn btn-outline-light scrollto" href="{{ route('login') }}">Masuk</a></li>
        <li><a class="getstarted scrollto" href="{{ route('register') }}">Daftar</a></li>
        @endauth
        
        
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->