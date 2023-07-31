@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
<h1 class="m-0 text-dark">Detail Profile</h1>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.index') }}">Profile</a></li>
                        <li class="nav-item"><a class="nav-link active" href="{{ route('keluarga.index') }}" >Keluarga</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.index') }}" >Pendidikan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('penker.index') }}" >Pengalaman Kerja</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('diklat.index') }}" >Diklat</a></li>
                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="data-pribadi">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                                                    role="dialog">Tambah</button>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-stripped" id="example2">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                @can('isAdmin')
                                                                <th>Nama Pegawai</th>
                                                                @endcan
                                                                <th>Hubungan Keluarga</th>
                                                                <th>Nama Lengkap</th>
                                                                <th>Tanggal Lahir</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Status</th>
                                                                <th>Opsi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($keluarga as $key => $kel)
                                                            <tr>
                                                                <td>{{$key+1}}</td>
                                                                @can('isAdmin')
                                                                <td>{{$kel->users->nama_pegawai}}</td>
                                                                @endcan
                                                                <td>{{$kel->hubkel->nama}}</td>
                                                                <td>{{$kel->nama}}</td>
                                                                <td>{{$kel->tanggal_lahir}}</td>
                                                                <td>{{$kel->gender}}</td>
                                                                <td>{{$kel->status}}</td>
                                                                <td>
                                                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                                        data-target="#editModal{{$kel->id_keluarga}}" data-id="{{$kel->id_keluarga}}"
                                                                        data-nama="{{$kel->nama}}">Edit</a>
                                                                    <a href="{{route('keluarga.destroy', $kel->id_keluarga)}}"
                                                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
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
                                </div>
                                
                                <!-- Modal Tambah Keluarga -->
                                <div class="modal fade" id="modal_form" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Keluarga</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body form">
                                                <form action="{{ route('keluarga.store') }}" method="POST" id="form" class="form-horizontal"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                <!-- <div class="form-group">
                                                                        <label for="exampleInputUsers">Nama Pegawai</label>
                                                                        <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror"
                                                                            id="nama_pegawai" name="nama_pegawai" value="{{ Auth::user()->nama_pegawai}}" readonly>
                                                                        @error('nama_pegawai')<span class="textdanger">{{ $message }}</span>@enderror
                                                                    </div> -->
                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsersHubkel">Hubungan Keluarga</label>
                                                                        <select class="form-select @error('nama') isinvalid @enderror"
                                                                            id="exampleInputHubkel" name="id_hubungan">
                                                                            @foreach ($hubkel as $hk)
                                                                            <option value="{{ $hk->id_hubungan }}" @if( old('id_hubungan')==$hk->id_hubungan )
                                                                                selected @endif">
                                                                                {{ $hk->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="nama">Nama Lengkap</label>
                                                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                                            id="nama" name="nama" value="{{old('nama') }}">
                                                                        @error('nama')<span class="textdanger">{{ $message }}</span>@enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control"
                                                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                                            id="tanggal_lahir" name="tanggal_lahir" value="{{old('tanggal_lahir')}}">
                                                                        @error('tanggal_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputgender">Jenis Kelamin</label>
                                                                        <select class="form-select @error('gender') isinvalid @enderror"
                                                                            id="exampleInputgender" name="gender">
                                                                            <option value="laki-laki" @if(old('gender')=='laki-laki' )selected @endif>
                                                                                Laki-laki</option>
                                                                            <option value="perempuan" @if(old('gender')=='perempuan' )selected @endif>
                                                                                Perempuan</option>
                                                                        </select>
                                                                        @error('gender') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputstatus">Status</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" value="hidup" id="hidupRadio">
                                                                            <label class="form-check-label" for="hidupRadio">Hidup</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" value="meninggal" id="meninggalRadio">
                                                                            <label class="form-check-label" for="meninggalRadio">Meninggal</label>
                                                                        </div>
                                                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
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
                                
                                <!-- Modal Edit Keluarga -->
                                @foreach($keluarga as $kel)
                                <div class="modal fade" id="editModal{{$kel->id_keluarga}}" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Edit Data Keluarga</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body form">
                                                <form action="{{ route('keluarga.update',$kel->id_keluarga) }}" method="POST" id="form"
                                                    class="form-horizontal" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                <!-- <div class="form-group">
                                                                        <label for="exampleInputUsers">Nama Pegawai</label>
                                                                        <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror"
                                                                            id="nama_pegawai" name="nama_pegawai" value="{{ Auth::user()->nama_pegawai}}" readonly>
                                                                        @error('nama_pegawai')<span class="textdanger">{{ $message }}</span>@enderror
                                                                    </div> -->
                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsersHubkel">Hubungan Keluarga</label>
                                                                        <select class="form-select @error('nama') isinvalid @enderror"
                                                                            id="exampleInputHubkel" name="id_hubungan">
                                                                            @foreach ($hubkel as $hk)
                                                                            <option value="{{ $hk->id_hubungan }}" @if($kel->id_hubungan == $hk->id_hubungan) selected @endif> 
                                                                                {{ $hk->nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="nama">Nama Lengkap</label>
                                                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                                            id="nama" name="nama" value="{{ $kel->nama ?? old('nama') }}">
                                                                        @error('nama')<span class="textdanger">{{ $message }}</span>@enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                                                        <input type="date" class="form-control"
                                                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                                            id="tanggal_lahir" name="tanggal_lahir" value="{{$kel->tanggal_lahir ??old('tanggal_lahir')}}">
                                                                        @error('tanggal_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputgender">Jenis Kelamin</label>
                                                                        <select class="form-select @error('gender') isinvalid @enderror"
                                                                            id="exampleInputgender" name="gender">
                                                                            <option value="laki-laki" @if(old('gender', $kel->gender) == 'laki-laki' ) selected @endif>
                                                                                Laki-laki</option>
                                                                            <option value="perempuan" @if(old('gender', $kel->gender) == 'perempuan' ) selected @endif>
                                                                                Perempuan</option>
                                                                        </select>
                                                                        @error('gender') <span class="textdanger">{{$message}}</span> @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputstatus">Status</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" value="hidup" id="hidupRadio">
                                                                            <label class="form-check-label" for="hidupRadio">Hidup</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" value="meninggal" id="meninggalRadio">
                                                                            <label class="form-check-label" for="meninggalRadio">Meninggal</label>
                                                                        </div>
                                                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
