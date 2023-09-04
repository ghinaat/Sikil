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
                                <th>Jumlah Hari Cuti</th>
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
                                <td id={{$key+1}}>{{date_format( new DateTime($p->tgl_ajuan), 'd F Y')}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($p->tgl_absen_awal), 'd F Y')}} s.d.
                                    {{ date_format( new DateTime($p->tgl_absen_akhir), 'd F Y')}}</td>
                                <td id={{$key+1}}>{{$p->keterangan}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                @if($p->file_perizinan)
                                <a href="{{ asset('/storage/file_perizinan/'. $p->file_perizinan) }}"
                                        target="_blank"><i class="fa fa-download"></i></a>
                                @else
                                Tidak Melampirkan Dokumen
                                @endif
                                </td>
                                <td id={{$key+1}}>{{$p->jumlah_hari_pengajuan}}</td>
                                <td id={{$key+1}}>
                                    @if($p->status_izin_atasan == '0')
                                    Ditolak
                                    @elseif($p->status_izin_atasan == '1')
                                    Disetujui
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
                            <!-- Edit -->
                            <div class="modal fade" id="editModal{{$p->id_perizinan}}" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Perizinan</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('perizinan.update', $p->id_perizinan) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <input type="hidden" name="kode_finger"
                                                                value="{{ Auth::user()->kode_finger}}">
                                                            <div class="form-group">
                                                                <label for="tgl_absen_awal" class='form-label'>Tanggal
                                                                    Awal
                                                                    Izin</label>
                                                                <div class="form-input">
                                                                    <input type="date" class="form-control"
                                                                        class="form-control @error('tgl_absen_awal') is-invalid @enderror"
                                                                        id="tgl_absen_awal" placeholder="Nama Diklat"
                                                                        name="tgl_absen_awal"
                                                                        value="{{$p -> tgl_absen_awal ?? old('tgl_absen_awal')}}" required>
                                                                    @error('tgl_absen_awal') <span
                                                                        class="textdanger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_absen_akhir" class='form-label'>Tanggal
                                                                    Akhir
                                                                    Izin</label>
                                                                <div class="form-input">
                                                                    <input type="date" class="form-control"
                                                                        class="form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                                                        id="tgl_absen_akhir" placeholder="Nama Diklat"
                                                                        name="tgl_absen_akhir"
                                                                        value="{{$p -> tgl_absen_akhir ?? old('tgl_absen_akhir')}}" required>
                                                                    @error('tgl_absen_akhir') <span
                                                                        class="textdanger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jenis_perizinan">Jenis Perizinan</label>
                                                                <select
                                                                    class="form-control  @error('jenis_perizinan') is-invalid @enderror"
                                                                    id="jenis_perizinan" name="jenis_perizinan">
                                                                    <option value="I" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='I')selected
                                                                        @endif>Izin</option>
                                                                    <option value="DL" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='DL' )selected
                                                                        @endif>Dinas Luar</option>
                                                                    <option value="S" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='S' )selected
                                                                        @endif>Sakit</option>
                                                                    <option value="CS" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CS' )selected
                                                                        @endif>Cuti Sakit</option>
                                                                    <option value="Prajab" @if(old('jenis_perizinan',
                                                                        $p->jenis_perizinan)=='Prajab'
                                                                        )selected @endif>Prajab</option>
                                                                    <option value="CT" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CT' )selected
                                                                        @endif>Cuti Tahunan</option>
                                                                    <option value="CM" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CM' )selected
                                                                        @endif>Cuti Melahirkan</option>
                                                                    <option value="CAP" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CAP' )selected
                                                                        @endif>CAP</option>
                                                                    <option value="CH" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CH' )selected
                                                                        @endif>Cuti Haji</option>
                                                                    <option value="CB" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='CB' )selected
                                                                        @endif>Cuti Bersama</option>
                                                                    <option value="A" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='A' )selected
                                                                        @endif>Alpha</option>
                                                                    <option value="TB" @if(old('jenis_perizinan', $p->
                                                                        jenis_perizinan)=='TB' )selected
                                                                        @endif>Tugas Belajar</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea rows="5" class="form-control" id="keterangan"
                                                                    name="keterangan" required>{{$p -> keterangan ?? old('keterangan')}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="id_atasan" for="id_atasan">Atasan
                                                                    Langsung</label>
                                                                <select id="id_atasan" name="id_atasan"
                                                                    class="form-control @error('id_atasan') is-invalid @enderror">
                                                                    @foreach ($users as $us)
                                                                    <option value="{{ $us->id_users }}" @if( $p->
                                                                        id_atasan === old('id_atasan', $us->id_users) )
                                                                        selected @endif>
                                                                        {{ $us->nama_pegawai }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                @foreach ($settingperizinan as $ps)
                                                                @if ($ps->setting && $ps->setting->status == '1')
                                                                <label for="id">PPK</label>
                                                                <input type="text"
                                                                    class="form-control @error('') is-invalid @enderror"
                                                                    id="id" name="" value="{{ $ps->nama_pegawai}}"
                                                                    readonly>
                                                                @error('') <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="file_perizinan">Unggah Lampiran</label>
                                                                @if ($p->file_perizinan)
                                                                <p>Previous File: <a href="{{ asset('/storage/file_perizinan/' . $p->file_perizinan) }}" target="_blank">{{ $p->file_perizinan }}</a></p>
                                                                @endif
                                                                <small class="form-text text-muted">Allow file extensions: .jpeg .jpg .png .pdf .docx</small>
                                                                <input type="file" class="form-control @error('file_perizinan') is-invalid @enderror" id="file_perizinan_edit" name="file_perizinan" onchange="validateFile(this, 'fileErrorEdit')">
                                                                <div class="invalid-feedback" id="fileErrorEdit" style="display: none;">Tipe file tidak valid. Harap unggah file dengan ekstensi yang diizinkan.</div>
                                                                @error('file_perizinan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                                <a href="{{route('perizinan.index')}}"
                                                                    class="btn btn-danger">
                                                                    Batal
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                            value="{{ old('tgl_absen_awal')}}" required>
                                        @error('tgl_absen_awal') <span class="textdanger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_absen_akhir" class="form-label">Tanggal Akhir Izin</label>
                                    <div class="form-input">
                                        <input type="date"
                                            class="form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                            id="tgl_absen_akhir" name="tgl_absen_akhir"
                                            value="{{ old('tgl_absen_akhir')}}" required>
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
                                        <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users )
                                            selected @endif">
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea rows="4" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan"  required>{{old('keterangan')}}</textarea>
                                    @error('keterangan') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group">
                                    @foreach ($settingperizinan as $ps)
                                    @if ($ps->setting && $ps->setting->status == '1')
                                    <label for="id">PPK</label>
                                    <input type="text" class="form-control @error('') is-invalid @enderror" id="id"
                                        name="" value="{{ $ps->nama_pegawai}}" readonly>
                                    @error('') <span class="text-danger">{{$message}}</span> @enderror
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="file_perizinan">Unggah Lampiran</label>
                                    <small class="form-text text-muted">Allow file extensions: .jpeg .jpg .png .pdf .docx</small>
                                    <input type="file" class="form-control @error('file_perizinan') is-invalid @enderror" id="file_perizinan" name="file_perizinan" onchange="validateFile(this, 'fileErrorCreate')">
                                    <div class="invalid-feedback" id="fileErrorCreate" style="display: none;">Tipe file tidak valid. Harap unggah file dengan ekstensi yang diizinkan.</div>
                                    @error('file_perizinan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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

<script>
function validateFile(input, errorElementId) {
    const allowedExtensions = ['.jpeg', '.jpg', '.png', '.pdf', '.docx'];
    const fileInput = input.files[0];
    const fileErrorElement = document.getElementById(errorElementId);

    if (fileInput) {
        const fileName = fileInput.name;
        const fileExtension = '.' + fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            fileErrorElement.style.display = 'block';
            input.classList.add('is-invalid');
            input.value = ''; // Clear the input
        } else {
            fileErrorElement.style.display = 'none';
            input.classList.remove('is-invalid');
        }
    }
}
</script>

@endpush