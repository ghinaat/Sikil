@extends('adminlte::page')
@section('title', 'List kegiatan')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<h1 class="m-0 text-dark">List kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @can('isAdmin')
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">
                        Tambah
                    </button>
                    @endcan
                    <table class="table table-hover table-bordered
table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                @can('isAdmin')
                                <th>Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sortedKegiatan = $kegiatan->sortByDesc('tgl_mulai');
                            $nomor = 1; // Initialize a variable to keep track of the sequence
                            @endphp
                            @foreach($sortedKegiatan as $key => $kg)
                            <tr>
                                <td id={{$key+1}}>{{$nomor}}</td>
                                <td id={{$key+1}}>{{$kg->nama_kegiatan}}</td>
                                <td id={{$key+1}}>{{$kg->tgl_mulai}}</td>
                                <td id={{$key+1}}>{{$kg->tgl_selesai}}</td>
                                <td id={{$key+1}}>{{$kg->status}}</td>
                                @can('isAdmin')
                                <td>
                                    <a href="{{route('kegiatan.show', $kg->id_kegiatan)}}"
                                        class="btn btn-success btn-xs">
                                        Detail
                                    </a>

                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$kg->id_kegiatan}}" data-id="{{$kg->id_kegiatan}}"
                                        data-nama="{{$kg->nama_kegiatan}}">Edit</a>

                                    <a href="{{route('kegiatan.destroy', $kg->id_kegiatan)}}"
                                        onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                        class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                                @endcan
                            </tr>
                            @php
                            $nomor++; // Increment the sequence for the next row
                            @endphp
                            <!-- Edit modal -->
                            @can('isAdmin')
                            <div class="modal fade" id="editModal{{$kg->id_kegiatan}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$kg->id_kegiatan}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Kegiatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('kegiatan.update', $kg->id_kegiatan) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="nama_kegiatan" class='form-label'>Nama Kegiatan</label>
                                                    <div class="form-input">

                                                        <input type="text"
                                                            class="form-control @error('nama_kegiatan') is-invalid @enderror "
                                                            id="nama_kegiatan" placeholder="Nama Kegiatan"
                                                            name="nama_kegiatan"
                                                            value="{{$kg -> nama_kegiatan ?? old('nama_kegiatan')}}">
                                                        @error('nama_kegiatan') <span
                                                            class="textdanger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class='form-label'>Tanggal Mulai
                                                        Acara</label>
                                                    <div class="form-input">
                                                        <input type="date" class="form-control"
                                                            class="form-control @error('tgl_mulai') is-invalid @enderror"
                                                            id="tgl_mulai" placeholder="Tanggal Mulai" name="tgl_mulai"
                                                            value="{{$kg -> tgl_mulai ?? old('tgl_mulai')}}">
                                                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                                    <div class="form-input">
                                                        <input type="date" class="form-control"
                                                            class="form-control @error('tgl_selesai') is-invalid @enderror"
                                                            id="tgl_selesai" placeholder="Tanggal Mulai"
                                                            name="tgl_selesai"
                                                            value="{{$kg -> tgl_selesai ?? old('tgl_selesai')}}">
                                                        @error('tgl_selesai') <span
                                                            class="textdanger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lokasi" class="form-label">Lokasi</label>
                                                    <div class="form-input">
                                                        <input type="text"
                                                            class="form-control @error('lokasi') is-invalid @enderror"
                                                            id="lokasi" placeholder="Lokasi" name="lokasi"
                                                            value="{{$kg -> lokasi ?? old('lokasi')}}">
                                                        @error('lokasi') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="peserta" class="form-label">Peserta</label>
                                                    <div class="form-input">
                                                        <input type="text"
                                                            class="form-control @error('peserta') is-invalid @enderror"
                                                            id="peserta" placeholder="Peserta" name="peserta"
                                                            value="{{$kg -> peserta ?? old('peserta')}}">
                                                        @error('peserta') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
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
                            @endcan
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@can('isAdmin')
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addMeditlLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kegiatan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" placeholder="Nama Kegiatan" name="nama_kegiatan"
                                value="{{old('nama_kegiatan')}}">
                            @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai" class="form-label">Tanggal Mulai Acara</label>
                        <div class="form-input">
                            <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                id="tgl_mulai" placeholder="Tanggal Mulai" name="tgl_mulai"
                                value="{{ old('tgl_mulai')}}">
                            @error('tgl_mulai') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <div class="form-input">
                            <input type="date" class="form-control"
                                class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                                placeholder="Tanggal Mulai" name="tgl_selesai" value="{{old('tgl_selesai')}}">
                            @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                placeholder="Lokasi" name="lokasi" value="{{old('lokasi')}}">
                            @error('lokasi') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="peserta" class="form-label">Peserta</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('peserta') is-invalid @enderror" id="peserta"
                                placeholder="Peserta" name="peserta" value="{{old('peserta')}}">
                            @error('peserta') <span class="textdanger">{{$message}}</span> @enderror
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
@endcan
@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$(document).ready(function() {
    $('#example2').DataTable({
        "responsive": true,
        "order": [
            [2, "desc"]
        ] // Sort the first column (Tanggal Mulai) in descending order
    });
});
</script>
@endpush