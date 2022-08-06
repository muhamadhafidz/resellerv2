@extends('user.layouts.default')

@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services" style="padding-bottom: 300px">
  <div class="container" data-aos="fade-up">
    <div class="section-title text-start mt-5">
      <h4>Produk yang dapat kamu tukar dengan point</h4>
    </div>

    <div class="row">
      @forelse ($points as $point)
          
      <div class="col-md-6">
        <div class="card mb-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-3">
              <img src="{{ $point->img_point }}" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-6">
              <div class="card-body">
                <h6 class="card-title">{{ $point->nama }}</h6>
                <p class="card-text">{{ $point->detail }}</p>
                
              </div>
            </div>
            <div class="col-md-3 align-self-center mx-auto text-center">
              @php
                  $pointUser = Auth::user()->user_points()->get()->last() ? Auth::user()->user_points()->get()->last()->total_point : 0;
              @endphp
              @if ($pointUser >= $point->req_point)
              <form action="{{ route('user.tukarPoint.ambil', $point->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-success btn-sm" type="submit"><small>{{ $point->req_point }} point</small></button>
              </form>
              @else
              <button type="button" class="btn btn-secondary btn-sm"><small>{{ $point->req_point }} point</small></button>    
              @endif
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col text-center">
        <h6>Tidak ada daftar penukaran point</h6>
      </div>
      @endforelse
    </div>
    
  </div>

  


   
</section><!-- End Sevices Section -->


@endsection

@push('after-script')
<script>
</script>
@endpush