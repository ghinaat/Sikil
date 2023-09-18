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
                                <td>  <a href="{{ route( 'url.redirect', $url ->url_address) }}" target="_blank">{{$url->url_short}}</a></td>
                                <td>{{$url->jenis}}</td>
                                <td>{{$url->url_address}}</td>
                                <td id={{$key+1}}>
                                    <a href="{{ asset( $url->qrcode_image) }}" target="_blank">Lihat
                                        Dokumen</a>

                                </td>
                                <td>
                                @include('components.action-buttons', ['id' => $url->id_url, 'key' => $key, 'route' => 'url'])
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
                            <div class="col-md-12">
                            <div class="form-group">
                                    <label for="jenis">Jenis URL</label>
                                    <select class="form-select  @error('jenis') is-invalid @enderror"
                                        id="jenis" name="jenis">
                                        <option value="Form">Form</option>
                                        <option value="Sertifikat">Seritfikat</option>
                                        <option value="Laporan">Laporan</option>
                                        <option value="Multiplelink">Multiplelink</option>
                                        <option value="Zoom">Zoom</option>
                                        <option value="Leaflet">Leaflet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="url_short">Nama Diklat</label>
                                <input type="text" class="form-control" id="url_short" name="url_short" required>
                            </div>
                            <div class="form-group">
                                <label for="url_address">Nama Diklat</label>
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
