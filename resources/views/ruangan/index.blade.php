@extends('adminlte::page')
@section('title', 'List Ruangan')
@section('content_header')
<h1 class="m-0 text-dark">Ruangan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <div class="mb-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
                </div>
                @endcan
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Ruangan</th>
                                @can('isAdmin')
                                <th style="width:189px;">Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruangan as $key => $rn)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$rn->nama_ruangan}}</td>
                                @can('isAdmin')
                                <td>
                                    @include('components.action-buttons', ['id' => $rn->id_ruangan, 'key' => $key,
                                    'route' => 'ruangan'])
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Form Tambah Ruangan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ruangan.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_ruangan">Nama Ruangan</label>
                                        <input type="number"
                                            class="form-control @error('nama_ruangan') is-invalid @enderror"
                                            id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}">
                                        @error('nama_ruangan') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@foreach($cutis as $cuti)
<div class="modal fade" id="editModal{{$cuti->id_cuti}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Cuti</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('cuti.update',$cuti->id_cuti) }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $cuti->id_cuti }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_users">Pegawai</label>
                                        <select class="form-select @error('id_users') is-invalid @enderror"
                                            id="id_users" name="id_users">
                                            <option value="">Pilih Pegawai</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id_users }}"
                                                {{ $user->id_users == $cuti->id_users ? 'selected' : '' }}>
                                                {{ $user->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_users') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jatah_cuti">Sisa Jatah Cuti Tahunan</label>
                                        <input type="number"
                                            class="form-control @error('jatah_cuti') is-invalid @enderror"
                                            id="jatah_cuti" name="jatah_cuti"
                                            value="{{ $cuti->jatah_cuti ?? old('jatah_cuti') }}">
                                        @error('jatah_cuti') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach



@endcan

@stop

@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$(document).ready(function() {
    var table = $('#example2').DataTable({
        "responsive": true,
        "order": [[1, 'asc']],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
    });

    // Inisialisasi nomor yang disimpan di data-attribute
    table.on('order.dt search.dt', function () {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush