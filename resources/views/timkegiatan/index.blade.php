@extends('adminlte::page')
@section('title', 'List Tim Kegiatan')
@section('content_header')
<h1 class="m-0 text-dark">List Tim Kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('timkegiatan.create')}}" class="btn
btn-primary mb-2"><i class="fa fa-plus"></i>
                    Tambah
                </a>
                <table class="table table-hover table-bordered
table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timkegiatan as $key => $tkgtn)
                        <tr>
                            <td id={{$key+1}}>{{$key+1}}</td>
                            <td id={{$key+1}}>{{$tkgtn->id_pegawai}}</td>
                            <td>
                                <a href="{{route('timkegiatan.edit',
                                    $tkgtn->id_jabatan)}}" class="btn btn-primary btn-xs"><i class="fas fa-pen"
                                        aria-hidden="true"></i>
                                    Edit
                                </a>
                                <a href="{{route('timkegiatan.destroy', $tkgtn->id_jabatan)}}"
                                    onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                    class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i>
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

function notificationBeforeDelete(event, el, dt) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data Kategori Wisata \"' + document.getElementById(dt).innerHTML +
            '\" ?')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush