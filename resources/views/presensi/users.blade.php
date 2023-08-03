@extends('adminlte::page')
@section('title', 'Report Generate')
@section('content_header')
<h1 class="m-0 text-dark">&nbsp; Data Presensi</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ route('presensi') }}" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Awal :</label> &nbsp;&nbsp;
                            <input type="date" class="form-control border-primary @error('tglawal') is-invalid @enderror"
                                id="tglawal" name="tglawal" value="{{ request()->input('tglawal') }}"> &nbsp; &nbsp;&nbsp;

                            <label for="tanggal">Tanggal Akhir :</label> &nbsp;&nbsp;
                            <input type="date" class="form-control border-primary @error('tglakhir') is-invalid @enderror"
                                id="tglakhir" name="tglakhir" value="{{ request()->input('tglakhir') }}"> &nbsp; &nbsp;

                            <button type="submit" class="btn btn-primary">
                                &nbsp;Tampilkan</button>
                        </div>
                    </form>
                    
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Terlambat</th>
                                    <th>Total Kehadiran</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($presensi as $key => $pn)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$pn->tanggal}}</td>
                                    <td>{{$pn->jam_masuk}}</td>
                                    <td>{{$pn->jam_pulang}}</td>
                                    <td>{{$pn->terlambat}}</td>
                                    <td>{{$pn->kehadiran}}</td>
                                    <td>{{$pn->keterangan}}</td>
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
@stop
@push('js')
<script>
    $('#example2').DataTable({
        "responsive": true,
    });

</script>
@endpush
