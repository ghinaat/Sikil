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
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{$p->jenis_perizinan}}</td>
                                <td id={{$key+1}}>{{$p->tgl_ajuan}}</td>
                                <td id={{$key+1}}>{{$p->tgl_absen_awal}} - {{$p->tgl_absen_akhir}}</td>
                                <td id={{$key+1}}>{{$p->keterangan}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset('/storage/perizinan/'. $p->file_perizinan) }}" target="_blank"><i
                                            class="fa fa-download"></i></a>
                                </td>
                                <td id={{$key+1}}>
                                    @if($p->status_izin_atasan == '0')
                                    Ditolak
                                    @elseif($p->status_izin_atasan == '1')
                                    Disetujui
                                    @elseif($p->jenis_perizinan == 'I')

                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                <td id={{$key+1}}>
                                    @if($p->status_izin_ppk == '0')
                                    Ditolak
                                    @elseif($p->status_izin_ppk == '1')
                                    Disetujui
                                    @elseif($p->jenis_perizinan == 'I')

                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
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
                <form action="{{ route('perizinan.pengajuan') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="kode_finger" value="{{ Auth::user()->kode_finger}}">
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
                                    <label for="jenis_perizinan">Jenis Ajuan</label>
                                    <select class="form-control  @error('jenis_perizinan') is-invalid @enderror"
                                        id="jenis_perizinan" name="jenis_perizinan">
                                        <option value="I">Izin</option>
                                        <option value="DL">Dinas Luar</option>
                                        <option value="S">Sakit</option>
                                        <option value="CS">Cuti Sakit</option>
                                        <option value="Prajab">Prajab</option>
                                        <option value="CT">Cuti Tahunan</option>
                                        <option value="CM">Cuti Melahirkan</option>
                                        <option value="CAP">CAP</option>
                                        <option value="CH">Cuti Haji</option>
                                        <option value="CB">Cuti Bersama</option>
                                        <option value="A">Alpha</option>
                                        <option value="TB">Tugas Belajar</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_atasan">Atasan Langsung</label>
                                    <select id="id_atasan" name="id_atasan"
                                        class="form-select @error('id_atasan') is-invalid @enderror">
                                        @foreach ($users as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_atasan')==$us->id_users )
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
                                    @foreach ($settingperizinan as $ps)
                                    @if($ps->status == '1')
                                    <label for="keterangan">PPK</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" value="{{ $ps->id_users}}">
                                    @error('keterangan') <span class="text-danger">{{$message}}</span> @enderror
                                    @endif
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
        </div>
    </div>
</div>



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