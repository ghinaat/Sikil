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
                                <td>{{$p->tgl_absen_awal - tgl_absen_akhir}}</td>
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
                                <input type="hidden" id="tgl_ajuan" name="tgl_ajuan" value="{{ old('tgl_ajuan') }}">
                                <div class="form-group">
                                    <label for="tgl_absen_awal" class="form-label">Tanggal Awal Izin </label>
                                    <div class="form-input">
                                        <input type="date"
                                            class="form-control @error('tgl_absen_awal') is-invalid @enderror"
                                            id="tgl_absen_awal" name="tgl_absen_awal"
                                            value="{{ old('tgl_absen_awal')}}">
                                        @error('tgl_absen_awal') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_absen_akhir" class="form-label">Tanggal Akhir Izin</label>
                                    <div class="form-input">
                                        <input type="date"
                                            class="form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                            id="tgl_absen_akhir" name="tgl_absen_akhir"
                                            value="{{ old('tgl_absen_akhir')}}">
                                        @error('tgl_absen_akhir') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_atasan">Atasan Langsung</label>
                                    <select id="id_atasan" name="id_atasan"
                                        class="form-select @error('id_atasan') is-invalid @enderror">
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
                                    @foreach ($perizinan as $p)
                                    <label for="ppk">ppk</label>
                                    <input type="text" class="form-control @error('ppk') is-invalid @enderror" id="ppk"
                                        name="ppk" value=" {{ $p->user->setting->id }}" @endforeach">
                                    @error('ppk') <span class="text-danger">{{$message}}</span> @enderror
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="file_perizinan">Unggah Lampiran</label>
                                    <small class="form-text text-muted">Allow file extensions : .jpeg
                                        .jpg .png .pdf
                                        .docx</small>
                                    <input type="file" name="file_perizinan" id="file_perizinan" class="form-control">
                                    @error('file_perizinan')
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
<!-- @foreach($jenisdiklat as $p)
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
@endforeach -->


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

document.addEventListener('DOMContentLoaded', function() {
    // Get the current date and time
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');

    // Populate the hidden input field with the current date and time
    document.getElementById('tgl_ajuan').value = formattedDate;
});
</script>
@endpush