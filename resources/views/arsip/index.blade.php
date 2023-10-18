@extends('adminlte::page')
@section('title', 'List Arsip')
@section('content_header')
<h1 class="m-0 text-dark">Profile : {{ Auth::user()->nama_pegawai }}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Route::currentRouteName() === 'arsip.showAdmin')
                @include('partials.nav-pills-profile-admin', ['id_users' => $id_users])
            @else
                @include('partials.nav-pills-profile')
            @endcan
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">Tambah</button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                @can('isAdmin')
                                <th>Nama Pegawai</th>
                                @endcan
                                <th>Jenis Arsip</th>
                                <th>Keterangan</th>
                                <th>File Arsip</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($arsip as $key => $ap)
                            <tr>
                                <td>{{$key+1}}</td>
                                @can('isAdmin')
                                <td>{{$ap->users->nama_pegawai}}</td>
                                @endcan
                                <td>{{$ap->jenis}}</td>
                                <td>{{$ap->keterangan}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset('/storage/arsip/'. $ap->file) }}" download>
                                        <i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>
                                    </a>
                                </td>
                            <td>
                                @include('components.action-buttons', ['id' => $ap->id_arsip, 'key' => $key, 'route' => 'arsip'])
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

<!-- Modal Tambah Arsip -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Arsip</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('arsip.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_users" value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="jenis">Jenis Arsip</label>
                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                            id="jenis" name="jenis" value="{{old('jenis') }}" required>
                                        @error('jenis')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{old('keterangan')}}" required>
                                        @error('keterangan')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label><br>
                                        <input type="file" class="form-control" id="file" enctype="multipart/form-data" name="file"accept="image/jpeg, image/jpg, image/png, application/pdf, application/docx">
                                        @error('file') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
                                        @error('file')<span class="text-danger">{{ $message }}</span>@enderror
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

<!-- Modal Edit Arsip -->
@foreach($arsip as $ap)
<div class="modal fade" id="editModal{{$ap->id_arsip}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Arsip</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('arsip.update',$ap->id_arsip) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_users" value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="jenis">Jenis Arsip</label>
                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                            id="jenis" name="jenis" value="{{$ap->jenis ??old('jenis') }}"required>
                                        @error('jenis')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan"
                                            value="{{$ap->keterangan ??old('keterangan')}}" required>
                                        @error('keterangan')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label><br>
                                            <input type="file" name="file" id="file" class="form-control" accept="image/jpeg, image/jpg, image/png, application/pdf, application/docx">
                                            @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
                                        <p>Previous File: <a href="{{ asset('/storage/arsip/'. $ap->file) }}"
                                                target="_blank">{{ $ap->file }}</a></p>
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

@if(count($errors))
<script>
Swal.fire({
    title: 'Input tidak sesuai!',
    text: 'Pastikan inputan sudah sesuai',
    icon: 'error',
});
</script>
@endif

@endpush

