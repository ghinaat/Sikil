@extends('adminlte::page')
@section('title', 'List Pengalaman Kerja')
@section('content_header')


<h1 class="m-0 text-dark">List Pengalaman Kerja</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
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

                                <th>Opsi</th>

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
                                <td id={{$key+1}}>
                                    <a href="{{ asset('/storage/Pengalaman Kerja/'. $pk->file_kerja) }}"
                                        target="_blank">Lihat
                                        Dokumen</a>

                                </td>

                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$pk->id_pengalaman_kerja}}"
                                        data-id="{{$pk->id_pengalaman_kerja}}"
                                        data-nama="{{$pk->nama_perusahaan}}">Edit</a>

                                    <a href="{{route('penker.destroy', $pk->id_pengalaman_kerja)}}"
                                        onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                        class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
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
                                                <input type="hidden" name="id_users"
                                                    value="{{ Auth::user()->id_users}}">
                                                <div class="form-group">
                                                    <label for="nama_perusahaan" class="form-label">Nama
                                                        Perusahaan</label>
                                                    <input type="text"
                                                        class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                                        id="nama_perusahaan" placeholder="Nama Perusahaan"
                                                        name="nama_perusahaan"
                                                        value="{{$pk ->nama_perusahaan ?? old('nama_perusahaan')}}">
                                                    @error('nama_perusahaan') <span
                                                        class="textdanger">{{$message}}</span> @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="masa_kerja" class="form-label">Masa Kerja</label>

                                                    <input type="text"
                                                        class="form-control @error('masa_kerja') is-invalid @enderror"
                                                        id="masa_kerja" placeholder="Masa Kerja" name="masa_kerja"
                                                        value="{{$pk ->masa_kerja ?? old('masa_kerja')}}">
                                                    @error('masa_kerja') <span class="textdanger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label for="posisi" class="form-label">Posisi</label>

                                                    <input type="text"
                                                        class="form-control @error('posisi') is-invalid @enderror"
                                                        id="posisi" placeholder="Posisi" name="posisi"
                                                        value="{{$pk ->posisi ?? old('posisi')}}">
                                                    @error('posisi') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_kerja">Surat Pengalaman</label>
                                                    @if ($pk->file_kerja)
                                                    <p>Previous File: <a
                                                            href="{{ asset('/storage/Pengalaman Kerja/' . $pk->file_kerja) }}"
                                                            target="_blank">{{ $pk->file_kerja }}</a></p>
                                                    @endif
                                                    <input type="file" name="file_kerja" id="file_kerja"
                                                        class="form-control">
                                                    @error('file_kerja')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <a href="{{route('pendidikan.index')}}" class="btn btn-default">
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
                <h5 class="modal-title" id="addModalLabel">Tambah Pengalaman Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('penker.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                    <div class="form-group">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>

                        <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                            id="nama_perusahaan" placeholder="Nama Perusahaan" name="nama_perusahaan"
                            value="{{old('nama_perusahaan')}}">
                        @error('nama_perusahaan') <span class="textdanger">{{$message}}</span> @enderror

                    </div>
                    <div class="form-group">
                        <label for="masa_kerja" class="form-label">Masa Kerja</label>

                        <input type="text" class="form-control @error('masa_kerja') is-invalid @enderror"
                            id="masa_kerja" placeholder="Masa Kerja" name="masa_kerja" value="{{old('masa_kerja')}}">
                        @error('masa_kerja') <span class="textdanger">{{$message}}</span> @enderror

                    </div>
                    <div class="form-group">
                        <label for="posisi" class="form-label">Posisi</label>

                        <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi"
                            placeholder="Posisi" name="posisi" value="{{old('posisi')}}">
                        @error('posisi') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_kerja">Surat Pengalaman</label>
                        <input type="file" name="file_kerja" id="file_kerja" class="form-control"> @error('file_kerja')
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