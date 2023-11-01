@extends('adminlte::page')
@section('title', 'List Kode Diklat')
@section('content_header')
<h1 class="m-0 text-dark">List Kode Surat</h1>
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
                                <th>Divisi</th>
                                <th>Kode Surat</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kodesurat as $key => $ks)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$ks->divisi}}</td>
                                <td>{{$ks->kode_surat}}</td>
                                <td>
                                    @include('components.action-buttons', ['id' => $ks->id_kode_surat, 'key' => $key,
                                    'route' => 'kodesurat'])
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


<!-- Modal -->
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Kode Surat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('kodesurat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Nama Divisi</label>
                                        <input type="text"
                                            class="form-control @error('divisi') is-invalid @enderror"
                                            id="divisi" name="divisi" value="{{old('divisi')}}">
                                        @error('divisi') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName">Kode Surat</label>
                                        <input type="text"
                                            class="form-control @error('kode_surat') is-invalid @enderror"
                                            id="kode_surat" name="kode_surat" value="{{old('kode_surat')}}">
                                        @error('kode_surat') <span class="text-danger">{{$message}}</span> @enderror
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
@foreach($kodesurat as $ks)
<div class="modal fade" id="editModal{{$ks->id_kode_surat}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Kode Surat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('kodesurat.update',$ks->id_kode_surat) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $ks->id_kode_surat }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="divisi">Divisi</label>
                                        <input type="text"
                                            class="form-control @error('divisi') is-invalid @enderror"
                                            id="divisi" placeholder="Masukkan Nama Jenis Diklat"
                                            name="divisi"
                                            value="{{ $ks->divisi ?? old('divisi') }}">
                                        @error('divisi')
                                        <span class="textdanger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kode_surat">Kode Surat</label>
                                        <input type="text"
                                            class="form-control @error('kode_surat') is-invalid @enderror"
                                            id="kode_surat" placeholder="Masukkan Nama Jenis Diklat"
                                            name="kode_surat"
                                            value="{{ $ks->kode_surat ?? old('kode_surat') }}">
                                        @error('kode_surat')
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



@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$('#example2').DataTable({
    "responsive": true,
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