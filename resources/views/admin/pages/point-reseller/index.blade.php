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
                          
                        <h2 class="card-title font-weight-bold ">Data Point Reseller</span></h2>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <table class="table table-striped display nowrap"  id="crudTable" style="width: 100%">
                      <thead>
                          <tr>
                            <th>No</th>
                            <th>Reseller</th>
                            <th>Total Point</th>
                          </tr>
                          
                      </thead>
                      <tbody>
                          @foreach ($users as $user)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->user_points->last() ? $user->user_points->last()->total_point : '0' }}</td>
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
@push('after-style')
<style>
    .swal2-input[type=number]{
        max-width: 70%!important;
        margin-left: auto!important;
        margin-right: auto!important;
    }
</style>
@endpush


@push('after-script')
<script>
    function tfKomplain(id, route){
        $('#form-valid').attr('action', route);
    }
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
                pageSize: 'LEGAL',
                exportOptions: {
                    stripNewlines: false
                }
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
    function addongkir(route, inv){
        // alert(inv);
        Swal.fire({
            input: 'number',
            inputLabel: 'Masukan harga ongkir pesanan '+inv,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi Ongkir'
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
                        ongkir: result.value,
                        _token: token,
                    },
                    beforeSend: function() {
                        swal.fire({
                            html: '<h5>Sedang diproses...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success:function(result){
                        if (result == "success") {
                            location.reload();
                        }
                    },
                    error:function(result){
                        location.reload();
                    }
                });
            }
            // if (result.isConfirmed) {
            //     $('#form-valid-'+id).submit();
            // }
        });
    }
    function kirimpesanan(route, inv){
        // alert(inv);
        Swal.fire({
            title: 'Masukan detail pengiriman pesanan '+inv,
            html:
                '<label>Detail Kurir</label><input id="kurir" class="swal2-input mt-1 mb-3">' +
                '<br><label>Resi</label><br><input id="resi" class="swal2-input mt-1 mb-3">',
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
                const kurir = document.getElementById('kurir').value;
                const resi = document.getElementById('resi').value;
                $.ajax({
                    url: route,
                    method: "POST",
                    data:{
                        resi: resi,
                        kurir: kurir,
                        _token: token,
                    },
                    beforeSend: function() {
                        swal.fire({
                            html: '<h5>Sedang diproses...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success:function(result){
                        if (result == "success") {
                            location.reload();
                        }
                    },
                    error:function(result){
                        location.reload();
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
                    beforeSend: function() {
                        swal.fire({
                            html: '<h5>Sedang diproses...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success:function(result){
                        if (result == "success") {
                            location.reload();
                        }
                    },
                    error:function(result){
                        location.reload();
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
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Sedang diproses...</h5>',
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
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
                    beforeSend: function() {
                        swal.fire({
                            html: '<h5>Sedang diproses...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success:function(result){
                        // alert("test");
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
                    beforeSend: function() {
                        swal.fire({
                            html: '<h5>Sedang diproses...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
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
    function detailKomplain(status, bukti_tf, desc, alasan, penyelesaian, dana, bukti){
        // var penyelesaian;
        // alert(status);
        // alert(bukti);
        // alert(desc);
        if (penyelesaian == "dana") {
            penyelesaian = "pengembalian dana Rp. "+dana;
        }else {
            penyelesaian = "pengiriman produk yang kurang";
        }

        if (status == "tolak komplain") {
            status = '<span class="text-danger">Ditolak : '+desc+'</span>';
        }else if(status == "terima komplain"){
            status = '<span class="text-success">Diterima '+desc+'</span>';
        }else {
            status = '<span class="text-warning">Diproses</span>';
        }
        
        if (bukti_tf != null) {
            
            Swal.fire({
                title: '',
                html: 'bukti : <br><img src="'+bukti+'" class="img-fluid"> <br>Alasan : '+alasan+'<br> Penyelesaian : '+penyelesaian+'<br>'+status+'<br>bukti transfer : <br><img src="'+bukti_tf+'" class="img-fluid">',
            });
        }else {

            Swal.fire({
                title: '',
                html: 'bukti : <br><img src="'+bukti+'" class="img-fluid"> <br>Alasan : '+alasan+'<br> Penyelesaian : '+penyelesaian+'<br>'+status,
            });
        }
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