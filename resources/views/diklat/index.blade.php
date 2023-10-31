@extends('adminlte::page')
@section('title', 'List Diklat')
@section('content_header')
<h1 class="m-0 text-dark">Profile : {{ $main_user->nama_pegawai }}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Route::currentRouteName() === 'diklat.showAdmin')
            @include('partials.nav-pills-profile-admin', ['id_users' => $id_users])
            @else
            @include('partials.nav-pills-profile')
            @endcan
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
                                @if(auth()->user()->level=='admin' )
                                <th>Nama Pegawai</th>
                                @endif
                                <th>Jenis Diklat</th>
                                <th>Nama Diklat</th>
                                <th>Penyelenggara</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>JP</th>
                                <th>Sertifikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diklat as $key => $dk)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                @if(auth()->user()->level=='admin' )
                                <td id={{$key+1}}>{{$dk->users->nama_pegawai}}</td>
                                @endif
                                <td id={{$key+1}}>{{$dk->jenisdiklat->nama_jenis_diklat}}</td>
                                <td id={{$key+1}}>{{$dk->nama_diklat}}</td>
                                <td id={{$key+1}}>{{$dk->penyelenggara}}</td>
                                <td id={{$key+1}}>{{ \Carbon\Carbon::parse($dk->tgl_mulai)->format('d M Y') }} -- {{ \Carbon\Carbon::parse($dk->tgl_selesai)->format('d M Y') }}</td>
                                <td id={{$key+1}}>{{$dk->jp}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset('/storage/file_sertifikat/'. $dk->file_sertifikat) }}" download>
                                        <i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>
                                    </a>
                                </td>
                                <td>
                                    @include('components.action-buttons', ['id' => $dk->id_diklat, 'key' => $key,
                                    'route' => 'diklat'])
                                </td>
                            </tr>

                            <!-- Edit modal -->
                            <div class="modal fade" id="editModal{{$dk->id_diklat}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$dk->id_diklat}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Diklat</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('diklat.update', $dk->id_diklat) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                @if (isset($id_users) || Auth()->user()->level != 'admin')
                                                <input type="hidden" name="id_users" value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                                                @else
                                                <div class="form-group">
                                                    <label class="id_users" for="id_users">Nama Pegawai</label>
                                                    <select id="id_users" name="id_users"
                                                        class="form-select @error('id_users') is-invalid @enderror">
                                                            @foreach ($users->sortBy('nama_pegawai') as $us)
                                                            <option value="{{ $us->id_users }}" @if( $dk->id_users === old('id_users', $us->id_users) ) selected @endif>
                                                            {{ $us->nama_pegawai }}
                                                            </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <label class="control-label col-md-6" for="id_jenis_diklat">Jenis Diklat</label>
                                                    <select id="id_jenis_diklat" name="id_jenis_diklat"
                                                        class="form-select @error('id_jenis_diklat') is-invalid @enderror" required>
                                                        @foreach ($jenisdiklat as $jd)
                                                        <option value="{{ $jd->id_jenis_diklat }}" @if($dk->id_jenis_diklat == $jd->id_jenis_diklat || old('id_jenis_diklat') === $jd->id_jenis_diklat) selected @endif> 
                                                            {{ $jd->nama_jenis_diklat }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class='form-label'>Nama Diklat</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control @error('nama_diklat') is-invalid @enderror"
                                                            id="nama_diklat" placeholder="Nama Diklat"
                                                            name="nama_diklat" value="{{$dk->nama_diklat ?? old('nama_diklat')}}" required>
                                                        @error('nama_diklat') <span class="text-danger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror"
                                                            id="penyelenggara" placeholder="Penyelenggara" name="penyelenggara"
                                                            value="{{$dk->penyelenggara ?? old('penyelenggara')}}" required>
                                                        @error('penyelenggara') <span class="text-danger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class='form-label'>Tanggal Mulai</label>
                                                    <div class="form-input">
                                                        <input type="date" class="form-control"
                                                            class="form-control @error('tgl_mulai') is-invalid @enderror"
                                                            id="tgl_mulai" name="tgl_mulai"
                                                            value="{{$dk -> tgl_mulai ?? old('tgl_mulai')}}">
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
                                                            value="{{$dk -> tgl_selesai ?? old('tgl_selesai')}}">
                                                        @error('tgl_selesai') <span
                                                            class="textdanger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jp" class="form-label">Jam Pelajaran</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control @error('jp') is-invalid @enderror"
                                                            id="jp" placeholder="Jp" name="jp" value="{{$dk->jp ?? old('jp')}}" required>
                                                        @error('jp') <span class="text-danger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_sertifikat">File Sertifikat</label>
                                                    <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror" id="file_sertifikat" name="file_sertifikat"
                                                    accept="image/jpeg ,image/jpg ,image/png ,application/pdf ,application/docx">
                                                        @error('file_sertifikat') 
                                                        <span class="invalid" role="alert">{{$message}}</span>
                                                    @enderror
                                                    <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
                                                    @if ($dk->file_sertifikat)
                                                    <p>Previous File: <a
                                                            href="{{ asset('/storage/file_sertifikat/' . $dk->file_sertifikat) }}"
                                                            target="_blank">{{ $dk->file_sertifikat }}</a></p>
                                                    @endif
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Diklat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('diklat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($id_users) || Auth()->user()->level != 'admin')
                    <input type="hidden" name="id_users" value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                    @else
                    <div class="form-group">
                    <label class="id_users" for="id_users">Nama Pegawai</label>
                    <select id="id_users" name="id_users"
                    class="form-select @error('id_users') is-invalid @enderror">
                    @foreach ($users->sortBy('nama_pegawai') as $us)
                    <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users) selected @endif>
                    {{ $us->nama_pegawai }}
                    </option>
                    @endforeach
                    </select>
                    </div>            
                    @endif                                              
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_jenis_diklat">Jenis Diklat</label>
                                    <select id="id_jenis_diklat" name="id_jenis_diklat"
                                        class="form-select @error('id_jenis_diklat') is-invalid @enderror" required>
                                        @foreach ($jenisdiklat->sortByDesc('id_jenis_diklat') as $jd)
                                        <option value="{{ $jd->id_jenis_diklat }}" @if( old('id_jenis_diklat')==$jd->id_jenis_diklat )selected @endif>
                                            {{ $jd->nama_jenis_diklat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Nama Diklat</label>
                                <input type="text" class="form-control @error('nama_diklat') is-invalid @enderror" 
                                    id="nama_diklat" name="nama_diklat" required>
                                    @error('nama_diklat')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName">Penyelenggara</label>
                                <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror"  
                                    id="penyelenggara" name="penyelenggara" required>
                                    @error('penyelenggara')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
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
                                <label for="exampleInputName">Jam Pelajaran</label>
                                <input type="number" class="form-control @error('jp') is-invalid @enderror"  
                                    id="jp" name="jp" required>
                                @error('jp')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>
                            <div class="form-group">
                                <label for="file_sertifikat">File Sertifikat</label>
                                <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror"  
                                    id="file_sertifikat" enctype="multipart/form-data" name="file_sertifikat"
                                    accept="image/jpeg ,image/jpg ,image/png ,application/pdf ,application/docx">
                                    @error('file_sertifikat') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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