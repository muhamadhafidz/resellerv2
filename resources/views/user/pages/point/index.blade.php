@extends('user.layouts.default')

@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services" style="padding-bottom: 300px">
  <div class="container" data-aos="fade-up">

    <div class="row mt-4">
      <div class="col">
        <div class="card border-3">
          <div class="card-body text-center">
            <h6>Point Saya</h6>
            <h4 style="font-family: 'Open Sans', sans-serif">
              <b>{{ Auth::user()->user_points()->get()->last()->total_point }}</b>
            </h4>
            <a href="" class="btn btn-primary btn-sm">Tukarkan Point</a>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive mt-3">
      <table class="table" style="width: 100%">
        <thead>
          <tr>
            <th scope="col">Tanggal</th>
            <th scope="col">Invoice</th>
            <th scope="col">Point</th>
            <th scope="col">Total Point</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($points as $point)  
          <tr>
            <th scope="row">{{ $point->created_at->isoFormat('DD MMM YYYY') }}</th>
            <td>
                {{ $point->invoice }}
            </td>
            <td>
              @if ($point->keterangan == "masuk")
              <span class="text-success">+{{ $point->point }}</span>
              @else
              <span class="text-danger">-{{ $point->point }}</span>
              @endif
            </td>
            <td><b>{{ $point->total_point }}</b></td>
            <td>
              @if (strtolower($point->status) == "sukses" )
              <span class="badge bg-success text-light">{{ $point->status }}</span>
              @else
              <span class="badge bg-danger text-light">{{ $point->status }}</span>
              @endif
            </td>
            
          </tr>
          @empty
          <tr>
            <td class="text-center" colspan="5">
              Tidak ada riwayat point
              <br>
              <a href="{{ route('user.produk') }}">beli produk</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
      
    </div>
    
  </div>

  


   
</section><!-- End Sevices Section -->


@endsection

@push('after-script')
<script>
</script>
@endpush