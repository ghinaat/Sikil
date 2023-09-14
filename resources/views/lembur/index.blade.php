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
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Jumlah Jam</th>
                                <th>Uraian Tugas</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lembur as $key => $lr)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($lr->tanggal), 'd F Y')}}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_mulai)->format('H:i') }}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_selesai)->format('H:i') }}
                                </td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_lembur)->format('H:i') }}</td>
                                <td id={{$key+1}}>{{$lr->tugas}}</td>
                                <td id={{$key+1}}>       
                                    @if($lr->status_izin_atasan == '0')
                                    Ditolak
                                    @elseif($lr->status_izin_atasan == '1')
                                    Disetujui
                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                <td>
                                    @if($lr->status_izin_atasan === '1')
                                    Sudah Disetujui
                                    @else
                                    @include('components.action-buttons', ['id' => $lr->id_lembur, 'key' => $key,
                                    'route' => 'lembur'])
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit -->
                            <div class="modal fade" id="editModal{{$lr->id_lembur}}" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Lembur</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('lembur.update', $lr->id_lembur) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <input type="hidden" name="kode_finger"
                                                                value="{{ Auth::user()->kode_finger}}">
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
                                                                <label class="id_atasan" for="id_atasan">Atasan Langsung</label>
                                                                <select id="id_atasan" name="id_atasan"
                                                                    class="form-select @error('id_atasan') is-invalid @enderror">
                                                                    @foreach ($users as $us)
                                                                    <option value="{{ $us->id_users }}" @if( $lr->id_atasan === old('id_atasan', $us->id_users) ) selected @endif>
                                                                        {{ $us->nama_pegawai }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
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
                                <input type="hidden" name="kode_finger" value="{{ Auth::user()->kode_finger}}">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal"
                                        value="{{ old('tanggal')}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="jam_mulai"
                                        value="{{ old('jam_mulai')}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="jam_selesai"
                                        value="{{ old('jam_selesai')}}" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="tugas">Uraian Tugas</label>
                                    <textarea name="tugas" id="tugas" class="form-control"
                                        value="{{ old('tugas')}}" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_atasan">Atasan Langsung</label>
                                    <select id="id_atasan" name="id_atasan"
                                        class="form-select @error('id_atasan') is-invalid @enderror">
                                        @foreach ($users as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_atasan') === $us->id_users )
                                            selected @endif>
                                            {{ $us->nama_pegawai }}
                                        </option>
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
</script>
@endpush
