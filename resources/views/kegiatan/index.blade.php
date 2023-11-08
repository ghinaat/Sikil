@extends('adminlte::page')
@if(auth()->user()->level == 'admin')
@section('title', 'List kegiatan')
@else
@section('title', 'Daftar kegiatan')
@endif
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@if(auth()->user()->level == 'admin')
<h1 class="m-0 text-dark">List kegiatan</h1>
@else
<h1 class="m-0 text-dark">Daftar kegiatan</h1>
@endif
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
                                <th>Aksi</th>
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
                                <td id={{$key+1}}>{{ \Carbon\Carbon::parse($kg->tgl_mulai)->format('d M Y') }}</td>
                                <td id={{$key+1}}>{{ \Carbon\Carbon::parse($kg->tgl_selesai)->format('d M Y') }}</td>
                                <td id={{$key+1}}>{{$kg->status}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('kegiatan' . '.show', $kg->id_kegiatan) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                        @can('isAdmin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$kg->id_kegiatan}}" data-id="{{$kg->id_kegiatan}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('kegiatan' . '.destroy', $kg->id_kegiatan) }}"
                                            onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                            class="btn btn-danger btn-xs mx-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
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
                                                            class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                                            id="nama_kegiatan" name="nama_kegiatan"
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
                                                            id="tgl_mulai" name="tgl_mulai"
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
                                                            id="tgl_selesai" name="tgl_selesai"
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
                                                            id="lokasi" name="lokasi"
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
                                                            id="peserta" name="peserta"
                                                            value="{{$kg -> peserta ?? old('peserta')}}">
                                                        @error('peserta') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Batal</button>
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

<!-- Create Modal -->
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
                                id="nama_kegiatan" name="nama_kegiatan" value="{{old('nama_kegiatan')}}">
                            @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
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
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <div class="form-input">
                            <input type="date" class="form-control"
                                class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                                name="tgl_selesai" value="{{old('tgl_selesai')}}">
                            @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                                name="lokasi" value="{{old('lokasi')}}">
                            @error('lokasi') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="peserta" class="form-label">Peserta</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('peserta') is-invalid @enderror" id="peserta"
                                name="peserta" value="{{old('peserta')}}">
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
    var table = $('#example2').DataTable({
        "responsive": true,
        "columnDefs": [{
            "orderable": false,
            "targets": [2],
            "type": "date",
            "render": function(data, type, row) {
                if (type === 'sort') {
                    // Format tanggal untuk sort secara descending ke format ISO 8601
                    return data.split(' ').reverse().join('-');
                }
                return data;
            },
        }, ],
    });

    // Inisialisasi nomor yang disimpan di data-attribute
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});
</script>
@endpush