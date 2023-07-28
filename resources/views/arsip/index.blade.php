@extends('adminlte::page')
@section('title', 'List Arsip')
@section('content_header')
<h1 class="m-0 text-dark">List Arsip</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">Tambah</button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pegawai</th>
                                <th>Jenis Arsip</th>
                                <th>Keterangan</th>
                                <th>File</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($arsip as $key => $ap)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$ap->users->nama_pegawai}}</td>
                                <td>{{$ap->jenis}}</td>
                                <td>{{$ap->keterangan}}</td>
                                <td id={{$key+1}}>
                                    <a href="{{ asset('/storage/Arsip/'. $ap->file) }}"
                                        target="_blank">Lihat Dokumen</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$ap->id_arsip}}" data-id="{{$ap->id_arsip}}">Edit</a>
                                    <a href="{{route('arsip.destroy', $ap->id_arsip)}}"
                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
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
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('arsip.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputUsers">Nama Pegawai</label>
                                        <select class="form-select @error('nama_pegawai') isinvalid @enderror"
                                            id="exampleInputUsers" name="id_users">
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id_users }}" @if( old('id_users')==$user->id_users)
                                                selected @endif">
                                                {{ $user->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis">Jenis Arsip</label>
                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                            id="jenis" name="jenis" value="{{old('jenis') }}">
                                        @error('jenis')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{old('keterangan')}}">
                                        @error('keterangan')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label><br>
                                        <input type="file" name="file" id="file"
                                            accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" required> @error('file')<span
                                            class="textdanger">{{ $message }}</span>@enderror
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
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('arsip.update',$ap->id_arsip) }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $ap->id_arsip }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputUsers">Nama Pegawai</label>
                                        <select class="form-select @error('nama_pegawai') isinvalid @enderror"
                                            id="exampleInputUsers" name="id_users">
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id_users }}" @if( old('id_users')==$user->id_users
                                                )
                                                selected @endif">
                                                {{ $user->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis">Jenis Arsip</label>
                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                            id="jenis" name="jenis" value="{{$ap->jenis ??old('jenis') }}">
                                        @error('jenis')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{$ap->keterangan ??old('keterangan')}}">
                                        @error('keterangan')<span class="textdanger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File</label><br>
                                        <p>Previous File: <a href="{{ asset('/storage/Arsip/'. $ap->file) }}"
                                                target="_blank">{{ $ap->file }}</a></p>
                                        <input type="file" name="file" id="file"
                                            accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                        @error('file')<span class="textdanger">{{ $message }}</span>@enderror
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
