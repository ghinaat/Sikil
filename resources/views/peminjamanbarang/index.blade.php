@extends('adminlte::page')
@section('title', 'List Peminjaman Barang TIK')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Peminjaman Barang TIK</h1>
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
                                <th>Tanggal Pinjam</th>
                                <th>Kegiatan</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $showDetail = true; @endphp
                            @foreach($peminjaman as $key => $pj)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td id={{$key+1}}>{{ \Carbon\Carbon::parse($pj->tgl_pinjam)->format('d M Y') }}</td>
                                <td>{{$pj->kegiatan}}</td>
                                <td>{{$pj->users->nama_pegawai}}</td>
                                <td>{{$pj->status}}</td>
                                <td>
                                    @if($pj->status == "diajukan")
                                    @include('components.action-buttons', ['id' => $pj->id_peminjaman, 'key' => $key,
                                    'route' => 'peminjaman'])
                                    @else
                                    @endif

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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Peminjaman Barang TIK </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('peminjaman.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <input type="hidden" name="id_users"
                            value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                        <div class="form-group">
                            <label for="tgl_peminjaman" class='form-label'>Tanggal Peminjaman</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror"
                                    id="tgl_peminjaman" name="tgl_peminjaman" value="{{ old('tgl_peminjaman')}}">
                                @error('tgl_peminjaman') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengembalian" class='form-label'>Tanggal Pengembalian</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror"
                                    id="tgl_pengembalian" name="tgl_pengembalian" value="{{ old('tgl_pengembalian')}}">
                                @error('tgl_pengembalian') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan" class='form-label'>Nama Kegiatan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('kegiatan') is-invalid @enderror"
                                    id="kegiatan" name="kegiatan" value="{{ old('kegiatan')}}">
                                @error('kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class='form-label'>Keterangan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan" name="keterangan" value="{{ old('keterangan')}}">
                                @error('keterangan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($peminjaman as $pj)
<div class="modal fade" id="editModal{{$pj->id_peminjaman}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Peminjaman</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('peminjaman.update',$pj->id_peminjaman) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $pj->id_peminjaman }}">

                    <div class="form-body">
                        <input type="hidden" name="id_users"
                            value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                        <div class="form-group">
                            <label for="tgl_peminjaman" class='form-label'>Tanggal Peminjaman</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror"
                                    id="tgl_peminjaman" name="tgl_peminjaman"
                                    value="{{ $pj->tgl_peminjaman ?? old('tgl_peminjaman')}}">
                                @error('tgl_peminjaman') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengembalian" class='form-label'>Tanggal
                                Pengembalian</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror"
                                    id="tgl_pengembalian" name="tgl_pengembalian"
                                    value="{{ $pj->tgl_pengembalian ?? old('tgl_pengembalian')}}">
                                @error('tgl_pengembalian') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan" class='form-label'>Nama Kegiatan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('kegiatan') is-invalid @enderror"
                                    id="kegiatan" name="kegiatan" value="{{ $pj->kegiatan ?? old('kegiatan')}}">
                                @error('kegiatan') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class='form-label'>Status</label>
                            <div class="form-input">
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="diajukan" @if($pj->status == 'diajukan' ||
                                        old('status')=='diajukan' )selected
                                        @endif>Diajukan</option>
                                    <option value="dipinjam" @if($pj->status == 'dipinjam' ||
                                        old('status')=='dipinjam' )selected @endif>Dipinjam
                                    </option>
                                    <option value="dikembalikan_sebagian" @if($pj->status == 'dikembalikan_sebagian' ||
                                        old('status')=='dikembalikan_sebagian' )selected
                                        @endif>Dikembalikan Sebagian</option>
                                    <option value="dikembalikan" @if($pj->status == 'dikembalikan' ||
                                        old('status')=='dikembalikan' )selected @endif>Dikembalikan
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class='form-label'>Keterangan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan" name="keterangan" value="{{ $pj->keterangan ?? old('keterangan')}}">
                                @error('keterangan') <span class="textdanger">{{$message}}</span>
                                @enderror
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