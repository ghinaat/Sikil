@extends('adminlte::page')
@section('title', 'List Pegawai')
@section('content_header')
<h1 class="m-0 text-dark">List Pegawai</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Tambah</button>

                <table class="table table-hover table-bordered
table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pegawai</th>
                            <th>Email</th>
                            <th>level</th>
                            <th>Active</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $key => $user)
                        <tr>
                            <td id={{$key+1}}>{{$key+1}}</td>

                            <td id={{$key+1}}>{{$user->nama_pegawai}}</td>
                            <td id={{$key+1}}>{{$user->email}}</td>
                            <td id={{$key+1}}>{{$user->level}}</td>
                            <td id={{$key+1}}>{{$user->is_deletd}}</td>
                            <td>
                                <a href="{{route('user.edit',
                                    $user->id_users)}}" class="btn btn-primary btn-xs"><i class="fas fa-pen"
                                        aria-hidden="true"></i>
                                    Edit
                                </a>
                                <a href="{{route('user.destroy',  $user->id_users)}}"
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
<!-- Modal Tambah Pegawai -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" name="email" id="exampleInputEmail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" name="password" id="exampleInputPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputlevel">Level</label>
                        <select class="form-control @error('level') isinvalid @enderror" id="exampleInputlevel"
                            name="level">
                            <option value="admin" @if(old('level')=='admin' )selected @endif>Admin</option>
                            <option value="kadiv" @if(old('level')=='kadiv' )selected @endif>Kadiv</option>
                            <option value="dda" @if(old('level')=='dda' )selected @endif>DDA</option>
                            <option value="ddo" @if(old('level')=='ddo' )selected @endif>DDO</option>
                            <option value="staff" @if(old('level')=='staff' )selected @endif>STAFF</option>
                        </select>
                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('jabatan.index')}}" class="btn
btn-default">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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