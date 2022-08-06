@extends('user.layouts.default')

@section('content')
 

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-9 text-center">
        <h1>Gabung dengan kami dan dapatkan hadiahnya</h1>
        <h2>Website reseller pertama dengan hadiah liburan!</h2>
      </div>
    </div>
    <div class="text-center">
      <a href="{{ route('register') }}" class="btn-get-started scrollto">Mau jadi reseller</a>
    </div>

    <div class="row icon-boxes">
      <div class="col-md-12 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
        <div class="icon-box text-center">
          <div class="icon"><h3>1</h3></div>
          <h4 class="title"><a href="">Daftar</a></h4>
          <p class="description">Daftarkan diri anda untuk bergabung bersama kami</p>
        </div>
      </div>

      <div class="col-md-12 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon-box text-center">
          <div class="icon"><h3>2</h3></div>
          <h4 class="title"><a href="">Belanja</a></h4>
          <p class="description">Belanjakan produk kami untuk dapat meraih point yang melimpah</p>
        </div>
      </div>

      <div class="col-md-12 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
        <div class="icon-box text-center">
          <div class="icon"><h3>3</h3></div>
          <h4 class="title"><a href="">Tukar Point</a></h4>
          <p class="description">Tukarkan pointmu dengan berbagai hadiah menarik hingga liburan bersama kami</p>
        </div>
      </div>

    </div>
  </div>
</section><!-- End Hero -->

<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Produk Kami</h2>
      {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
    </div>

    <div class="row">
      @foreach ($products as $product)    
      <div class="col-lg-3 col-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration }}00">
        <a href="{{ route('user.produk.detail', $product->slug) }}" class="text-dark">
          <div class="icon-box iconbox-orange p-0 rounded" style="height: 26rem">
            <img src="{{ asset($product->product_images[0]->img_product) }}" class="card-img-top" alt="{{ $product->slug }}">
            <div class="card-body text-start">
              <div class="badge bg-info text-dark mb-2">Dapatkan {{ $product->product_points[0]->point_persentase }}% poin</div>
              <h6 class="card-title">{{ $product->nama_barang }}</h6>
              <h6 class="card-text fw-bold mb-0" style="font-family: 'Open Sans', sans-serif">Rp. {{ $product->harga }}</h6>
              
                  <small class="align-top">Stok {{ $product->stok }} | Terjual {{ $product->terjual }}</small>
                    
              
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
    <div class="text-center mt-5">
      <a href="{{ route('user.produk') }}" class="get-started-product btn btn-outline-light scrollto">Lihat produk lainnya</a>
    </div>
  </div>
</section><!-- End Sevices Section -->

<main id="main">

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Tentang Kami</h2>
      </div>

      <div class="row content">
        <div class="offset-3 col-6 ">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.
          </p>
          <ul>
            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
            <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit</li>
            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
          </ul>
        </div>
        
      </div>

    </div>
  </section><!-- End About Section -->


  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Contact</h2>
        
      </div>

      <div class="row mt-5">

        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p>info@example.com</p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Call:</h4>
              <p>+1 5589 55488 55s</p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">

          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>

        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

@endsection

@push('after-script')
@endpush