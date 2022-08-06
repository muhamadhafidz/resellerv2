@extends('user.layouts.default')

@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services" style="padding-bottom: 300px">
  <div class="container" data-aos="fade-up">

    <div class="section-title text-start mt-5">
      <h4>Keranjang Kamu</h4>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    <div class="table-responsive">
      <table class="table" style="width: 100%">
        <thead>
          <tr>
            <th style="width: 5%" scope="col">#</th>
            <th style="width: 10%" scope="col">Produk</th>
            <th style="width: 30%" scope="col"></th>
            <th style="width: 15%" scope="col"  class="text-center">Qty</th>
            <th style="width: 20%" scope="col">Total Harga</th>
            <th style="width: 20%" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
          $totalBayar = 0;    
          $totalPointSemua = 0;    
          @endphp  
          @forelse ($carts as $cart)  
          @php
          $totalBayar += $cart->product->harga * $cart->qty;    
          @endphp
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
              <img src="{{ $cart->product->product_images[0]->img_product }}" alt="" height="80px">
            </td>
            <td>
                {{ $cart->product->nama_barang }}
                <br>
               <b>Rp. {{ $cart->product->harga }}</b> <br>
               @php
                   $point = false;
                   $totalPoint = 0;
               @endphp
               @foreach ($cart->product->product_points as $item)
                @if ($cart->qty >= $item->min_beli)
                @php
                    $point = true;
                    $totalPoint = ($cart->product->harga * $cart->qty) * ( $item->point_persentase / 100 );
                @endphp
                @endif 
               @endforeach

               @if ($point)
               <div class="badge bg-success text-light mb-2 text-start">Point yang akan kamu dapatkan <br> dari produk ini sebesar {{ $totalPoint }} poin</div>
               @else    
               <div class="badge bg-danger text-light mb-2">Tidak mendapatkan point</div>
               @endif
               @php
                   $totalPointSemua += $totalPoint
               @endphp
            </td>
            <td class="text-center">{{ $cart->qty }} 
            </td>
            <td><b>Rp. {{ $cart->product->harga * $cart->qty }}</b></td>
            <td>
              <button class="d-inline btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#qtyProduct{{ $loop->iteration }}">ubah qty</button>
              <form class="d-inline" action="{{ route('user.keranjang.deleteCart', $cart->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm" type="submit"><span class="material-symbols-outlined" style="font-size: 15px">
                  delete
                  </span></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td class="text-center" colspan="6">
              Tidak ada produk dalam keranjang
              <br>
              <a href="{{ route('user.produk') }}">beli produk</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
      
    </div>

    <div class="row">
      <div class="col-md-4 offset-md-8">
        <div class="card">
          <div class="card-body">
            @if ($totalPointSemua != 0)
            <small class="text-success">Total Point yang akan kamu dapatkan <b>{{ $totalPointSemua }} point</b></small>
            @else
            <small class="text-danger">Tidak mendapatkan point</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 offset-md-8">
        <div class="card">
          <div class="card-body">
            
            <h5 class="fw-bold">Total Pembelian  : Rp. {{ $totalBayar }}</h5>
            
            @if ($carts->count() > 0)
                
              <form action="{{ route('user.keranjang.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100">CHECKOUT</button>
              </form>
              <small class="text-danger fst-italic">Harga belum termasuk ongkir (ongkos kirim). Ongkir akan ditambahkan setelah pesanan dikonfirmasi oleh admin</small>
            @else

              <button type="button" class="btn btn-secondary w-100">CHECKOUT</button>

            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @foreach ($carts as $cart)
      <!-- Modal -->
      <div class="modal fade" id="qtyProduct{{ $loop->iteration }}" tabindex="-1" aria-labelledby="qtyProduct{{ $loop->iteration }}Label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="qtyProduct{{ $loop->iteration }}Label">Ubah Jumlah</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <h5>Jumlah</h5>
              <form action="{{ route('user.keranjang.updateQty', $cart->id) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="mb-3 text-center">
                <button type="button" class="btn btn-primary btn-sm" onclick="remValQty('qtyProduct{{ $loop->iteration }}Value')"><span class="material-symbols-outlined" style="font-size: 12px">
                  remove
                  </span></button>
                <input type="number" class="form-control w-50 d-inline" id="qtyProduct{{ $loop->iteration }}Value" name="qty{{ $cart->id }}" value="{{ $cart->qty }}">
                <button type="button" class="btn btn-primary btn-sm" onclick="addValQty('qtyProduct{{ $loop->iteration }}Value')"><span class="material-symbols-outlined" style="font-size: 12px">
                  add
                  </span></button>
              </div>
              <button type="submit" class="btn btn-success">Ubah</button>
              </form>
            </div>
          </div>
        </div>
      </div>
  @endforeach
</section><!-- End Sevices Section -->


@endsection

@push('after-script')
<script>
  function remValQty(id) {
    let value = $('#'+id).val();
    
    $('#'+id).val(value-1);
  }
  function addValQty(id) {
    let value = $('#'+id).val();
    
    $('#'+id).val(parseInt(value)+1);
  }
</script>
@endpush