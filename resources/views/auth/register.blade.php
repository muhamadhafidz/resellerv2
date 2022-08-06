@extends('user.layouts.default-auth')

@section('content')
 
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center pt-0">
    <div class="container position-relative">
      <div class="row">
        
        
        <div class="col-lg-6 rounded"  data-aos="fade-left" data-aos-delay="100" style="background-color: #fdfdfe; border: 4px solid #f7f8f8;">
            <div class="m-5" >
                <h3>Daftar</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="name">Nama</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="no_hp">Nomor Telepon</label>
                        <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" required autocomplete="no_hp" autofocus>

                        @error('no_hp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="alamat">{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="repassword">Ulangi Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="col-lg-6 text-center" data-aos="fade-right" data-aos-delay="100">
            <h4>Sudah mempunyai akun ?</h4>
            <div class="text-center">
            <a href="{{ route('login') }}" class="btn-get-started scrollto">Login</a>
            <a href="{{ route('user.home') }}" class="btn-get-started-home scrollto">Kembali ke Halaman utama</a>
            </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->



  
@endsection

@push('after-script')

<script>
</script>
@endpush
