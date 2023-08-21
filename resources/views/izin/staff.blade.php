@extends('adminlte::page')
@section('title', 'List Perizinan')
@section('content_header')
<h1 class="m-0 text-dark">List Perizinan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
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
                                <th>Jenis Ajuan</th>
                                <th>Tanggal Ajuan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Persetujuan Atasan</th>
                                <th>Persetujuan PPK</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perizinan as $key => $p)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$p->jenis_perizinan}}</td>
                                <td>{{$p->tgl_ajuan}}</td>
                                <td>{{$p->tgl_absen_awal}}</td>
                                <td>{{$p->keterangan}}</td>
                                <td>{{$p->file_perizinan}}</td>
                                <td>{{$p->status_izin_atasan}}</td>
                                <td>{{$p->status_izin_ppk}}</td>
                                <td>
                                    @include('components.action-buttons', ['id' => $p->id_perizinan, 'key' => $key,
                                    'route' => 'perizinan'])
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

@can('isAdmin')

<!-- Modal -->
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Perizinan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('perizinan.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_atasan" value="{{ Auth::user()->id_atasan}}">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai Acara</label>
                                    <div class="form-input">
                                        <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                            id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai')}}">
                                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai Acara</label>
                                    <div class="form-input">
                                        <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                            id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai')}}">
                                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_users">Atasan Langsung</label>
                                    <select id="id_users" name="id_users"
                                        class="form-select @error('id_users') is-invalid @enderror">
                                        @foreach ($user as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users )
                                            selected @endif">
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" value="{{old('keterangan')}}">
                                    @error('keterangan') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file_kerja">Surat Pengalaman</label>
                                    <small class="form-text text-muted">Allow file extensions : .jpeg
                                        .jpg .png .pdf
                                        .docx</small>
                                    <input type="file" name="file_kerja" id="file_kerja" class="form-control">
                                    @error('file_kerja')
                                    <span class="textdanger">{{$message}}</span> @enderror
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
@foreach($jenisdiklat as $p)
<div class="modal fade" id="editModal{{$p->id_jenis_diklat}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Jenis Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('jenisdiklat.update',$p->id_jenis_diklat) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $p->id_jenis_diklat }}">
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
                                            value="{{ $p->nama_jenis_diklat ?? old('nama_jenis_diklat') }}">
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