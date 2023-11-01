@extends('adminlte::page')
@section('title', 'List Lembur')
@section('content_header')
<h1 class="m-0 text-dark">List Lembur</h1>
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
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Jumlah Jam</th>
                                <th>Uraian Tugas</th>
                                @can('isAdmin')
                                <th>Status</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lembur as $key => $lr)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($lr->tanggal), 'd M Y')}}</td>
                                <td id={{$key+1}}>{{$lr->user->nama_pegawai}}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_mulai)->format('H:i') }}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_selesai)->format('H:i') }}
                                </td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_lembur)->format('H:i') }}</td>
                                <td id={{$key+1}}>{{$lr->tugas}}</td>
                                @can('isAdmin')
                                <td id={{$key+1}}>
                                    @if($lr->status_izin_atasan == '0')
                                    Ditolak
                                    @elseif($lr->status_izin_atasan == '1')
                                    Disetujui
                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                @endcan
                                <td>
                                    <div class="btn-group">
                                        @if($lr->id_atasan == auth()->user()->id_users && auth()->user()->level !=
                                        'admin' )
                                        @if($lr->status_izin_atasan === '1')
                                        Sudah Disetujui
                                        @elseif($lr->status_izin_atasan === '0')
                                        Tidak Disetujui
                                        @else
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$lr->id_lembur}}" data-id="{{$lr->id_lembur}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endif
                                        @endif
                                        @can('isAdmin' )
                                        @if($lr->status_izin_atasan === '1')
                                        Disetujui
                                        @else
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$lr->id_lembur}}" data-id="{{$lr->id_lembur}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('lembur' . '.destroy', $lr->id_lembur) }}"
                                            onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                            class="btn btn-danger btn-xs mx-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{$lr->id_lembur}}" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Persetujuan Lembur</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('lembur.status', $lr->id_lembur) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            @can('isAdmin')
                                                            <div class="form-group">
                                                                <label for="kode_finger">Nama Pegawai</label>
                                                                <select id="kode_finger" name="kode_finger"
                                                                    class="form-select @error('kode_finger') is-invalid @enderror">
                                                                    @foreach ($users as $u)
                                                                    <option value="{{ $u->kode_finger }}"
                                                                        {{ $lr->kode_finger == $u->kode_finger ? 'selected' : '' }}>
                                                                        {{ $u->nama_pegawai }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input type="date" name="tanggal" id="tanggal"
                                                                    value="{{$lr -> tanggal ?? old('tanggal')}}"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_mulai">Jam Mulai</label>
                                                                <input type="time" name="jam_mulai" id="jam_mulai"
                                                                    value="{{$lr -> jam_mulai ?? old('jam_mulai')}}"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_selesai">Jam Selesai</label>
                                                                <input type="time" name="jam_selesai" id="jam_selesai"
                                                                    value="{{$lr -> jam_selesai ?? old('jam_selesai')}}"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tugas">Uraian Tugas</label>
                                                                <textarea name="tugas" id="tugas" class="form-control"
                                                                    required>{{$lr -> tugas ?? old('tugas')}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="id_atasan" for="id_atasan">Atasan
                                                                    Langsung</label>
                                                                <select id="id_atasan" name="id_atasan"
                                                                    class="form-select @error('id_atasan') is-invalid @enderror">
                                                                    @foreach ($users as $us)
                                                                    <option value="{{ $us->id_users }}" @if( $lr->
                                                                        id_atasan == old('id_atasan', $us->id_users) )
                                                                        selected @endif>
                                                                        {{ $us->nama_pegawai }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @endcan
                                                            <div class="form-group">
                                                                <label for="status_izin_atasan">Apakah anda menyetujui
                                                                    lembur {{$lr->user->nama_pegawai}}?</label>
                                                                <div class="input">
                                                                    <input type="radio" name="status_izin_atasan"
                                                                        value="1" @if ($lr->status_izin_atasan === '1')
                                                                    checked @endif> Disetujui<br>
                                                                    <input type="radio" name="status_izin_atasan"
                                                                        value="0" @if ($lr->status_izin_atasan === '0')
                                                                    checked @endif> Ditolak<br>
                                                                </div>
                                                            </div>
                                                            <div id="alasan_ditolak_atasan" style="display: none;"
                                                                class="form-group">
                                                                <label for="alasan_ditolak_atasan">Alasan
                                                                    Ditolak</label>
                                                                <textarea name="alasan_ditolak_atasan"
                                                                    id="alasan_ditolak_atasan" cols="30" rows="3"
                                                                    class="form-control">{{ $lr->alasan_ditolak_atasan }}</textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Batal</button>
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

<!-- Modal Tambah Lembur -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Lembur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lembur.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="kode_finger">Nama Pegawai</label>
                                    <select id="kode_finger" name="kode_finger"
                                        class="form-select @error('kode_finger') is-invalid @enderror">
                                        @foreach ($users as $us)
                                        <option value="{{ $us->kode_finger }}" @if( old('kode_finger')==$us->id_users
                                            )selected @endif>
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                    @error('kode_finger') <span class="textdanger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal')}}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai')}}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai')}}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tugas">Uraian Tugas</label>
                                    <textarea name="tugas" id="tugas" class="form-control" value="{{ old('tugas')}}"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_atasan">Atasan Langsung</label>
                                    <select id="id_atasan" name="id_atasan"
                                        class="form-select @error('id_atasan') is-invalid @enderror">
                                        @foreach ($users as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_atasan')==$us->
                                            id_users )selected
                                            @endif>
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
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
document.querySelectorAll('input[type=radio][name=status_izin_atasan]').forEach(input => input.addEventListener(
    'change',
    function() {
        const alasanDitolakElement = this.parentNode.parentNode.parentNode.querySelector(
            '#alasan_ditolak_atasan');
        const alasanTextarea = alasanDitolakElement.querySelector('textarea[name=alasan_ditolak_atasan]');

        if (this.value === '0') {
            alasanDitolakElement.style.display = 'block';
            // Tambahkan atribut required
            alasanTextarea.setAttribute('required', 'true');
        } else {
            alasanDitolakElement.style.display = 'none';
            // Hapus atribut required
            alasanTextarea.removeAttribute('required');
        }
    }));

function updateRecord(event, rowNumber, id_lembur, newStatus) {
    event.preventDefault(); // Prevent the default link behavior

    const confirmation = confirm("Are you sure you want to update this record?"); // Display a confirmation dialog

    if (confirmation) {
        // User confirmed, send AJAX request to update the record
        const token = '{{ csrf_token() }}';

        fetch(`/persetujuan/${id_lembur}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-Token': token,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status_izin_atasan: newStatus
                }),
            })
            .then(response => {
                if (response.ok) {
                    // Handle success (e.g., show a success message, update UI)
                    console.log(`Record ${id_lembur} updated successfully`);
                } else {
                    // Handle errors (e.g., show an error message)
                    console.error(`Error updating record ${id_lembur}`);
                }
            })
            .catch(error => {
                // Handle network errors
                console.error('Network error:', error);
            });
    } else {
        // User canceled the operation
        console.log(`Update of record ${id_lembur} canceled.`);
    }
}
</script>
@endpush