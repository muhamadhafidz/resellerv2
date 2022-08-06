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
                                <h4 class="card-title font-weight-normal">Buat Point Baru</h4>
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
                        <form method="POST" action="{{ route('admin.point.store') }}" enctype="multipart/form-data" id="form">
                            @csrf
                            <h5>Informasi Point</h5>
                              
                            {{-- <hr> --}}
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nama">Nama Point<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"  id="nama" name="nama" value="{{ old('nama') ? old('nama') : '' }}" required>
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="req_point">Minimum Point <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('req_point') is-invalid @enderror" id="req_point" name="req_point" value="{{ old('req_point') ? old('req_point') : '' }}" required>
                                        @error('req_point')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="detail">Detail </label>
                                <textarea class="description form-control @error('detail') is-invalid @enderror" name="detail" id="detail" rows="15" required>{{ old('detail') ? old('detail') : '' }}</textarea>
                                @error('detail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <label for="img_point">Gambar Point</label>
                                <input type="file" class="form-control-file" id="img_point" name="img_point" required>
                              </div>
                            <div class="btn-bap text-right">
                                <button type="submit" class="btn btn-success">Tambah Point</button>
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