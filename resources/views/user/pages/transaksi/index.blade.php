@extends('user.layouts.default')

@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services" style="padding-bottom: 300px">
  <div class="container" data-aos="fade-up">

    <div class="section-title text-start mt-5">
      <h4>Pesanan Kamu</h4>
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
            <th style="width: 20%" scope="col">Invoice</th>
            <th style="width: 25%" scope="col">Produk</th>
            <th style="width: 15%" scope="col">Total Bayar</th>
            <th style="width: 5%" scope="col">Status</th>
            <th style="width: 20%" scope="col">keterangan</th>
            <th style="width: 15%" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($trans as $tran)  
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>
                {{ $tran->invoice }}
            </td>
            <td>
              {{ $tran->transaction_products[0]->nama_barang }} <br>
              @if ($tran->transaction_products->count() > 1)
              <button type="button" class="ps-0 btn btn-link btn-sm text-dark" data-bs-toggle="modal" data-bs-target="#etcBarang{{ $loop->iteration }}"><small>dan +{{ $tran->transaction_products->count() - 1 }} barang lainnya</small></button>
              @endif
            </td>
            <td><b>Rp. {{ $tran->total_bayar + $tran->ongkir }}</b> <br>
              @if (strtolower($tran->status) == "menunggu pembayaran" || strtolower($tran->status) == "pesanan diproses" || strtolower($tran->status) == "pesanan dikirim" || strtolower($tran->status) == "pesanan selesai")    
              <small class="text-success">sudah termasuk ongkir : Rp. {{ number_format( $tran->ongkir, 0,'','.') }}</small>
              @else
              <small class="text-danger">belum termasuk ongkir : Rp. -</small>    
              @endif</td>
            <td>
              @if (strtolower($tran->status) == "menunggu konfirmasi" || strtolower($tran->status) == "menunggu input ongkir")
              <span class="badge bg-secondary text-light">{{ $tran->status }}</span>
              @elseif (strtolower($tran->status) == "pesanan dibatalkan")
              <span class="badge bg-danger text-light">{{ $tran->status }}</span>
              @elseif (strtolower($tran->status) == "pesanan diproses" || strtolower($tran->status) == "menunggu pembayaran")
              <span class="badge bg-warning text-dark">{{ $tran->status }}</span>
              @if (strtolower($tran->status) == "menunggu pembayaran")
                  <button type="button" class="btn btn-link btn-sm" data-bs-toggle="modal" data-bs-target="#caraBayar"><small>cara melakukan pembayaran ?</small></button>
              @endif
              @elseif (strtolower($tran->status) == "pesanan selesai")
              <span class="badge bg-success text-light">{{ $tran->status }}</span>
              @elseif (strtolower($tran->status) == "pesanan dikirim")
              <span class="badge bg-primary text-light">{{ $tran->status }}</span>
              @endif
            </td>
            <td>{!! $tran->keterangan !!}</td>
            <td>
              @if (strtolower($tran->status) == "menunggu konfirmasi")
              <form class="d-inline" action="{{ route('user.transaksi.batal', $tran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-outline-danger btn-sm" type="submit">Batalkan Pesanan</button>
              </form>
              @elseif (strtolower($tran->status) == "pesanan dikirim")
              <a href="{{ route('user.transaksi.cetakInvoice', $tran->id) }}" class="btn btn-dark btn-sm text-light" type="button"><span class="material-symbols-outlined">
                print
                </span></a>
                <form class="d-inline" action="{{ route('user.transaksi.selesai', $tran->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <button class="btn btn-success btn-sm" type="submit">Konfirmasi pesanan selesai</button>
              </form>
              @elseif (strtolower($tran->status) == "pesanan dibatalkan")
              -
              @else
              <button class="btn btn-dark btn-sm text-light" type="button"><span class="material-symbols-outlined">
                print
                </span></button>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td class="text-center" colspan="6">
              Tidak ada transaksi
              <br>
              <a href="{{ route('user.produk') }}">beli produk</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
      
    </div>
  </div>

  @foreach ($trans as $tran)  
    
    @if ($tran->transaction_products->count() > 1)
    
    <div class="modal fade" id="etcBarang{{ $loop->iteration }}" tabindex="-1" aria-labelledby="etcBarang{{ $loop->iteration }}Label" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="#etcBarang{{ $loop->iteration }}Label">Daftar Produk {{ $tran->invoice }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @foreach ($tran->transaction_products as $product)
                <h6>{{ $product->nama_barang }}</h6>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    @endif
      
    @endforeach


    <div class="modal fade" id="caraBayar" tabindex="-1" aria-labelledby="caraBayarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="caraBayarLabel">Cara melakukan pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Silahkan melakukan transfer ke nomor rekening <br> <b class="text-success fs-4">0123912391293 a/n Navil Store</b>
            <br>
            Sebesar nominal yang harus dibayarkan
            <br>
            <br>
            Lakukan konfirmasi pembayaran ke nomor whatsapp <b>087273923923</b>, dengan menyertakan bukti dan juga nomor INVOICE pesanan
          </div>
        </div>
      </div>
    </div>
</section><!-- End Sevices Section -->


@endsection

@push('after-script')
<script>
</script>
@endpush