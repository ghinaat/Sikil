@extends('adminlte::page')
@section('title', 'List Pengalaman Kerja')
@section('content_header')


<h1 class="m-0 text-dark">Profile : {{ Auth::user()->nama_pegawai }}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            @if (Route::currentRouteName() === 'penker.showAdmin')
            @include('partials.nav-pills-profile-admin', ['id_users' => $id_users])
            @else
            @include('partials.nav-pills-profile')
            @endcan
            <div class="card-body">
                <div class="table-responsive">

                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">
                        Tambah
                    </button>

                    <table class="table table-hover table-bordered
table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                @if(auth()->user()->level=='admin' )
                                <th>Nama Pegawai</th>
                                @endif
                                <th>Perusahaan/Instansi</th>
                                <th>Masa Kerja</th>
                                <th>Posisi</th>
                                <th>Surat Pengalaman</th>

                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penker as $key => $pk)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                @if(auth()->user()->level=='admin' )
                                <td id={{$key+1}}>{{$pk->users->nama_pegawai}}</td>
                                @endif
                                <td id={{$key+1}}>{{$pk->nama_perusahaan}}</td>
                                <td id={{$key+1}}>{{$pk->masa_kerja}}</td>
                                <td id={{$key+1}}>{{$pk->posisi}}</td>
                                <td id={{$key+1}} style="text-align: center; vertical-align: middle;">
                                    <a href="{{ asset('/storage/pengalaman_kerja/'. $pk->file_kerja) }}" download>
                                        <i class="fas fa-download"
                                            style="display: inline-block; line-height: normal; vertical-align: middle;"></i>
                                    </a>

                                </td>
                                <td>
                                    @include('components.action-buttons', ['id' => $pk->id_pengalaman_kerja, 'key' =>
                                    $key, 'route' => 'penker'])
                                </td>

                            </tr>

                            <!-- Edit modal -->
                            <div class="modal fade" id="editModal{{$pk->id_pengalaman_kerja}}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabel{{$pk->id_pengalaman_kerja}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Pengalaman Kerja</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('penker.update', $pk->id_pengalaman_kerja) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                @if (isset($id_users) || Auth()->user()->level != 'admin')
                                                <input type="hidden" name="id_users"
                                                    value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                                                @else
                                                <div class="form-group">
                                                    <label class="id_users" for="id_users">Nama Pegawai</label>
                                                    <select id="id_users" name="id_users"
                                                        class="form-select @error('id_users') is-invalid @enderror">
                                                        @foreach ($user->sortByAsc('nama_pegawai') as $us)
                                                        <option value="{{ $us->id_users }}" @if( $pk->id_users ===
                                                            old('id_users', $us->id_users) ) selected @endif>
                                                            {{ $us->nama_pegawai }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                                        id="nama_perusahaan" name="nama_perusahaan"
                                                        value="{{$pk ->nama_perusahaan ?? old('nama_perusahaan')}}"
                                                        required>
                                                    @error('nama_perusahaan') <span
                                                        class="text-danger">{{$message}}</span> @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="masa_kerja" class="form-label">Masa Kerja</label>

                                                    <input type="text"
                                                        class="form-control @error('masa_kerja') is-invalid @enderror"
                                                        id="masa_kerja" name="masa_kerja"
                                                        value="{{$pk ->masa_kerja ?? old('masa_kerja')}}" required>
                                                    @error('masa_kerja') <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="posisi" class="form-label">Posisi</label>

                                                    <input type="text"
                                                        class="form-control @error('posisi') is-invalid @enderror"
                                                        id="posisi" name="posisi" value="{{old('posisi', $pk->posisi)}}"
                                                        required>
                                                    @error('posisi') <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_kerja">Surat Pengalaman</label>
                                                    <input type="file" name="file_kerja" id="file_kerja"
                                                        class="form-control @error('file_kerja') is-invalid @enderror"
                                                        accept="image/jpeg, image/jpg, image/png, application/pdf, application/docx">

                                                    @error('file_kerja')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
                                                    @if ($pk->file_kerja)
                                                    <p>Previous File: <a
                                                            href="{{ asset('/storage/pengalaman_kerja/' . $pk->file_kerja) }}"
                                                            target="_blank">{{ $pk->file_kerja }}</a></p>
                                                    @endif
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

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addMeditlLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pengalaman Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('penker.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($id_users) || Auth()->user()->level != 'admin')
                    <input type="hidden" name="id_users"
                        value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                    @else
                    <div class="form-group">
                        <label class="id_users" for="id_users">Nama Pegawai</label>
                        <select id="id_users" name="id_users"
                            class="form-select @error('id_users') is-invalid @enderror">
                            @foreach ($user->sortBy('nama_pegawai') as $us)
                            <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users) selected @endif>
                                {{ $us->nama_pegawai }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                            id="nama_perusahaan" name="nama_perusahaan" value="{{old('nama_perusahaan')}}" required>
                        @error('nama_perusahaan') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="masa_kerja" class="form-label">Masa Kerja</label>
                        <input type="text" class="form-control @error('masa_kerja') is-invalid @enderror"
                            id="masa_kerja" name="masa_kerja" value="{{old('masa_kerja')}}" required>
                        @error('masa_kerja') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="posisi" class="form-label">Posisi</label>
                        <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi"
                            name="posisi" value="{{old('posisi')}}" required>
                        @error('posisi') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_kerja">Surat Pengalaman</label>
                        <input type="file" name="file_kerja" id="file_kerja"
                            class="form-control @error('file_kerja') is-invalid @enderror"
                            accept="image/jpeg, image/jpg, image/png, application/pdf, application/docx">
                        @error('file_kerja')
                        <span class="text-danger">{{$message}}</span> @enderror
                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .docx</small>
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