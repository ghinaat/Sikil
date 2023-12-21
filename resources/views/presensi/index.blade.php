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
{{-- <div class="container"> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    @if(auth()->user()->level === 'admin')
                    <form action="{{ route('presensi.filter') }}" method="GET" class="form-inline mb-3">
                        <div class="input-group">
                            <label for="tanggalFilter" class="my-label mr-2">Tanggal :</label>
                            <input type="date" class="form-control" name="tanggalFilter" id="tanggalFilter"
                                value="{{request()->input('tanggalFilter')}}" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="get" action="{{route('presensi.user')}}" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Awal :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tglawal') is-invalid @enderror" id="tglawal"
                                name="tglawal" value="{{request()->input('tglawal')}}" required> &nbsp; &nbsp;&nbsp;

                            <label for="tanggal">Tanggal Akhir :</label> &nbsp;&nbsp;
                            <input type="date"
                                class="form-control border-primary @error('tglakhir') is-invalid @enderror"
                                id="tglakhir" name="tglakhir" value="{{request()->input('tglakhir')}}" required> &nbsp;
                            &nbsp;

                            <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>
                        </div>
                    </form>
                    @endif

                    <br>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                @if(auth()->user()->level === 'admin')
                                <th>Nama Pegawai</th>
                                @endif
                                <th>Tanggal</th>
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
                                @endif
                                <td> {{ \Carbon\Carbon::parse($pn->tanggal)->format('d M Y') }}</td>
                                <td>{{$pn->jam_masuk}}</td>
                                <td>{{$pn->jam_pulang}}</td>
                                <td>{{$pn->terlambat}}</td>
                                <td>{{$pn->kehadiran}}</td>
                                <td>{{$pn->jenis_perizinan}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}
</section>
@stop
@push('js')
<script>
$('#example2').DataTable({
    "responsive": true,
});
</script>
@endpush