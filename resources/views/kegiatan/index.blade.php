@extends('adminlte::page')
@section('title', 'List kegiatan')
@section('content_header')
<style>
.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.form-label {
    flex: 1;
    margin-right: 10px;
}

.form-input {
    flex: 2;
}
</style>

<h1 class="m-0 text-dark">List kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">
                    Tambah
                </button>
                <table class="table table-hover table-bordered
table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lokasi</th>
                            <th>Peserta</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatan as $key => $kg)
                        <tr>
                            <td id={{$key+1}}>{{$key+1}}</td>
                            <td id={{$key+1}}>{{$kg->nama_kegiatan}}</td>
                            <td id={{$key+1}}>{{$kg->tgl_mulai}}</td>
                            <td id={{$key+1}}>{{$kg->tgl_selesai}}</td>
                            <td id={{$key+1}}>{{$kg->lokasi}}</td>
                            <td id={{$key+1}}>{{$kg->peserta}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                    data-target="#editModal">
                                    Edit
                                </button>
                                <a href="{{route('kegiatan.destroy', $kg->id_kegiatan)}}"
                                    onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                    class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
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
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control
@error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" placeholder="Nama Kegiatan" name="nama_kegiatan"
                            value="{{old('nama_kegiatan')}}">
                        @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
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
                        <label for="tgl_selesai">Tanggal Selese</label>
                        <input type="date" class="form-control"
                            class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                            placeholder="Tanggal Mulai" name="tgl_selesai" value="{{old('tgl_selesai')}}">
                        @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control
@error('lokasi') is-invalid @enderror" id="lokasi" placeholder="Lokasi" name="lokasi" value="{{old('lokasi')}}">
                        @error('lokasi') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="peserta">Peserta</label>
                        <input type="text" class="form-control
@error('peserta') is-invalid @enderror" id="peserta" placeholder="Peserta" name="peserta" value="{{old('peserta')}}">
                        @error('peserta') <span class="textdanger">{{$message}}</span> @enderror
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('kegiatan.index')}}" class="btn
btn-default">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit modal -->
@foreach($kegiatan as $kg)
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form action="{{ route('kegiatan.update', $kg) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control
@error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" placeholder="Nama Kegiatan" name="nama_kegiatan"
                            value="{{$kg -> nama_kegiatan ?? old('nama_kegiatan')}}">
                        @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai">Tanggal Mulai Acara</label>
                        <input type="date" class="form-control"
                            class="form-control @error('tgl_mulai') is-invalid @enderror" id="tgl_mulai"
                            placeholder="Tanggal Mulai" name="tgl_mulai"
                            value="{{$kg -> tgl_mulai ?? old('tgl_mulai')}}">
                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai">Tanggal Selese</label>
                        <input type="date" class="form-control"
                            class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                            placeholder="Tanggal Mulai" name="tgl_selesai"
                            value="{{$kg -> tgl_selesai ?? old('tgl_selesai')}}">
                        @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control
@error('lokasi') is-invalid @enderror" id="lokasi" placeholder="Lokasi" name="lokasi"
                            value="{{$kg -> lokasi ?? old('lokasi')}}">
                        @error('lokasi') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="peserta">Peserta</label>
                        <input type="text" class="form-control
@error('peserta') is-invalid @enderror" id="peserta" placeholder="Peserta" name="peserta"
                            value="{{$kg -> peserta ?? old('peserta')}}">
                        @error('peserta') <span class="textdanger">{{$message}}</span> @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('kegiatan.index')}}" class="btn
btn-default">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endforeach
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$('#example2').DataTable({
    "responsive": true,
});

function notificationBeforeDelete(event, el, dt) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data Kategori Wisata \"' + document.getElementById(dt).innerHTML +
            '\" ?')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush