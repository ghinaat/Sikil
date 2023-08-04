@extends('adminlte::page')
@section('title', 'Presensi Pegawai')
@section('content_header')
@if(auth()->user()->level === 'admin')
<h1 class="m-0 text-dark">Presensi Pegawai</h1>
@else
<h1 class="m-0 text-dark">&nbsp; Data Presensi</h1>
@endif
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->level === 'admin')
                    <form action="{{ route('presensi.filter') }}" method="GET" class="form-inline mb-3">
                        <div class="input-group">
                            <label for="tanggalFilter" class="my-label mr-2">Tanggal :</label>
                            <input type="date" class="form-control" name="tanggalFilter" id="tanggalFilter" value="{{request()->input('tanggalFilter')}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="get" action="{{route('presensi.user')}}" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Awal :</label> &nbsp;&nbsp;
                            <input type="date" class="form-control border-primary @error('tglawal') is-invalid @enderror"
                                id="tglawal" name="tglawal" value="{{request()->input('tglawal')}}"> &nbsp; &nbsp;&nbsp;

                            <label for="tanggal">Tanggal Akhir :</label> &nbsp;&nbsp;
                            <input type="date" class="form-control border-primary @error('tglakhir') is-invalid @enderror"
                                id="tglakhir" name="tglakhir" value="{{request()->input('tglakhir')}}"> &nbsp; &nbsp;

                            <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>
                        </div>
                    </form>
                    @endif
                    
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    @if(auth()->user()->level === 'admin')
                                    <th>Nama Pegawai</th>
                                    @else
                                    <th>Tanggal</th>
                                    @endif
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Terlambat</th>
                                    <th>Total Kehadiran</th>
                                    <th>Keterangan</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($presensi as $key => $pn)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    @if(auth()->user()->level === 'admin') 
                                    <td>{{optional($pn->user)->nama_pegawai}}</td>
                                    @else 
                                    <td>{{$pn->tanggal}}</td>
                                    @endif
                                    <td>{{$pn->jam_masuk}}</td>
                                    <td>{{$pn->jam_pulang}}</td>
                                    <td>{{$pn->terlambat}}</td>
                                    <td>{{$pn->kehadiran}}</td>
                                    <td>{{$pn->keterangan}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


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
