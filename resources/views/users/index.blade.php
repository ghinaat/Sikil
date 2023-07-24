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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pegawai</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user as $key => $user)
                            <tr>
                                <td id="{{$key+1}}">{{$key+1}}</td>
                                <td id="{{$key+1}}">{{$user->nama_pegawai}}</td>
                                <td id="{{$key+1}}">{{$user->email}}</td>
                                <td id="{{$key+1}}">{{$user->level}}</td>
                                <td id={{$key+1}}>
                                    @if($user->jabatan)
                                    {{ $user->jabatan->nama_jabatan }}
                                    @else
                                    N/A
                                    @endif</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$user->id_users}}" data-id="{{$user->id_users}}"
                                        data-nama="{{$user->nama_pegawai}}">Edit</a>
                                    <a href="{{ route('user.destroy', $user) }}"
                                        onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                        class="btn btn-danger btn-xs">Delete</a>
                                </td>
                            </tr>
                            <!-- Modal Edit Pegawai -->
                            <div class="modal fade" id="editModal{{$user->id_users}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Pegawai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('user.update', $user->id_users)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="nama_pegawai">Nama Pegawai</label>
                                                    <input type="text" name="nama_pegawai" id="nama_pegawai"
                                                        class="form-control" value="{{ $user->nama_pegawai }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Email</label>
                                                    <input type="email" name="email" id="exampleInputEmail"
                                                        class="form-control" value="{{$user->email ??old('email')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Password</label>
                                                    <input type="password" name="password" id="exampleInputPassword"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation"
                                                        id="exampleInputPassword" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputlevel">Level</label>
                                                    <select class="form-control @error('level') isinvalid @enderror"
                                                        id="exampleInputlevel" name="level">
                                                        <option value="admin" @if($user->level == 'admin' ||
                                                            old('level')=='admin' )selected
                                                            @endif>Admin</option>
                                                        <option value="kadiv" @if($user->level == 'kadiv' ||
                                                            old('level')=='kadiv' )selected
                                                            @endif>Kadiv</option>
                                                        <option value="dda" @if($user->level == 'dda' ||
                                                            old('level')=='dda' )selected @endif>DDA
                                                        </option>
                                                        <option value="ddo" @if($user->level == 'ddo' ||
                                                            old('level')=='ddo' )selected @endif>DDO
                                                        </option>
                                                        <option value="staff" @if($user->level == 'staff' ||
                                                            old('level')=='staff' )selected
                                                            @endif>STAFF</option>
                                                    </select>
                                                    @error('level') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputJabatan">Jabatan</label>
                                                    <select class="form-control @error('jabatan') isinvalid @enderror"
                                                        id="exampleInputJabatan" name="id_jabatan">
                                                        @foreach ($jabatans as $jabatan)
                                                        <option value="{{ $jabatan->id_jabatan }}" @if(
                                                            old('id_jabatan')==$jabatan->id_jabatan ) selected @endif">
                                                            {{ $jabatan->nama_jabatan }}</option>
                                                        @endforeach

                                                    </select>
                                                    @error('level') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Save</button>
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
                <form id="addForm" action="{{ route('user.store') }}" method="post">
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
                        <input type="password" name="password" id="exampleInputPasword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="exampleInputPassword"
                            class="form-control" required>
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
                    <div class="form-group">
                        <label for="exampleInputJabatan">Jabatan</label>
                        <select class="form-control @error('jabatan') isinvalid @enderror" id="exampleInputJabatan"
                            name="id_jabatan">
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" @if( old('id_jabatan')==$jabatan->id_jabatan )
                                selected @endif">
                                {{ $jabatan->nama_jabatan }}</option>
                            @endforeach

                        </select>
                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="submitBtn">Save</button>
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