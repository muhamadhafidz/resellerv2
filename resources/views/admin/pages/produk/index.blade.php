@extends('admin.layouts.default')

@section('content')
{{-- {{  }} --}}
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
              <div class="card-header ">
                  <div class="row ">
                      <div class="col ">
                          
                        <h2 class="card-title font-weight-bold ">Daftar Produk </h2>
                      </div>
                      <div class="col text-right">
                        <a href="{{ route('admin.produk.create') }}" class="btn btn-success btn-sm">+ Tambah Produk</a>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <table class="table table-striped display nowrap"  id="crudTable" style="width: 100%">
                      <thead>
                          <th>No</th>
                          <th>Foto</th>
                          <th>Produk</th>
                          <th>Harga</th>
                          <th>Ketentuan Poin</th>
                          <th>Stok</th>
                          <th>Terjual</th>
                          <th>Aksi</th>
                          <th>Aktif</th>
                      </thead>
                      <tbody>
                          @foreach ($data as $item)
                          {{-- {{ dd($data) }} --}}
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img class="" height="50" src="{{ asset( $item->product_images[0]->img_product ) }}" alt="">
                            </td>
                            <td class="align-middle ">
                              <a href="{{ route('user.produk.detail', $item->slug) }}" class="text-dark">
                                <u>
                                  <h5 class="font-weight-bold">
                                    {{ $item->nama_barang }}
                                  </h5>
                                </u>
                              </a>
                            </td>
                            
                            <td class="align-middle">
                              
                              Rp. {{ number_format( $item->harga, 0,'','.') }}
                              
                            </td >
                            <td class="align-middle">
                              
                              @foreach ($item->product_points as $point)
                                  min. beli {{ $point->min_beli }}: {{ $point->point_persentase }}% <br>
                              @endforeach
                              
                            </td >
                            <td class="align-middle">{{ $item->stok }}</td>
                            <td class="align-middle">{{ $item->terjual }}</td>
                            <td class="align-middle">
                              <a href="{{ route('admin.produk.edit',$item->id) }}" class="btn btn-warning btn-sm">Ubah</a>
                              <form action="{{ route('admin.produk.destroy', $item->id) }}" method="post" id="form-hapus-{{ $item->id }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" onclick="hapus({{ $item->id }})" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            </td>
                            <td class="align-middle">
                              <div class="custom-control custom-switch">
                                
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $item->id }}" {{ $item->active == "y" ? "checked" : "" }} onclick="status({{ $item->id }})">
                                <label class="custom-control-label" for="customSwitch{{ $item->id }}"></label>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          
                          
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->

@include('admin.pages.produk.detail')

@endsection

@push('after-script')
<script>
    function submit()
    {
        $('#form-modal').submit();
    }

    $(document).ready(function(){
        $('#crudTable').DataTable({
dom: 'Blfrtip',
            buttons: [
                'excel',  'print',
{
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
            ],
"lengthMenu": [ 10, 25, 50, 75, 100 ],
          "columnDefs": [
            { "width": "5%", "targets": 0 },
            { "width": "15%", "targets": 3 },
            { "width": "15%", "orderable": false, "targets": 6 },
            { "width": "5%", "orderable": false, "targets": 7 }
          ],
          "scrollX": true
        });
        // $('#reservation').daterangepicker();
    });
    function hapus(id){
        Swal.fire({
        title: 'Yakin menghapus produk ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yakin, hapus produk ini!'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#form-hapus-'+id).submit();
        }
        });
    }
    function status(id_product) 
    {
        // alert("waw");
        // $('#jadwal_id').val(id_jadwal);
        var idProduct = id_product;
        var token = $('input[name="_token"]').val();
        // alert("test");
        $.ajax({
            url: "{{ route('admin.produk.setStatus') }}",
            method: "POST",
            data:{
                id_product: idProduct,
                _token: token,
            },
            success: function(result){
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              });
                if (result[0] == 'aktif') {
                  
                  Toast.fire({
                    icon: 'success',
                    title: 'Produk '+result[1]+' telah diaktifkan'
                  });
                }else {
                  Toast.fire({
                    icon: 'success',
                    title: 'Produk '+result[1]+' telah dinonaktifkan'
                  });
                }
            }
        });
    }

    
</script>
@endpush