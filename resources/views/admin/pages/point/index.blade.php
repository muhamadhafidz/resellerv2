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
                          
                        <h2 class="card-title font-weight-bold ">Daftar point </h2>
                      </div>
                      <div class="col text-right">
                        <a href="{{ route('admin.point.create') }}" class="btn btn-success btn-sm">+ Tambah point</a>
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <table class="table table-striped display nowrap" id="crudTable" style="width: 100%">
                      <thead>
                          <th>No</th>
                          <th>Foto</th>
                          <th>Nama</th>
                          <th>Detail</th>
                          <th>Minimal Point</th>
                          <th>Aksi</th>
                      </thead>
                      <tbody>
                          @foreach ($data as $item)
                          {{-- {{ dd($data) }} --}}
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img class="" height="50" src="{{ asset( $item->img_point ) }}" alt="">
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->detail }}</td>
                            <td>{{ $item->req_point }}</td>
                            <td class="align-middle">
                              <a href="{{ route('admin.point.edit',$item->id) }}" class="btn btn-warning btn-sm">Ubah</a>
                              <form action="{{ route('admin.point.destroy', $item->id) }}" method="post" id="form-hapus-{{ $item->id }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" onclick="hapus({{ $item->id }})" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
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
        title: 'Yakin menghapus point ini?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yakin, hapus point ini!'
        }).then((result) => {
        if (result.isConfirmed) {
            $('#form-hapus-'+id).submit();
        }
        });
    }
  

    
</script>
@endpush