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
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$lr->id_lembur}}" data-id="{{$lr->id_lembur}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if (auth()->user()->level == 'admin')
                                        <a href="{{ route('lembur.destroy', $lr->id_lembur) }}"
                                            onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                            class="btn btn-danger btn-xs mx-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Lembur -->
    <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
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
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jam_mulai">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jam_selesai">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                                            required >
                                    </div>
                                    <div class="form-group">
                                        <label for="tugas">Uraian Tugas</label>
                                        <textarea name="tugas" id="tugas" class="form-control" required></textarea>
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
