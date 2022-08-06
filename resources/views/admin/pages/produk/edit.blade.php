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
                                <h4 class="card-title font-weight-normal">Edit Produk</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mx-5">
                        {{-- {{ route('admin.matkul.store') }} --}}
                        <form method="POST" action="{{ route('admin.produk.update', $item->id) }}" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <h5>Informasi Produk</h5>
                            <h6 class="text-danger">* Wajib diisi</h6>
                              
                            {{-- <hr> --}}
                            <div class="form-group">
                                <label for="nama_barang">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') ? old('nama_barang') : $item->nama_barang }}" required>
                                @error('nama_barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="5" required>{{ old('deskripsi') ? old('deskripsi') : $item->deskripsi }}</textarea>
                                
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <hr> --}}
                            {{-- <h6>Foto Produk</h6> --}}
                            <input type="hidden" name="hapusImage">
                            <div class="form-group mb-5">
                                <label for="name">Foto Produk</label>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    @for ($i = 0; $i <= 3; $i++)
                                    <div class="col-md-2 col-12 mb-3 text-center">
                                        <a href="" onclick="inputFoto{{ $i+1 }}(event)" >
                                            <img src="{{ isset($item->product_images[$i]->img_product) ? asset($item->product_images[$i]->img_product) : asset('assets/admin/img/add-foto.png') }}" class="img-thumbnail" id="foto{{ $i+1 }}" alt="..." >
                                        </a>
                                        <input class="@error('image{{ $i+1 }}') is-invalid @enderror" type="file" name="image{{ $i+1 }}" id="image{{ $i+1 }}" onchange="changeFoto{{ $i+1 }}(this)" accept="image/png, image/jpg, image/jpeg" hidden>
                                        @if ($i == 0)
                                            
                                            <h6 class="text-center mt-2">Foto utama <span class="text-danger">*</span></h6>
                                        @else
                                            <h6 class="text-center mt-2">Foto {{ $i }}</h6>
                                        @endif
                                        <div class="ubah pt-0">
                                            <button type="button" class="btn btn-warning btn-sm " id="ubah-{{ $i }}">Ubah Foto</button>
                                            @if ($i != 0 && isset($item->product_images[$i]->img_product))
                                            <button type="button" class="btn btn-link btn-sm text-danger" id="imghapus{{ $i }}" onclick="hapus{{ $i }}(this)">Hapus Foto</button>    
                                            @endif
                                        </div>
                                        @error('image{{ $i+1 }}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endfor
                                   
                                </div>
                                
                            </div>
                            <hr>
                            {{-- <hr> --}}
                            <h5 class="mt-5">Informasi Penjualan
                            </h5>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <label for="harga">Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') ? old('harga') : $item->harga }}" required>
                                        @error('harga')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="stok">Stok <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') ? old('stok') : $item->stok }}" required>
                                        @error('stok')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            

                            <h5 class="mt-5">Informasi Ketentuan Point Produk
                            </h5>
                            <div class="row">
                                @for ($i = 1; $i <= 3; $i++)            
                                <div class="col">
                                    <h6 class="mb-1 mt-3">Ketentuan {{ $i }} 
                                        @if ($i == 1)
                                         (wajib)
                                        @else
                                        (optional)
                                        <button class="btn btn-link btn-sm py-0" type="button" onclick="kosongkanfield('{{ $i }}')">kosongkan field</button>
                                        @endif
                                    @if($i <= $item->product_points->count() )
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_beli{{ $i }}">Min. Pembelian</label>
                                                <input type="number" class="form-control @error('min_beli{{ $i }}') is-invalid @enderror" id="min_beli{{ $i }}" name="min_beli{{ $i }}" value="{{ old('min_beli'.$i) ? old('min_beli'.$i) : $item->product_points[$i-1]->min_beli }}" {{ $i == 1 ? 'required' : '' }}>
                                                @error('min_beli'.$i)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="point_persentase{{ $i }}">Persentase</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('point_persentase'.$i) is-invalid @enderror" id="point_persentase{{ $i }}" name="point_persentase{{ $i }}" value="{{ old('point_persentase'.$i) ? old('point_persentase'.$i) : $item->product_points[$i-1]->point_persentase }}" {{ $i == 1 ? 'required' : '' }}>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                  </div>
                                                @error('point_persentase'.$i)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                    @else
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_beli{{ $i }}">Min. Pembelian</label>
                                                <input type="number" class="form-control @error('min_beli{{ $i }}') is-invalid @enderror" id="min_beli{{ $i }}" name="min_beli{{ $i }}" value="{{ old('min_beli'.$i) ? old('min_beli'.$i) : '' }}" {{ $i == 1 ? 'required' : '' }}>
                                                @error('min_beli'.$i)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="point_persentase{{ $i }}">Persentase</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control @error('point_persentase'.$i) is-invalid @enderror" id="point_persentase{{ $i }}" name="point_persentase{{ $i }}" value="{{ old('point_persentase'.$i) ? old('point_persentase'.$i) : '' }}" {{ $i == 1 ? 'required' : '' }}>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                  </div>
                                                @error('point_persentase'.$i)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                    @endif
                                </div>
                                @endfor
                            </div>

                            <label for="">Aktifkan Produk <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Produk akan ditampilkan dihalaman user"></i></label>
                            <div class="custom-control custom-switch ">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="active" value="{{ $item->active }}" onclick="status()" {{ $item->active == "y" ? "checked" : "" }}>
                                <label class="custom-control-label" for="customSwitch1" ></label>
                              </div>
                            <hr>
                            {{-- <img src="{{ asset('assets/admin/img/hafidz1.jpg') }}"  alt="..."  id="crop-foto"> --}}
                            <div class="btn-bap text-right">
                                <button type="submit"  class="btn btn-success">Ubah</button>
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

        function kosongkanfield(id) {
            $('#min_beli'+id).val('');
            $('#point_persentase'+id).val('');
        }
        function hapus1(that){
            // console.log($(that).text());
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('admin.produk.hapusGambar') }}",
                method: "POST",
                data:{
                    id: "{{ $item->id }}",
                    urut: 2,
                    _token: token,
                },
                success: function(result){
                    if (result == "success") {
                        location.reload();
                    }
                }
            });
            $(that).remove();
            $('#image2').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto2').attr("src", route);
            $('#ubah-1').html('Pilih Foto');
        };
        function hapus2(that){
            // console.log($(that).text());
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('admin.produk.hapusGambar') }}",
                method: "POST",
                data:{
                    id: "{{ $item->id }}",
                    urut: 3,
                    _token: token,
                },
                success: function(result){
                    if (result == "success") {
                        location.reload();
                    }
                }
            });
            $(that).remove();
            $('#image3').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto3').attr("src", route);
            $('#ubah-2').html('Pilih Foto');
        };
        function hapus3(that){
            // console.log($(that).text());
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('admin.produk.hapusGambar') }}",
                method: "POST",
                data:{
                    id: "{{ $item->id }}",
                    urut: 4,
                    _token: token,
                },
                success: function(result){
                    if (result == "success") {
                        location.reload();
                    }
                }
            });
            $(that).remove();
            $('#image4').val('');
            var route = "{{ asset('assets/admin/img/add-foto.png') }}";
            $('#foto4').attr("src", route);
            $('#ubah-3').html('Pilih Foto');
        };

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
                    console.log(reader.result);
                    $('#foto1').attr("src", reader.result);
                }
                
                reader.readAsDataURL(file);
            }
        }
        function changeFoto2(input){
            var file = input.files[0];
            if(file){
                var reader = new FileReader();
                
    
                reader.onload = function(){
                    console.log(reader.result);
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
                    console.log(reader.result);
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
                    console.log(reader.result);
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
                $('#customSwitch1').val("n");
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