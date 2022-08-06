@extends('admin.layouts.default')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col">
                                <a href="" class="text-dark font-weight-bold"><i class="right fas fa-angle-left"></i> kembali</a>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <h4 class="card-title font-weight-normal">Buat Produk Baru</h4>
                            </div>
                        </div>
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
                    <div class="card-body mx-5">
                        {{-- {{ route('admin.matkul.store') }} --}}
                        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" id="form">
                            @csrf
                            <h5>Informasi Produk</h5>
                            <h6 class="text-danger">* Wajib diisi</h6>
                              
                            {{-- <hr> --}}
                            <div class="form-group">
                                <label for="name">Nama Produk<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"  id="nama_barang" name="nama_barang" value="{{ old('nama_barang') ? old('nama_barang') : '' }}" required>
                                @error('nama_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                                <textarea class="description form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="15" required>{{ old('deskripsi') ? old('deskripsi') : '' }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <hr> --}}
                            {{-- <h6>Foto Produk</h6> --}}
                            <div class="form-group mb-5">
                                <label for="name">Foto Produk<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="offset-md-2 col-md-2 col-12 mb-3 text-center">
                                        <a href="" onclick="inputFoto1(event)" >
                                            <img src="{{ asset('assets/admin/img/add-foto.png') }}" class="img-thumbnail" id="foto1" alt="...">
                                        </a>
                                        <input class="@error('image1') is-invalid @enderror" type="file" name="image1" id="image1" onchange="changeFoto1(this)" accept="image/png, image/jpg, image/jpeg" hidden>
                                        <h6 class="text-center mt-2 mb-0">Foto utama</h6>
                                        <div class="ubah pt-0">
                                            <button type="button" class="btn btn-warning mt-2 btn-sm" id="ubah-0">Pilih Foto</button>
                                        </div>
                                        @error('image1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class=" col-md-2 col-12 mb-3 text-center">
                                        <a href="" onclick="inputFoto2(event)">
                                            <img src="{{ asset('assets/admin/img/add-foto.png') }}" class="img-thumbnail" alt="..."  id="foto2" accept="image/png, image/jpg, image/jpeg">
                                        </a>
                                        <input class="@error('image2') is-invalid @enderror" type="file" name="image2" id="image2"  onchange="changeFoto2(this)" style="display: none">
                                        <h6 class="text-center mt-2 mb-0">Foto 1</h6>
                                        <div class="ubah pt-0">
                                            <button type="button" class="btn btn-warning mt-2 btn-sm" id="ubah-1">Pilih Foto</button>
                                        </div>
                                        @error('image2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 col-12 mb-3 text-center">
                                        <a href="" onclick="inputFoto3(event)">
                                            <img src="{{ asset('assets/admin/img/add-foto.png') }}" class="img-thumbnail" alt="..." id="foto3" accept="image/png, image/jpg, image/jpeg">
                                        </a>
                                        <input class="@error('image3') is-invalid @enderror" type="file" name="image3" id="image3"  onchange="changeFoto3(this)" style="display: none">
                                        <h6 class="text-center mt-2 mb-0">Foto 2</h6>
                                        <div class="ubah pt-0">
                                            <button type="button" class="btn btn-warning mt-2 btn-sm" id="ubah-2">Pilih Foto</button>
                                        </div>
                                        @error('image3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 col-12 mb-3 text-center">
                                        <a href="" onclick="inputFoto4(event)">
                                            <img src="{{ asset('assets/admin/img/add-foto.png') }}" class="img-thumbnail" alt="..." id="foto4" accept="image/png, image/jpg, image/jpeg">
                                        </a>
                                        <input class="@error('image4') is-invalid @enderror" type="file" name="image4" id="image4"  onchange="changeFoto4(this)" style="display: none">
                                        <h6 class="text-center mt-2 mb-0">Foto 3</h6>
                                        <div class="ubah pt-0">
                                            <button type="button" class="btn btn-warning mt-2 btn-sm" id="ubah-3">Pilih Foto</button>
                                        </div>
                                        @error('image4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <hr>
                            {{-- <hr> --}}
                            <h5 class="mt-5">Informasi Penjualan
                            </h5>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <label for="price">Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') ? old('harga') : '' }}"required>
                                        @error('harga')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stok">Stok <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') ? old('stok') : '' }}" required>
                                        @error('stok')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <hr>
                            <h5 class="mt-5">Informasi Ketentuan Point Produk
                            </h5>
                            <div class="row">
                                <div class="col">
                                    <h6 class="mb-1 mt-3">Ketentuan 1 (wajib)</h6>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_beli1">Min. Pembelian</label>
                                                <input type="number" class="form-control @error('min_beli1') is-invalid @enderror" id="min_beli1" name="min_beli1" value="{{ old('min_beli1') ? old('min_beli1') : '' }}" required>
                                                @error('min_beli1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="point_persentase1">Persentase</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('point_persentase1') is-invalid @enderror" id="point_persentase1" name="point_persentase1" value="{{ old('point_persentase1') ? old('point_persentase1') : '' }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                  </div>
                                                @error('point_persentase1')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col border-right border-left">
                                    <h6 class="mb-1 mt-3">Ketentuan 2 (opsional)</h6>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_beli2">Min. Pembelian</label>
                                                <input type="number" class="form-control @error('min_beli2') is-invalid @enderror" id="min_beli2" name="min_beli2" value="{{ old('min_beli2') ? old('min_beli2') : '' }}" required>
                                                @error('min_beli2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="point_persentase2">Persentase</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('point_persentase2') is-invalid @enderror" id="point_persentase2" name="point_persentase2" value="{{ old('point_persentase2') ? old('point_persentase2') : '' }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                  </div>
                                                @error('point_persentase2')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1 mt-3">Ketentuan 3 (opsional)</h6>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_beli3">Min. Pembelian</label>
                                                <input type="number" class="form-control @error('min_beli3') is-invalid @enderror" id="min_beli3" name="min_beli3" value="{{ old('min_beli3') ? old('min_beli3') : '' }}" required>
                                                @error('min_beli3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="point_persentase3">Persentase</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('point_persentase3') is-invalid @enderror" id="point_persentase3" name="point_persentase3" value="{{ old('point_persentase3') ? old('point_persentase3') : '' }}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                  </div>
                                                @error('point_persentase3')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                            <label for="">Aktifkan Produk <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Produk akan ditampilkan dihalaman user"></i></label>
                            <div class="custom-control custom-switch ">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" value="t" onclick="status()">
                                <label class="custom-control-label" for="customSwitch1" ></label>
                              </div>
                            <hr>
                            {{-- <img src="{{ asset('assets/admin/img/hafidz1.jpg') }}"  alt="..."  id="crop-foto"> --}}
                            <div class="btn-bap text-right">
                                <button type="button" onclick="cekFoto()" class="btn btn-success">Tambah Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('before-style')
<link rel="stylesheet" href="{{ asset('assets/adminLte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/adminLte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
{{-- <link rel="stylesheet" href="https://unpkg.com/jcrop/dist/jcrop.css"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush
@push('after-script')
<script src="{{ asset('assets/adminLte/plugins/select2/js/select2.full.min.js') }}"></script>
{{-- <script src="https://unpkg.com/jcrop"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
        .create( document.querySelector( '#deskripsi' ), {
            // removePlugins: [ 'insertImage', 'insertTable', 'insertMedia' ],
            toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link' ]
        } )
        .catch( error => {
            console.error( error );
        } );
        
        
        
        $(document).ready(function(){
            $('.category').select2();
            
            $('#ubah-0').click(function(event){
                inputFoto1(event);
            });
            $('#ubah-1').click(function(event){
                inputFoto2(event);
            });
            $('#ubah-2').click(function(event){
                inputFoto3(event);
            });
            $('#ubah-3').click(function(event){
                inputFoto4(event);
            });
            
            
        });

        function hapus1(that){
            // console.log($(that).text());
            $(that).remove();
            $('#image2').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto2').attr("src", route);
            $('#ubah-1').html('Pilih Foto');
        };
        function hapus2(that){
            // console.log($(that).text());
            $(that).remove();
            $('#image3').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto3').attr("src", route);
            $('#ubah-2').html('Pilih Foto');
        };
        function hapus3(that){
            // console.log($(that).text());
            $(that).remove();
            $('#image4').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto4').attr("src", route);
            $('#ubah-3').html('Pilih Foto');
        };
        
        function cekFoto(){
            if ($('#image1').val() == "") {
                kosong("utama");
            }else {
                $('#form').submit();
            }
        }

        function inputFoto1(event){
            event.preventDefault();
            
            $('#image1').click();
        }

        function inputFoto2(event){
            event.preventDefault();
            $('#image2').click();
        }

        function inputFoto3(event){
            event.preventDefault();
            $('#image3').click();
        }

        function inputFoto4(event){
            event.preventDefault();
            $('#image4').click();
        }
        
        function changeFoto1(input){
            var file = input.files[0];
 
            if(file){
                var reader = new FileReader();
                
    
                reader.onload = function(){
                    // console.log(reader.result);
                    $('#foto1').attr("src", reader.result);
                }
                
                reader.readAsDataURL(file);
                $('#ubah-0').html('Ubah Foto');
            }
        }
        function changeFoto2(input){
            var file = input.files[0];
 
            if(file){
                var reader = new FileReader();
                
    
                reader.onload = function(){
                    // console.log(reader.result);
                    $('#foto2').attr("src", reader.result);
                }
    
                reader.readAsDataURL(file);
                $('#ubah-1').html('Ubah Foto');
                if ($('#imghapus1').length == 0) {
                    $('#ubah-1').after('<button type="button" class="btn btn-link btn-sm text-danger" id="imghapus1" onclick="hapus1(this)">Hapus Foto</button>');
                }
            }
        }
        function changeFoto3(input){
            var file = input.files[0];
 
            if(file){
                var reader = new FileReader();
                
    
                reader.onload = function(){
                    // console.log(reader.result);
                    $('#foto3').attr("src", reader.result);
                }
    
                reader.readAsDataURL(file);
                $('#ubah-2').html('Ubah Foto');
                if ($('#imghapus2').length == 0) {
                    $('#ubah-2').after('<button type="button" class="btn btn-link btn-sm text-danger" id="imghapus2" onclick="hapus2(this)">Hapus Foto</button>');
                }
            }
        }

        function changeFoto4(input){
            var file = input.files[0];
 
            if(file){
                var reader = new FileReader();
                
    
                reader.onload = function(){
                    // console.log(reader.result);
                    $('#foto4').attr("src", reader.result);
                }
    
                reader.readAsDataURL(file);
                $('#ubah-3').html('Ubah Foto');
                if ($('#imghapus3').length == 0) {
                    $('#ubah-3').after('<button type="button" class="btn btn-link btn-sm text-danger" id="imghapus3" onclick="hapus3(this)">Hapus Foto</button>');
                }
            }
        }

       
        function status(){
            
            if ($('#customSwitch1').prop("checked") == true) {
                $('#customSwitch1').val("y");
            }else {
                $('#customSwitch1').val("t");
            }
        }

        function kosong(id){
            Swal.fire({
            title: 'Pilih foto '+id+' terlebih dahulu',
            text: "",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Oke'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                }
            });
        }
    </script>
@endpush