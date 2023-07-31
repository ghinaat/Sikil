@extends('adminlte::page')
@section('title', 'List Pendidikan')
@section('content_header')
<h1 class="m-0 text-dark">Detail Profile</h1>

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            @include('partials.nav-pills-profile')

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
                                <th>Tingkat Pendidikan</th>
                                <th>Nama Sekolah</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                                <th>No. Ijazah</th>

                                <th>Opsi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendidikan as $key => $pd)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                @if(auth()->user()->level=='admin' )
                                <td id={{$key+1}}>{{$pd->users->nama_pegawai}}</td>
                                @endif
                                <td id={{$key+1}}>{{$pd->tingpen->nama_tingkat_pendidikan}}</td>
                                <td id={{$key+1}}>{{$pd->nama_sekolah}}</td>
                                <td id={{$key+1}}>{{$pd->jurusan}}</td>
                                <td id={{$key+1}}>{{$pd->tahun_lulus}}</td>
                                <td id={{$key+1}}>
                                    <a href="{{ asset('/storage/pendidikan/'. $pd->ijazah) }}" target="_blank">Lihat
                                        Dokumen</a>

                                </td>

                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$pd->id_pendidikan}}" data-id="{{$pd->id_pendidikan}}"
                                        data-nama="{{$pd->nama_sekolah}}">Edit</a>

                                    <a href="{{route('pendidikan.destroy', $pd->id_pendidikan)}}"
                                        onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                        class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>

                            </tr>
                            <!-- Edit modal -->

                            <div class="modal fade" id="editModal{{$pd->id_pendidikan}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$pd->id_pendidikan}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Pendidikan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('pendidikan.update', $pd->id_pendidikan) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_users"
                                                    value="{{ Auth::user()->id_users}}">

                                                <div class="form-group">
                                                    <label for="id_tingkat_pendidikan"> Tingkat Pendidikan</label>
                                                    <select class="form-select @error('nama') isinvalid @enderror"
                                                        id="id_tingkat_pendidikan" name="id_tingkat_pendidikan">
                                                        @foreach ($tingpen as $tp)
                                                        <option value="{{ $tp->id_tingkat_pendidikan }}" @if(
                                                            old('id_tingkat_pendidikan')==$tp->
                                                            id_tingkat_pendidikan )
                                                            selected @endif">
                                                            {{ $tp->nama_tingkat_pendidikan }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('level') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="nama_sekolah" class="form-label">Nama
                                                        Pendidikan</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_sekolah') is-invalid @enderror"
                                                        id="nama_sekolah" placeholder="Nama Pendidikan"
                                                        name="nama_sekolah"
                                                        value="{{$pd ->nama_sekolah ?? old('nama_sekolah')}}">
                                                    @error('nama_sekolah') <span class="textdanger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="jurusan" class="form-label">Jurusan</label>

                                                    <input type="text"
                                                        class="form-control @error('jurusan') is-invalid @enderror"
                                                        id="jurusan" placeholder="Jurusan" name="jurusan"
                                                        value="{{$pd ->jurusan ?? old('jurusan')}}">
                                                    @error('jurusan') <span class="textdanger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="tahun_lulus" class="form-label">Tahun Lulus</label>

                                                    <input type="text"
                                                        class="form-control @error('tahun_lulus') is-invalid @enderror"
                                                        id="tahun_lulus" placeholder="Tahun Lulus" name="tahun_lulus"
                                                        value="{{$pd ->tahun_lulus ?? old('tahun_lulus')}}"
                                                        maxlength="4">
                                                    @error('tahun_lulus') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">

                                                    <label for="ijazah">Ijazah Kelulusan</label>

                                                    <small class="form-text text-muted">Allow file extensions : .jpeg
                                                        .jpg .png .pdf
                                                        .docx</small>

                                                    @if ($pd->ijazah)
                                                    <p>Previous File: <a
                                                            href="{{ asset('/storage/pendidikan/' . $pd->ijazah) }}"
                                                            target="_blank">{{ $pd->ijazah }}</a></p>
                                                    @endif
                                                    <input type="file" name="ijazah" id="ijazah" class="form-control">
                                                    @error('ijazah')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <a href="{{route('pendidikan.index')}}" class="btn btn-danger">
                                                        Batal
                                                    </a>
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


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addMeditlLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pendidikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pendidikan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">

                    <div class="form-group">
                        <label for="id_tingkat_pendidikan"> Tingkat Pendidikan</label>
                        <select class="form-select @error('nama') isinvalid @enderror" id="id_tingkat_pendidikan"
                            name="id_tingkat_pendidikan">
                            @foreach ($tingpen as $tp)
                            <option value="{{ $tp->id_tingkat_pendidikan }}" @if( old('id_tingkat_pendidikan')==$tp->
                                id_tingkat_pendidikan )
                                selected @endif">
                                {{ $tp->nama_tingkat_pendidikan }}</option>
                            @endforeach
                        </select>
                        @error('level') <span class="textdanger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah" class="form-label">Nama
                            Sekolah</label>
                        <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror"
                            id="nama_sekolah" placeholder="Nama Sekolah" name="nama_sekolah"
                            value="{{old('nama_sekolah')}}">
                        @error('nama_sekolah') <span class="textdanger">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="jurusan" class="form-label"> Jurusan</label>

                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan"
                            placeholder="Jurusan" name="jurusan" value="{{ old('jurusan')}}">
                        @error('jurusan') <span class="textdanger">{{$message}}</span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>

                        <input type="text" class="form-control @error('tahun_lulus') is-invalid @enderror"
                            id="tahun_lulus" placeholder="Tahun Lulus" name="tahun_lulus"
                            value="{{  old('tahun_lulus')}}" maxlength="4">
                        @error('tahun_lulus') <span class="textdanger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">

                        <label for="ijazah">Ijazah Kelulusan</label>

                        <small class="form-text text-muted">Allow file extensions : .jpeg
                            .jpg .png .pdf
                            .docx</small>
                            
                        <input type="file" name="ijazah" id="ijazah" class="form-control"> @error('ijazah')
                        <span class="textdanger">{{$message}}</span> @enderror
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
@endpush