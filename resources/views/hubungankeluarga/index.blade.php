@extends('adminlte::page')
@section('title', 'List Hubungan Keluarga')
@section('content_header')
<h1 class="m-0 text-dark">List Hubungan Keluarga</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">Tambah</button>
                @endcan
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Urutan</th>
                                <th>Nama</th>
                                @can('isAdmin')
                                <th>Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hubkel as $key => $hk)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$hk->urutan}}</td>
                                <td>{{$hk->nama}}</td>
                                @can('isAdmin')
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$hk->id_hubungan}}" data-id="{{$hk->id_hubungan}}"
                                        data-nama="{{$hk->nama_hubungan}}">Edit</a>
                                    <a href="{{route('hubkel.destroy', $hk->id_hubungan)}}"
                                        onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@can('isAdmin')
<!-- Modal Tambah HubunganKeluarga -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Hubungan Keluarga</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('hubkel.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="urutan">Urutan</label>
                                        <input type="number" class="form-control 
                                        @error('urutan') is-invalid @enderror" id="urutan" name="urutan"
                                            value="{{old('urutan')}}">
                                        @error('urutan') <span class="textdanger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{old('nama')}}">
                                        @error('nama')<span class="textdanger">{{ $message }}</span>@enderror
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

<!-- Modal Edit HubunganKeluarga -->
@foreach($hubkel as $hk)
<div class="modal fade" id="editModal{{$hk->id_hubungan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Hubungan Keluarga</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('hubkel.update',$hk->id_hubungan) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $hk->id_hubungan }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="urutan">Urutan</label>
                                        <input type="number" class="form-control 
                                        @error('urutan') is-invalid @enderror" id="urutan" name="urutan"
                                            value="{{$hk->urutan ?? old('urutan') }}">
                                        @error('urutan') <span class="textdanger">{{$message}}</span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ $hk->nama ?? old('nama') }}">
                                        @error('nama')<span class="textdanger">{{ $message }}</span>@enderror
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

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        if (confirm('Apakah anda yakin akan menghapus data ? ')) {
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    }

</script>
@endpush
