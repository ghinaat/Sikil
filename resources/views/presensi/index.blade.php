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
                        <div class="row mb-3">
                            <div class="col-md-3 d-flex">
                                <form action="{{ route('presensi.filter') }}" method="GET" class="flex-grow-1">
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="tanggalFilter" id="tanggalFilter">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary" id="cariButton">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="ml-3 d-flex align-items-right">
                                    <label for="tanggalFilter" class="mb-0 my-label" margin-left="10px";>Tanggal</label>
                                </div>
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
                                        <th>Total Kehadiran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensi as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ optional($data->user)->nama_pegawai  }}</td>
                                        <td>{{ $data->jam_masuk }}</td>
                                        <td>{{ $data->jam_keluar }}</td>
                                        <td>{{ $data->terlambat }}</td>
                                        <td>{{ $data->total_kehadiran }}</td>
                                        <td>{{ $data->keterangan }}</td>
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
