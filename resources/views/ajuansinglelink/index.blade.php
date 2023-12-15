@extends('adminlte::page')
@section('title', 'List Pengajuan Single Link')
@section('content_header')
<h1 class="m-0 text-dark">Pengajuan Single Link</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tgl Ajuan</th>
                                <th>Pemohon</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ajuansinglelink as $key => $as)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ \Carbon\Carbon::parse($as->tgl_pengajuan)->format('d M Y') }}</td>
                                <td>{{$as->users->nama_pegawai}}</td>
                                <td>{{$as->nama_kegiatan}}</td>
                                <td>@if($as->status == 'diajukan')
                                    Diajukan
                                    @elseif($as->status == 'ready')
                                    Ready
                                    @else
                                    Diajukan
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('ajuansinglelink' . '.show', $as->id_pengajuan_singlelink)}}" class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>

                                        @if(auth()->user()->level === 'admin' || (auth()->user()->id_users === $as->id_users && $as->status !== 'ready'))
                                            <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal" data-target="#editModal{{$as->id_pengajuan_singlelink}}" data-id="{{$as->id_pengajuan_singlelink}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('ajuansinglelink' . '.destroy', $as->id_pengajuan_singlelink) }}" onclick="notificationBeforeDelete(event, this, {{$key+1}})" class="btn btn-danger btn-xs mx-1">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{$as->id_pengajuan_singlelink}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$as->id_pengajuan_singlelink}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Ajuan Single Link</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('ajuansinglelink.update', $as->id_pengajuan_singlelink) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <label for="tgl_pengajuan" class="col-sm-3 col-form-label">Tgl Ajuan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror"
                                                            id="tgl_pengajuan" name="tgl_pengajuan" value="{{ \Carbon\Carbon::parse($as->tgl_pengajuan)->format('d M Y') ?? old('tgl_pengajuan') }}" readonly>
                                                        @error('tgl_pengajuan') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="id_users" class="col-sm-3 col-form-label">Pemohon</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" class="form-control @error('id_users') is-invalid @enderror"
                                                            id="id_users" name="id_users" value="{{$as->users->nama_pegawai ?? old('id_users')}}" readonly>
                                                        @error('id_users') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                                            id="nama_kegiatan" name="nama_kegiatan" value="{{$as-> nama_kegiatan ?? old('nama_kegiatan')}}">
                                                        @error('nama_kegiatan') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_shortlink" class="col-sm-3 col-form-label">Nama Shortlink</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" class="form-control @error('nama_shortlink') is-invalid @enderror"
                                                            id="nama_shortlink" name="nama_shortlink" value="{{$as-> nama_shortlink ?? old('nama_shortlink')}}">
                                                        @error('nama_shortlink') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan_pemohon" class="col-sm-3 col-form-label">Keterangan</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                                            id="keterangan_pemohon" name="keterangan_pemohon" rows="4">{{$as->keterangan_pemohon ?? old('keterangan_pemohon')}}</textarea>
                                                        @error('keterangan_pemohon')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                @can('isAdmin')
                                                <div class="form-group row mb-0">
                                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-input" type="radio" name="status" value="diajukan" id="diajukanRadio" {{ old('status', $as->status) == 'diajukan' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="diajukanRadio">&nbsp;Diajukan</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-input" type="radio" name="status" value="ready" id="readyRadio" {{ old('status', $as->status) == 'ready' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="readyRadio">&nbsp;Ready</label>
                                                        </div>
                                                    </div>
                                                    @error('status')<span class="textdanger">{{$message}}</span>@enderror
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan_operator" class="col-sm-3 col-form-label">Keterangan Operator</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control @error('keterangan_operator') is-invalid @enderror"
                                                            id="keterangan_operator" name="keterangan_operator" rows="4">{{$as->keterangan_operator ?? old('keterangan_operator')}}</textarea>
                                                        @error('keterangan_operator')<span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                @endcan
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Ajuan Single Link</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuansinglelink.store') }}" method="POST" id="form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                <div class="col-md-12">
                                <div class="form-group row">
                                        <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                                id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}">
                                            @error('nama_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama_shortlink" class="col-sm-3 col-form-label">Nama Shortlink</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama_shortlink') is-invalid @enderror"
                                                id="nama_shortlink" name="nama_shortlink" value="{{ old('nama_shortlink') }}">
                                            @error('nama_shortlink')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan_pemohon" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                                id="keterangan_pemohon" name="keterangan_pemohon" rows="4">{{ old('keterangan_pemohon') }}</textarea>
                                            @error('keterangan_pemohon')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajukan</button>
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
    $(document).ready(function () {
        var table = $('#example2').DataTable({
            "responsive": true,
        });

        // Inisialisasi nomor yang disimpan di data-attribute
        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        if (confirm('Apakah anda yakin akan menghapus data ? ')) {
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    }
</script>
@if(count($errors))
<script>
    Swal.fire({
        title: 'Input tidak sesuai!',
        text: 'Pastikan inputan sudah sesuai',
        icon: 'error',
    });

</script>
@endif
@endpush
