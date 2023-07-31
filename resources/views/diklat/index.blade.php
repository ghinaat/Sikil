@extends('adminlte::page')
@section('title', 'List Diklat')
@section('content_header')
<h1 class="m-0 text-dark">List Diklat</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Route::currentRouteName() === 'diklat.showAdmin')
                @include('partials.nav-pills-profile-admin', ['id_users' => $id_users])
            @else
                @include('partials.nav-pills-profile')
            @endcan
            <div class="card-body">

                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                @if(auth()->user()->level=='admin' )
                                <th>Nama Pegawai</th>
                                @endif
                                <th>Jenis Diklat</th>
                                <th>Nama Diklat</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal Diklat</th>
                                <th>Jam Pelajaran</th>
                                <th>File Sertifikat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diklat as $key => $dk)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                @if(auth()->user()->level=='admin' )
                                <td id={{$key+1}}>{{$dk->users->nama_pegawai}}</td>
                                @endif
                                <td id={{$key+1}}>{{$dk->jenisdiklat->nama_jenis_diklat}}</td>
                                <td id={{$key+1}}>{{$dk->nama_diklat}}</td>
                                <td id={{$key+1}}>{{$dk->penyelenggara}}</td>
                                <td id={{$key+1}}>{{$dk->tanggal_diklat}}</td>
                                <td id={{$key+1}}>{{$dk->jp}}</td>
                                <td id={{$key+1}}>
                                    <a href="{{ asset('/storage/File Sertifikat/'. $dk->file_sertifikat) }}"
                                        target="_blank">Lihat Dokumen</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$dk->id_diklat}}" data-id="{{$dk->id_diklat}}"
                                        data-nama="{{$dk->nama_diklat}}">Edit</a>
                                    <a href="{{route('diklat.destroy', $dk->id_diklat)}}"
                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <!-- Edit modal -->
                            <div class="modal fade" id="editModal{{$dk->id_diklat}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$dk->id_diklat}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Diklat</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('diklat.update', $dk->id_diklat) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_users"
                                                    value="{{ Auth::user()->id_users}}">
                                                <div class="form-group">
                                                    <label class="control-label col-md-6" for="id_jenis_diklat">Jenis
                                                        Diklat</label>
                                                    <select id="id_jenis_diklat" name="id_jenis_diklat"
                                                        class="form-control @error('id_jenis_diklat') is-invalid @enderror">
                                                        @foreach ($jenisdiklat as $jd)
                                                        <option value="{{ $jd->id_jenis_diklat }}" @if(
                                                            old('id_jenis_diklat')==$jd->id_jenis_diklat
                                                            ) selected @endif>
                                                            {{ $jd->nama_jenis_diklat }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class='form-label'>Nama Diklat</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control"
                                                            class="form-control @error('nama_diklat') is-invalid @enderror"
                                                            id="nama_diklat" placeholder="Nama Diklat"
                                                            name="nama_diklat"
                                                            value="{{$dk -> nama_diklat ?? old('nama_diklat')}}">
                                                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control"
                                                            class="form-control @error('penyelenggara') is-invalid @enderror"
                                                            id="penyelenggara" placeholder="Penyelenggara"
                                                            name="penyelenggara"
                                                            value="{{$dk -> penyelenggara ?? old('penyelenggara')}}">
                                                        @error('penyelenggara') <span
                                                            class="textdanger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal_diklat" class="form-label">Tanggal
                                                        Diklat</label>
                                                    <div class="form-input">
                                                        <input type="date"
                                                            class="form-control @error('tanggal_diklat') is-invalid @enderror"
                                                            id="tanggal_diklat" placeholder="Tanggal_diklat"
                                                            name="tanggal_diklat"
                                                            value="{{$dk -> tanggal_diklat ?? old('tanggal_diklat')}}">
                                                        @error('tanggal_diklat') <span
                                                            class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jp" class="form-label">Jam Pelajaran</label>
                                                    <div class="form-input">
                                                        <input type="text"
                                                            class="form-control @error('jp') is-invalid @enderror"
                                                            id="jp" placeholder="Jp" name="jp"
                                                            value="{{$dk -> jp ?? old('jp')}}">
                                                        @error('jp') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_sertifikat">File Sertifikat</label>
                                                    <small class="form-text text-muted">Allow file extensions : .jpeg
                                                        .jpg .png .pdf
                                                        .docx</small>
                                                    @if ($dk->file_sertifikat)
                                                    <p>Previous File: <a
                                                            href="{{ asset('/storage/File Sertifikat/' . $dk->file_sertifikat) }}"
                                                            target="_blank">{{ $dk->file_sertifikat }}</a></p>
                                                    @endif
                                                    <input type="file" class="form-control" id="file_sertifikat"
                                                        enctype="multipart/form-data" name="file_sertifikat"
                                                        @error('file_sertifikat') <span class="invalid"
                                                        role="alert">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <a href="{{route('kegiatan.index')}}" class="btn btn-danger">
                                                        Batal
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('diklat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id_users}}" name="id_users">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_jenis_diklat">Jenis Diklat</label>
                                    <select id="id_jenis_diklat" name="id_jenis_diklat"
                                        class="form-control @error('id_jenis_diklat') is-invalid @enderror">
                                        @foreach ($jenisdiklat as $jd)
                                        <option value="{{ $jd->id_jenis_diklat }}" @if( old('id_jenis_diklat')==$jd->
                                            id_jenis_diklat )selected @endif>
                                            {{ $jd->nama_jenis_diklat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Nama Diklat</label>
                                <input type="text" class="form-control" id="nama_diklat" name="nama_diklat" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Penyelenggara</label>
                                <input type="text" class="form-control" id="penyelenggara" name="penyelenggara"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Tanggal Diklat</label>
                                <input type="date" class="form-control" id="tanggal_diklat" name="tanggal_diklat"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Jam Pelajaran</label>
                                <input type="number" class="form-control" id="jp" name="jp" required>
                            </div>
                            <div class="form-group">
                                <label for="file_sertifikat">File Sertifikat</label>
                                <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf
                                    .docx</small>
                                <input type="file" class="form-control" id="file_sertifikat"
                                    enctype="multipart/form-data" name="file_sertifikat" @error('file_sertifikat') <span
                                    class="invalid" role="alert">{{$message}}</span>
                                @enderror
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
</script>
@endpush