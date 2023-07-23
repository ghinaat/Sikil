@extends('adminlte::page')
@section('title', 'Data Tim Kegiatan')
@section('content_header')
<h1 class="m-0 text-dark">Data Tim Kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                <table class="table table-hover table-bordered 
table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Nama pegawai</th>
                            <th>Peran</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timkegiatan as $key => $tk)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$tk->kegiatan->nama_kegiatan }}</td>
                            <td>{{$tk->user->nama_pegawai}}</td>
                            <td>{{$tk->peran}}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                    data-target="#editModal{{$tk->id_tim}}" data-id="{{$tk->id_tim}}">Edit</a>
                                <button onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Tim Kegiatan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('timkegiatan.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_kegiatan">Nama Kegiatan</label>
                                    <select id="id_kegiatan" name="id_kegiatan"
                                        class="form-control @error('id_kegiatan') is-invalid @enderror">
                                        @foreach ($kegiatan as $kg)
                                        <option value="{{ $kg->id_kegiatan }}" @if( old('id_kegiatan')==$kg->id_kegiatan
                                            ) selected @endif>
                                            {{ $kg->nama_kegiatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_pegawai">Nama Pegawai</label>
                                    <select id="id_pegawai" name="id_pegawai"
                                        class="form-control @error('id_pegawai') is-invalid @enderror">
                                        @foreach ($user as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_pegawai')==$us->id_users )
                                            selected @endif">
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Peran</label>
                                    <input type="text" class="form-control
@error('peran') is-invalid @enderror" id="peran" placeholder="Peran" name="peran" value="{{old('peran')}}">
                                    @error('peran') <span class="textdanger">{{$message}}</span> @enderror
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
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($timkegiatan as $tk)
<div class="modal fade" id="editModal{{$tk->id_tim}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Tim Kegiatan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('timkegiatan.update', $tk->id_tim) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Ganti "value" dengan nilai ID timkegiatan yang sesuai -->
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_kegiatan">Nama Kegiatan</label>
                                    <select id="id_kegiatan" name="id_kegiatan"
                                        class="form-control @error('id_kegiatan') is-invalid @enderror">
                                        @foreach ($kegiatan as $kg)
                                        <option value="{{ $kg->id_kegiatan }}" @if( old('id_kegiatan')==$kg->id_kegiatan
                                            ) selected @endif>
                                            {{ $kg->nama_kegiatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_pegawai">Nama Pegawai</label>
                                    <select id="id_pegawai" name="id_pegawai"
                                        class="form-control @error('id_pegawai') is-invalid @enderror">
                                        @foreach ($user as $us)
                                        <option value="{{ $us->id_users }}" @if( old('id_pegawai')==$us->id_users )
                                            selected @endif">
                                            {{ $us->nama_pegawai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Peran</label>
                                    <input type="text" class="form-control
@error('peran') is-invalid @enderror" id="peran" placeholder="Peran" name="peran"
                                        value="{{$tk -> peran ?? old('peran')}}">
                                    @error('peran') <span class="textdanger">{{$message}}</span> @enderror
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