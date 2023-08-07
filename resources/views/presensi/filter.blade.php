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
                        <div class="d-flex">
                            <form action="{{ route('presensi.filterAdmin') }}" method="GET">
                                <div class="d-flex justify-content-center align-items">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Tanggal Awal:</label>
                                        <input type="date" id="start_date" name="start_date" required class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Tanggal Akhir:</label>
                                        <input type="date" id="end_date" name="end_date" required class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="height: min-content">Filter</button>
                                </div>
                            </form>

                            <a href="{{ route('presensi.filterDataAdmin', ['start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')]) }}">Export Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-stripped" id="example2">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pegawai</th>
                                        <th>Kehadiran</th>
                                        <th>Terlambat</th>
                                        <th>Ijin</th>
                                        <th>Sakit</th>
                                        <th>Cuti Sakit</th>
                                        <th>Cuti Tahunan</th>
                                        <th>Cuti Melahirkan</th>
                                        <th>Dinas Luar</th>
                                        <th>ALPHA</th>
                                        <th>Cuti Bersama</th>
                                        <th>Cuti Haji</th>
                                        <th>Tugas Belajar</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach($presensis as $key => $presensi)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{ $presensi['user'] }}</td>
                                            <td>{{ $presensi['kehadiran'] }}</td>
                                            <td>{{ $presensi['terlambat'] }}</td>
                                            <td>{{ $presensi['ijin'] }}</td>
                                            <td>{{ $presensi['sakit'] }}</td>
                                            <td>{{ $presensi['cutiSakit'] }}</td>
                                            <td>{{ $presensi['cutiTahunan'] }}</td>
                                            <td>{{ $presensi['cutiMelahirkan'] }}</td>
                                            <td>{{ $presensi['dinasLuar'] }}</td>
                                            <td>{{ $presensi['alpha'] }}</td>
                                            <td>{{ $presensi['cutiBersama'] }}</td>
                                            <td>{{ $presensi['cutiHaji'] }}</td>
                                            <td>{{ $presensi['tugasBelajar'] }}</td>
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