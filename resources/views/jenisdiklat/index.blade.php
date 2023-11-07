@extends('adminlte::page')
@section('title', 'List Jenis Diklat')
@section('content_header')
<h1 class="m-0 text-dark">List Diklat</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                @endcan
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Jenis Diklat</th>
                                @can('isAdmin')
                                <th style="width:189px;">Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jenisdiklat as $key => $jd)
                            <tr>
                                <td>{{$key+1}}</td> <!-- Placeholder untuk nomor asli -->
                                <td>{{$jd->nama_jenis_diklat}}</td>
                                @can('isAdmin')
                                <td>
                                    @include('components.action-buttons', ['id' => $jd->id_jenis_diklat, 'key' => $key,
                                    'route' => 'jenisdiklat'])
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

@can('isAdmin')

<!-- Modal -->
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Jenis Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('jenisdiklat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Nama Jenis Diklat</label>
                                        <input type="text"
                                            class="form-control @error('nama_jenis_diklat') is-invalid @enderror"
                                            id="nama_jenis_diklat" name="nama_jenis_diklat" value="{{old('name')}}">
                                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
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

<!-- Bootstrap modal Edit -->
@foreach($jenisdiklat as $jd)
<div class="modal fade" id="editModal{{$jd->id_jenis_diklat}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Jenis Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('jenisdiklat.update',$jd->id_jenis_diklat) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $jd->id_jenis_diklat }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_jenis_diklat">Nama Jenis Diklat</label>
                                        <input type="text"
                                            class="form-control @error('nama_jenis_diklat') is-invalid @enderror"
                                            id="nama_jenis_diklat" placeholder="Masukkan Nama Jenis Diklat"
                                            name="nama_jenis_diklat"
                                            value="{{ $jd->nama_jenis_diklat ?? old('nama_jenis_diklat') }}">
                                        @error('nama_jenis_diklat')
                                        <span class="textdanger">{{ $message }}</span>
                                        @enderror
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
        "order": [[1, 'desc']],
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
