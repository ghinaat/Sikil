@extends('adminlte::page')
@section('title', 'List Diklat')
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
                                <th>Nama Pegawai</th>
                                <th>Jenis Diklat</th>
                                <th>Nama Diklat</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal Diklat</th>
                                <th>Jam Pelajaran</th>
                                <th>File Sertifikat</th>
                                @can('isAdmin')
                                <th style="width:189px;">Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diklat as $key => $dk)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$dk->nama_pegawai}}</td>
                                <td>{{$dk->nama_jenis_diklat}}</td>
                                <td>{{$dk->nama_diklat}}</td>
                                <td>{{$dk->penyelenggara}}</td>
                                <td>{{$dk->tanggal_diklat}}</td>
                                <td>{{$dk->jp}}</td>
                                <td>{{$dk->file_sertifikat}}</td>
                                @can('isAdmin')
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$dk->id_diklat}}" data-id="{{$dk->id_diklat}}"
                                        data-nama="{{$dk->nama_diklat}}">Edit</a>
                                    <a href="{{route('diklat.destroy', $dk->id_diklat)}}"
                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('diklat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-6" for="id_pegawai">Nama Pegawai</label>
                                        <select id="id_pegawai" name="id_pegawai"
                                            class="form-control @error('id_pegawai') is-invalid @enderror">
                                            @foreach ($user as $us)
                                            <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users )
                                                selected @endif">
                                                {{ $us->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-6" for="id_jenis_diklat">Jenis Diklat</label>
                                        <select id="id_jenis_diklat" name="id_jenis_diklat"
                                            class="form-control @error('id_jenis_diklat') is-invalid @enderror">
                                            @foreach ($jenisdiklat as $jd)
                                            <option value="{{ $jd->id_jenis_diklat }}" @if(
                                                old('id_jenis_diklat')==$jd->id_jenis_diklat )
                                                selected @endif>
                                                {{ $jd->nama_jenis_diklat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Nama Diklat</label>
                                        <input type="text"
                                            class="form-control @error('nama_diklat') is-invalid @enderror"
                                            id="nama_diklat" name="nama_diklat" value="{{old('name')}}">
                                        @error('nama_diklat') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Penyelenggara</label>
                                        <input type="text"
                                            class="form-control @error('penyelenggara') is-invalid @enderror"
                                            id="penyelenggara" name="penyelenggara" value="{{old('name')}}">
                                        @error('penyelenggara') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Tanggal Diklat</label>
                                        <input type="date" class="form-control" @error('tanggal_diklat') is-invalid
                                            @enderror id="tanggal_diklat" name="tanggal_diklat" value="{{old('name')}}">
                                        @error('natanggal_diklatme') <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Jam Pelajaran</label>
                                        <input type="number" class="form-control" @error('jp') is-invalid @enderror
                                            id="jp" name="jp" value="{{old('name')}}">
                                        @error('jp') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="file_sertifikat">File Sertifikat</label>
                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf
                                            .docx</small>
                                        <input type="file" class="form-control" id="file_sertifikat"
                                            enctype="multipart/form-data" accept="image/*,.jpeg, .jpg, .png, .pdf,
                                            .docx" name="file_sertifikat" value="{{old('file_sertifikat')}}">
                                        @error('file_sertifikat') <span class="invalid" role="alert">{{$message}}</span>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($diklat as $jd)
<div class="modal fade" id="editModal{{$jd->id_id_jenis_diklat}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Jenis Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('diklat.update',$jd->id_id_jenis_diklat) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $jd->id_id_jenis_diklat }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_diklat">Nama Jenis Diklat</label>
                                        <input type="text"
                                            class="form-control @error('nama_diklat') is-invalid @enderror"
                                            id="nama_diklat" placeholder="Masukkan Nama Jenis Diklat" name="nama_diklat"
                                            value="{{ $jd->nama_diklat ?? old('nama_diklat') }}">
                                        @error('nama_diklat')
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