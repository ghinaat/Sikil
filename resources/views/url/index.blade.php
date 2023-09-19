@extends('adminlte::page')
@section('title', 'List Url')
@section('content_header')
<h1 class="m-0 text-dark">List Url</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
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
                                <th>Nama Shortlink</th>
                                <th>Jenis</th>
                                <th>Tautan</th>
                                <th>Unduh Qrcode</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($url as $key => $url)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td> <a href="{{ route('url.redirect',$url->url_short) }}"
                                        target="_blank">http://127.0.0.1:8000/{{$url->url_short}}</a></td>
                                <td>{{$url->jenis}}</td>
                                <td>{{$url->url_address}}</td>
                                <td id={{$key+1}}>
                                    <img src="{{ asset( '/storage/qrcodes/' . $url->qrcode_image ) }}" alt="Gambar Dokumen" width=95%>
                                </td>
                                <td>
                                    @include('components.action-buttons', ['id' => $url->id_url, 'key' => $key, 'route'
                                    => 'url'])
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{$url->id_url}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$url->id_url}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Perizinan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('url.update', $url->id_url) }}"
                                                enctype="multipart/form-data" method="post">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" value="{{ Auth::user()->id_users}}"
                                                    name="id_users">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="jenis">Jenis URL</label>
                                                            <select
                                                                class="form-select  @error('jenis') is-invalid @enderror"
                                                                id="jenis" name="jenis">
                                                                <option value="Form" @if(old('jenis', $url->
                                                                    jenis)=='Form')selected
                                                                    @endif>Form</option>
                                                                <option value="Sertifikat" @if(old('jenis', $url->
                                                                    jenis)=='Sertifikat')selected
                                                                    @endif>Seritfikat</option>
                                                                <option value="Laporan" @if(old('jenis', $url->
                                                                    jenis)=='Laporan')selected
                                                                    @endif>Laporan</option>
                                                                <option value="Multiplelink" @if(old('jenis', $url->
                                                                    jenis)=='Multiplelink')selected
                                                                    @endif>Multiplelink</option>
                                                                <option value="Zoom" @if(old('jenis', $url->
                                                                    jenis)=='Zoom')selected
                                                                    @endif>Zoom</option>
                                                                <option value="Leaflet" @if(old('jenis', $url->
                                                                    jenis)=='Leaflet')selected
                                                                    @endif>Leaflet</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="url_short">Nama Shortlink</label>
                                                            <input type="text" class="form-control" id="url_short"
                                                                name="url_short"
                                                                value="{{$url -> url_short ?? old('url_short') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="url_address">Tautan</label>
                                                            <input type="text" class="form-control" id="url_address"
                                                                value="{{$url -> url_address ?? old('url_address') }}"
                                                                name="url_address" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Url</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('url.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id_users}}" name="id_users">
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <label for="jenis">Jenis URL</label>
                                <select class="form-select  @error('jenis') is-invalid @enderror" id="jenis"
                                    name="jenis">
                                    <option value="Form">Form</option>
                                    <option value="Sertifikat">Seritfikat</option>
                                    <option value="Laporan">Laporan</option>
                                    <option value="Multiplelink">Multiplelink</option>
                                    <option value="Zoom">Zoom</option>
                                    <option value="Leaflet">Leaflet</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="url_short">Nama Shortlink</label>
                                <input type="text" class="form-control" id="url_short" name="url_short" required>
                            </div>
                            <div class="form-group">
                                <label for="url_address">Tautan</label>
                                <input type="text" class="form-control" id="url_address" name="url_address" required>
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

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush
