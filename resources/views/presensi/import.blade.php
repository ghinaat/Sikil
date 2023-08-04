@extends('adminlte::page')

@section('title', 'Presensi Pegawai')

@section('content_header')
<h1 class="m-0 text-dark">Presensi Pegawai</h1>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('presensi.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="file" name="file" id="file" class="form-control">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-stripped" id="example2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Terlambat</th>
                                        <th>Pulang Cepat</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensi as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ optional($data->user)->nama_pegawai  }}</td>
                                        <td>{{ $data->jam_masuk }}</td>
                                        <td>{{ $data->jam_pulang }}</td>
                                        <td>{{ $data->terlambat }}</td>
                                        <td>{{ $data->pulang_cepat }}</td>
                                        <td>{{ $data->kehadiran }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('js')
<script>
$('#example2').DataTable({
    "responsive": true,
});
</script>
@endpush