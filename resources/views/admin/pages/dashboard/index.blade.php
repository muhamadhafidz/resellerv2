@extends('admin.layouts.default')

@section('content')
{{-- {{  }} --}}
<div class="content">
    <div class="container-fluid">
      <h5 class="mb-2">Data Produk</h5>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Barang/Produk</span>
              <span class="info-box-number">{{ App\Product::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Produk Terjual</span>
              <span class="info-box-number">{{ App\Product::sum('terjual') }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        <!-- /.col -->
      </div>
      <h5 class="mb-2">Pesanan</h5>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Pesanan</span>
              <span class="info-box-number">{{ App\Transaction::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Pesanan Sukses</span>
              <span class="info-box-number">{{ App\Transaction::where('status', 'pesanan selesai')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Omzet Pesanan</span>
              <span class="info-box-number">Rp. {{ App\Transaction::where('status', 'pesanan selesai')->sum('total_bayar') + App\Transaction::where('status', 'pesanan selesai')->sum('ongkir') }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <h5 class="mb-2">Reseller</h5>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text text-wrap">Total Reseller</span>
              <span class="info-box-number">{{ App\User::where('roles', 'reseller')->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      
    </div>
</div>
<!-- Button trigger modal -->


@endsection

@push('after-script')
@endpush