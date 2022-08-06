@extends('user.layouts.default')

@section('content')

<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs bg-white pt-5">
    <div class="container">
      <a href="{{ url()->previous() }}" class="btn btn-link text-primary text-decoration-none"><span class="material-symbols-outlined">
        arrow_back_ios
        </span> 
        <span class="align-top">
          Kembali
        </span>
      
      </a>

    </div>
  </section><!-- End Breadcrumbs -->
  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details pt-0">
    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-6">
          <div class="portfolio-details-slider swiper">
            <div class="swiper-wrapper align-items-center">

              @foreach ($product->product_images as $images)    
              <div class="swiper-slide">
                <img src="{{ asset($images->img_product) }}" alt="">
              </div>
              @endforeach

            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <div class="col-lg-6">
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <div class="portfolio-description">
            <h2>{{ $product->nama_barang }}</h2>
            <h4>Rp. {{ $product->harga }}</h4>
            <p>
              {!! $product->deskripsi !!}
            </p>
          </div>
          <div class="portfolio-info">
            <h3>Informasi Produk</h3>
            <ul>
              <li><strong>Stok</strong>: {{ $product->stok }}</li>
              <li><strong>Terjual</strong>: {{ $product->terjual }}</li>
              <li>
                <div class="alert alert-primary" role="alert">
                  @foreach ($product->product_points as $item)
                      Pembelian minimal {{ $item->min_beli }} barang, akan mendapatkan point sebesar {{ $item->point_persentase }}% dari total harga barang
                      <br>
                  @endforeach
                </div>
              </li>
            </ul>
            <div class="row">
              <div class="col-md-8">
                <form method="POST" action="{{ route('user.produk.addKeranjang', $product->id) }}">
                  @csrf
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <input class="form-control form-control-lg @error('qty') is-invalid @enderror" type="number" value="1" name="qty" >
                      <button class="btn btn-success" type="submit" id="button-addon2">Tambah Ke Keranjang</button>
                      @error('img_user')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Portfolio Details Section -->
</main>
@endsection

@push('after-script')
@endpush