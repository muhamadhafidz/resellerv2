@extends('user.layouts.default')

@section('content')

<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs bg-white pt-5">
    <div class="container">
      <a href="{{ route('user.home') }}" class="btn btn-link text-primary text-decoration-none"><span class="material-symbols-outlined">
        arrow_back_ios
        </span> 
        <span class="align-top">
          Halaman Utama
        </span>
      
      </a>

    </div>
  </section><!-- End Breadcrumbs -->
  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details pt-0">
    <div class="container">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <div class="card">
        <div class="card-body">
          <div class="row" style="height: 500px">
            <div class="col-md-6">
              <div class="text-center pt-5">
                <img src="{{ Auth::user()->img_user == "-" ? asset('assets/admin/img/default-avatar.png') : Auth::user()->img_user }}" alt=""  class="rounded-circle" height="200px">
                <div class="mt-3">
                  <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fotoModal">Ubah Foto</button>
                  <!-- Modal -->
                  <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah Data Profil</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('user.profil.updateFoto') }}"  enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                          <div class="modal-body">
                            <div class="form-group mt-3">
                                <label for="img_user">Foto</label>
                                <input id="img_user" type="file" class="form-control @error('img_user') is-invalid @enderror" name="img_user" required autocomplete="img_user" autofocus>
                                @error('img_user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-warning">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class=" pt-5">
                <h5 class="font-weight-bold">Nama</h5>
                <p>{{ Auth::user()->nama }}</p>
                <h5 class="font-weight-bold">Username</h5>
                <p>{{ Auth::user()->username }}</p>
                <h5 class="font-weight-bold">Email</h5>
                <p>{{ Auth::user()->email }}</p>
                <h5 class="font-weight-bold">Nomor Telepon</h5>
                <p>{{ Auth::user()->no_hp }}</p>
                <h5 class="font-weight-bold">Alamat</h5>
                <p>{{ Auth::user()->alamat }}</p>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Ubah Profil
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Data Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="POST" action="{{ route('user.profil.updateData') }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                          <div class="form-group mt-3">
                              <label for="nama">Nama</label>
                              <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?: Auth::user()->nama  }}" required autocomplete="nama" autofocus>
      
                              @error('nama')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label for="username">Username</label>
                              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?: Auth::user()->username }}" required autocomplete="username" autofocus>
      
                              @error('username')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label for="no_hp">Nomor Telepon</label>
                              <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') ?: Auth::user()->no_hp }}" required autocomplete="no_hp" autofocus>
      
                              @error('no_hp')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label for="email">Email</label>
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?: Auth::user()->email }}" required autocomplete="email">
      
                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group mt-3">
                              <label for="alamat" class="form-label">Alamat</label>
                              <textarea id="alamat" type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required autocomplete="alamat">{{ old('alamat') ?: Auth::user()->alamat }}</textarea>
      
                              @error('alamat')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#gantiPass">
                  Ubah Password
              </button>
              <div class="modal fade" id="gantiPass" tabindex="-1" aria-labelledby="ganti-pass" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ganti-pass">Ganti Foto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.profil.updatePassword') }}" id="pass-form" enctype="multipart/form-data">
                            {{-- @method('PUT') --}}
                            @csrf
                            <div class="form-group">
                                <label for="password_old">Password Lama</label>
                                <input type="password" class="form-control" id="password_old" name="password_old" required >
                            </div>
                            <div class="form-group">
                                <label for="password_new">Password Baru</label>
                                <input type="password" class="form-control" id="password_new" name="password_new" required>
                            </div>
                            <div class="form-group">
                                <label for="password_new_konf">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_new_konf" name="password_confirm" required>
                            </div>
                            <button type="submit" class="btn btn-primary " id="submit-form" hidden>Simpan</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="button" onclick="submitPass()" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
            </div>
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