@extends('admin.layouts.default')

@section('content')
{{-- {{  }} --}}
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
          <div class="card strpied-tabled-with-hover">
              <div class="card-header ">
                  <div class="row ">
                      <div class="col ">
                          
                        <h2 class="card-title font-weight-bold ">Daftar Pesanan <span class="badge badge-dark">Semua</span></h2>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <table class="table table-striped display nowrap"  id="crudTable" style="width: 100%">
                      <thead>
                          <tr>
                            <th>No</th>
                            <th>Pembeli</th>
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
                            <td>{{ $item->user->name }}</td>
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
                                @if ($item->status == "menunggu pembayaran")
                                <span class="badge badge-secondary">{{ ucwords($item->status) }}</span>
                                    @if (\Carbon\Carbon::now() > $item->created_at->addDays(3))
                                    <br>
                                    <span class="badge badge-danger">Pembeli belum melakukan pembayaran lebih dari 2 hari</span>
                                    @endif
                                @elseif ($item->status == "menunggu konfirmasi")
                                <span class="badge badge-warning">Menunggu konfirmasi transfer oleh superadmin</span>
                                @elseif ($item->status == "diproses")
                                <span class="badge badge-warning">{{ ucwords($item->status) }}</span>
                                @elseif ($item->status == "dikirim")
                                <span class="badge badge-success">{{ ucwords($item->status) }}</span>
                                @elseif ($item->status == "selesai")
                                <span class="badge badge-success">{{ ucwords($item->status) }}</span>
                                @elseif ($item->status == "pengajuan komplain" || $item->status == "tolak komplain" )
                                <span class="badge badge-danger">{{ ucwords($item->status) }}</span> <br>
                                <button type="button" class="btn btn-link btn-sm" onclick="detailKomplain('{{ $item->komplain()->first()->alasan }}','{{ $item->komplain()->first()->penyelesaian }}', '{{ $item->komplain()->first()->dana }}', '{{ asset($item->komplain()->first()->dir_bukti) }}')">detail komplain</button>
                                @elseif ($item->status == "terima komplain")
                                <span class="badge badge-success">Komplain diterima</span>
                                <button type="button" class="btn btn-link btn-sm" onclick="detailKomplain('{{ $item->komplain()->first()->alasan }}','{{ $item->komplain()->first()->penyelesaian }}', '{{ $item->komplain()->first()->dana }}', '{{ asset($item->komplain()->first()->dir_bukti) }}')">detail komplain</button>
                                @elseif ($item->status == "bukti tidak valid")
                                <span class="badge badge-danger">{{ ucwords($item->description) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == "menunggu konfirmasi")
                                <button type="button" class="btn btn-secondary btn-sm" disabled>Tidak ada aksi</button>
                                @elseif ($item->status == "diproses")
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
                                @csrf
                                @elseif ($item->status == "dikirim")
                                <form action="{{ route('anggota.pesanan.sampai', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Pesanan Sampai</button>
                                    
                                </form>
                                <button type="button" class="btn btn-warning btn-sm" onclick="editresi('{{ route('anggota.pesanan.editResi', $item->id) }}', '{{ $item->invoice }}', '{{ $item->resi->first()->resi }}')" >Ubah Resi</button>
                                @elseif ($item->status == "pengajuan komplain")
                                <form action="{{ route('anggota.pesanan.terimaKomplain', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Setujui Komplain</button>
                                </form>
                                  <button type="button" class="btn btn-danger btn-sm" onclick="tolakKomplain('{{ route('anggota.pesanan.tolakKomplain', $item->id) }}')" >Tolak komplain</button>
                                {{-- <button type="button" class="btn btn-warning btn-sm" onclick="editresi('{{ route('anggota.pesanan.editResi', $item->id) }}', '{{ $item->invoice }}', '{{ $item->resi->first()->resi }}')" >Ubah Resi</button> --}}
                                @elseif ($item->status == "bukti tidak valid" || $item->status == "selesai")
                                <button type="button" class="btn btn-secondary btn-sm" disabled>Tidak ada aksi</button>
                                @endif
                                @if ($item->status == "menunggu pembayaran" &&  \Carbon\Carbon::now() < $item->created_at->addDays(3))
                                <form action="{{ route('anggota.pesanan.tidakBayar', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak Pesanan</button>    
                                </form>
                                @endif
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
          ],
          "scrollX": true
        });
        // $('#reservation').daterangepicker();
    });
    
    function hapus(id){
        Swal.fire({
        title: 'Yakin menghapus kategori ini?',
        text: "Semua produk yang berkategori ini akan terhapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yakin, hapus kategori ini!'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#form-hapus-'+id).submit();
        }
        });
    }

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
    function editresi(route, inv, value){
        // alert(inv);
        Swal.fire({
            input: 'text',
            inputLabel: 'Masukan nomor resi baru untuk pesanan '+inv,
            inputValue: value,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah Resi'
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
    function tolakKomplain(route){
        // alert('a');
        Swal.fire({
            input: 'text',
            inputLabel: 'Alasan menolak komplain ',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tolak komplain'
        }).then((result) => {
            // console.log(result);
            // alert(id);
            if (result.isConfirmed) {
                var token = $('input[name="_token"]').val();
                alert("test");
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
    function detailKomplain(alasan, penyelesaian, dana, bukti){
        // var penyelesaian;
        if (penyelesaian == "dana") {
            penyelesaian = "pengembalian dana Rp. "+dana;
        }else {
            penyelesaian = "pengiriman produk yang kurang";
        }
        // alert(penyelesaian);
        Swal.fire({
            title: '',
            html: 'bukti : <br><img src="'+bukti+'" class="img-fluid"> <br>Alasan : '+alasan+'<br> Penyelesaian : '+penyelesaian,
        });
    }
    function bukti(img){
        Swal.fire({
            title: '',
            text: 'Bukti Transfer',
            imageUrl: img,
            imageWidth: 400,
            imageAlt: 'Custom image',
        })
    }
</script>
@endpush