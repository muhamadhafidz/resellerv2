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
                          
                        <h2 class="card-title font-weight-bold ">Daftar Pesanan <span class="badge badge-dark">Diproses</span></h2>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                <table class="table table-striped display nowrap"  id="crudTable" style="width: 100%">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Invoice Trx</th>
                          <th>Produk</th>
                          <th>Total Belanja</th>
                          <th>Kurir</th>
                          <th>Pembayaran</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        
                        @foreach ($data as $item)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td><span class="font-weight-bold">{{ $item->invoice }}</span> <br> {{ $item->created_at->isoFormat('DD MMM YYYY') }} </td>
                                  
                          <td><span class="font-weight-bold">{{ $item->transaction_product->first()->product_name }}</span>
                              @if ($item->transaction_product->count() > 1)
                                  
                              <br> <small> dan {{ $item->transaction_product->count() - 1 }} produk lainnya</small>
                              
                              @endif
                          </td>
                          <td>
                              Rp. {{ $item->total_price }} <br>
                              <small>Sudah termasuk ongkir : Rp. {{ $item->ongkir_price }}</small>
                          </td>
                          <td>
                              {{ strtoupper($item->shipping) }} - {{ $item->service }}
                              <br>
                              Resi : 
                              @if ( $item->resi->first() == null )
                              -
                              @else
                              {{ $item->resi->first()->resi }}
                              @endif
                          </td>
                          <td>
                              <span class="">{{ ucwords($item->payment) }}</span>
                          </td>
                          <td>
                              <span class="badge badge-warning">{{ ucwords($item->status) }}</span>
                          </td>
                          <td>
                              @csrf
                              @if ($item->shipping == "toko")
                                    @if($item->service == "AmbilDiToko")
                                    <form action="{{ route('anggota.pesanan.sampai', $item->id) }}" method="POST" class="d-inline" id="ambil-{{ $item->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-success btn-sm" onclick="ambilPesanan('{{ $item->id }}')" >Pesanan sudah diambil</button>
                                    </form>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm" onclick="addkurir('{{ route('anggota.pesanan.addResi', $item->id) }}', '{{ $item->invoice }}')" >Masukan Detail Kurir</button>
                                    @endif
                              @else
                                  
                              <button type="button" class="btn btn-success btn-sm" onclick="addresi('{{ route('anggota.pesanan.addResi', $item->id) }}', '{{ $item->invoice }}')" >Masukan Resi</button>
                              @endif
                              <a href="{{ route('anggota.pesanan.cetakInvoice', $item->id) }}" class="btn btn-secondary btn-sm">Unduh Invoice</a>
                              <button type="button" class="btn btn-danger btn-sm" onclick="batal('{{ route('anggota.pesanan.batalkanPesanan', $item->id) }}')" >Batalkan pesanan</button>
                              {{-- <form action="" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger  btn-sm">Batalkan pesanan</button>
                            </form> --}}
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
            "scrollX": true
        });
        // $('#reservation').daterangepicker();
    });
    
    function ambilPesanan(id){
        Swal.fire({
            title: 'Pesanan ini telah pelanggan ambil ditoko anda?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, hapus kategori ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#ambil-'+id).submit();
            }
        });
    }
    function addresi(route, inv){
        // alert(inv);
        Swal.fire({
            input: 'text',
            inputLabel: 'Masukan nomor resi untuk pesanan '+inv,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Kirim Pesanan'
        }).then((result) => {
            // console.log(result);
            // alert(id);
            if (result.isConfirmed) {
                var token = $('input[name="_token"]').val();
                // alert("test");
                $.ajax({
                    url: route,
                    method: "POST",
                    data:{
                        resi: result.value,
                        _token: token,
                    },
                    success:function(result){
                        if (result == "success") {
                            location.reload();
                        }
                    }
                });
            }
            // if (result.isConfirmed) {
            //     $('#form-valid-'+id).submit();
            // }
        });
    }
    function batal(route){
        // alert(inv);
        Swal.fire({
            input: 'text',
            inputLabel: 'Alasan batalkan pesanan ',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Batalkan pesanan'
        }).then((result) => {
            // console.log(result);
            // alert(id);
            if (result.isConfirmed) {
                var token = $('input[name="_token"]').val();
                // alert("test");
                $.ajax({
                    url: route,
                    method: "POST",
                    data:{
                        alasan: result.value,
                        _token: token,
                    },
                    success:function(result){
                        if (result == "success") {
                            location.reload();
                        }
                    }
                });
            }
            // if (result.isConfirmed) {
            //     $('#form-valid-'+id).submit();
            // }
        });
    }
    function addkurir(route, inv){
        // alert(inv);
        Swal.fire({
            input: 'text',
            inputLabel: 'Masukan nama kurir untuk pesanan '+inv,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Nomor telepon kurir'
        }).then((result) => {
            var nama = result.value;
            Swal.fire({
                input: 'text',
                inputLabel: 'Masukan telepon nomor kurir '+nama,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Kirim pesanan'
            }).then((result) => {
                if (result.isConfirmed) {
                    var token = $('input[name="_token"]').val();
                // alert("test");
                    var kurir = nama+"-"+result.value;
                    $.ajax({
                        url: route,
                        method: "POST",
                        data:{
                            resi: kurir,
                            _token: token,
                        },
                        success:function(result){
                            if (result == "success") {
                                location.reload();
                            }
                        }
                    });
                }
            });
            // console.log(result);
            // alert(id);
            
            // if (result.isConfirmed) {
            //     $('#form-valid-'+id).submit();
            // }
        });
    }
</script>
@endpush