@extends('user.layouts.default')

@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
  <div class="container" data-aos="fade-up">

    <div class="section-title text-start mt-5">
      <h4>Produk Kami</h4>
      {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
    </div>

    <div class="row">
      <div class="col-6">
        <form action="" method="GET" class="w-50">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Cari Produk" name="cari">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cari</button>
          </div>
        </form>
      </div>
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
    {{ $products->withQueryString()->links() }}
  </div>
</section><!-- End Sevices Section -->


@endsection

@push('after-script')
@endpush