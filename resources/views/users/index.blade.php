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
                <div class="d-flex">
                    <div class="col-md-6">
                        @can('isAdmin')
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addModal">Tambah</button>
                        @endcan
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $showDetail = true; @endphp
                            @php $showAdmin = true; @endphp
                            @foreach($user as $key => $user)
                            <tr>
                                <td id="{{$key+1}}">{{$key+1}}</td>
                                <td id="{{$key+1}}">{{$user->nama_pegawai}}</td>
                                <td id={{$key+1}}>
                                    @if($user->jabatan)
                                    {{ $user->jabatan->nama_jabatan }}
                                    @else
                                    Data Kosong
                                    @endif
                                </td>
                                <td id="{{$key+1}}">{{$user->level}}</td>
                                <td>
                                    @can('isAdmin')
                                    @include('components.action-buttons', ['id' => $user->id_users, 'key' => $key,
                                    'route' => 'user'])
                                    @else
                                    <a href="{{ route('user.show', $user->id_users) }}"
                                        class="btn btn-info btn-xs mx-1">
                                        <i class="fa fa-info"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                            @can('isAdmin')
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
                                                    <label for="nama_pegawai">Nama</label>
                                                    <input type="text" name="nama_pegawai" id="nama_pegawai"
                                                        class="form-control @error('nama_pegawai') is-invalid @enderror" value="{{ old('nama_pegawai', $user->nama_pegawai) }}" required>
                                                    @error('nama_pegawai')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Email</label>
                                                    <input type="email" name="email" id="exampleInputEmail"
                                                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->nama_pegawai) }}">
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputlevel">Level</label>
                                                    <select class="form-select @error('level') is-invalid @enderror"
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
                                                        <option value="staf" @if($user->level == 'staf' ||
                                                            old('level')=='staf' )selected
                                                            @endif>STAF</option>
                                                    </select>
                                                    @error('level')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputJabatan">Jabatan</label>
                                                    <select class="form-select @error('jabatan') is-invalid @enderror"
                                                        id="exampleInputJabatan" name="id_jabatan">
                                                        @foreach ($jabatans as $jabatan)
                                                        <option value="{{ $jabatan->id_jabatan }}" @if(old('id_jabatan',$user->id_jabatan) === $jabatan->id_jabatan ) selected @endif>  {{ $jabatan->nama_jabatan }} </option>
                                                        @endforeach

                                                    </select>
                                                    @error('jabatan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Password</label>
                                                    <input type="password" name="password" id="exampleInputPassword"
                                                        class="form-control @error('password') is-invalid @enderror">
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation"
                                                        id="exampleInputPassword" class="form-control @error('confirm_password') is-invalid @enderror">
                                                    @error('confirm_password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
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

@can('isAdmin')
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
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control @error('nama_pegawai') is-invalid @enderror" value="{{ old('nama_pegawai') }}"  required>
                        @error('nama_pegawai')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" name="email" id="exampleInputEmail" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputlevel">Level</label>
                        <select class="form-select @error('level') isinvalid @enderror" id="exampleInputlevel"
                            name="level">
                            <option value="admin" @if(old('level')=='admin' )selected @endif>Admin</option>
                            <option value="kadiv" @if(old('level')=='kadiv' )selected @endif>Kadiv</option>
                            <option value="dda" @if(old('level')=='dda' )selected @endif>DDA</option>
                            <option value="ddo" @if(old('level')=='ddo' )selected @endif>DDO</option>
                            <option value="staf" @if(old('level')=='staf' )selected @endif>STAF</option>
                        </select>
                        @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputJabatan">Jabatan</label>
                        <select class="form-select @error('jabatan') isinvalid @enderror" id="exampleInputJabatan"
                            name="id_jabatan">
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id_jabatan }}" @if( old('id_jabatan')==$jabatan->id_jabatan
                                )
                                selected @endif>
                                {{ $jabatan->nama_jabatan }}</option>
                            @endforeach

                        </select>
                        @error('jabatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('confirm_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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
$('#example2').DataTable({
    "responsive": true,
});
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
