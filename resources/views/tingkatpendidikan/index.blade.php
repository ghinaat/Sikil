@extends('adminlte::page')
@section('title', 'List Tingkat Pendidikan')
@section('content_header')
<h1 class="m-0 text-dark">List Tingkat Pendidikan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <!-- Add button to open the modal for adding educational levels -->
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                @endcan
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Tingkat Pendidikan</th>
                                @can('isAdmin')
                                <th style="width:189px;">Opsi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tingkatpendidikan as $key => $tp)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$tp->nama_tingkat_pendidikan}}</td>
                                @can('isAdmin')
                                <td>
                                    @include('components.action-buttons', ['id' => $tp->id_tingkat_pendidikan, 'key' =>
                                    $key, 'route' => 'tingkatpendidikan'])
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
<!-- Modal -->
<!-- Bootstrap modal Create -->
<!-- Modal Tambah Tingkat Pendidikan -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tingkat Pendidikan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tingkatpendidikan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_tingkat_pendidikan">Nama Tingkat Pendidikan</label>
                        <input type="text" class="form-control" id="nama_tingkat_pendidikan"
                            name="nama_tingkat_pendidikan" required>
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

<!-- Modal Edit Tingkat Pendidikan -->
@foreach($tingkatpendidikan as $tp)
<div class="modal fade" id="editModal{{$tp->id_tingkat_pendidikan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Tingkat Pendidikan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tingkatpendidikan.update', $tp->id_tingkat_pendidikan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_tingkat_pendidikan">Nama Tingkat Pendidikan</label>
                        <input type="text" class="form-control" id="nama_tingkat_pendidikan"
                            name="nama_tingkat_pendidikan" value="{{ $tp->nama_tingkat_pendidikan }}" required>
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
    "order": [[0, 'desc']]
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