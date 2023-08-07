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
                        <div class="form-group mb-2">
                            <form action="{{ route('presensi.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <label for="import" class="my-label mr-2 mt-1">Import Presensi:</label>&nbsp;&nbsp;
                                    <input type="file" name="file" id="file" class="form-control">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Import</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <form action="{{ route('presensi.filterAdmin') }}" method="GET" class="form-inline mb-3">
                            <div class="form-group mb-2">

                                <label for="start_date" class="my-label mr-2">Tanggal
                                    Awal:&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="date" id="start_date" name="start_date" required
                                    class="form-control">&nbsp;&nbsp;

                                <label for="end_date" class="form-label">Tanggal Akhir:</label>&nbsp;&nbsp;
                                <input type="date" id="end_date" name="end_date" required
                                    class="form-control">&nbsp;&nbsp;


                                <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>

                                <a href="{{ route('presensi.filterDataAdmin', ['start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')]) }}"
                                    class="btn btn-danger" style="margin-left: 250px;">Export
                                    Data</a>

                            </div>

                        </form>


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