@extends('adminlte::page')
@section('title', 'List Lembur')
@section('content_header')
<h1 class="m-0 text-dark">List Lembur</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <form action="{{ route('lembur.filter') }}" method="GET" class="form-inline mb-3">
                            <div class="form-group mb-2">
                                <label for="start_date" class="my-label mr-2">Tanggal
                                    Awal:&nbsp;</label>
                                <input type="date" id="start_date" name="start_date" required
                                    class="form-control" value="{{request()->input('start_date')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label for="end_date" class="form-label">Tanggal Akhir:</label>&nbsp;&nbsp;
                                <input type="date" id="end_date" name="end_date" required
                                    class="form-control" value="{{request()->input('end_date')}}">&nbsp;&nbsp;
                                <button type="submit" class="btn btn-primary">&nbsp;Tampilkan</button>
                            </div>
                            <div>
                                
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
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Waktu Lembur</th>
                                <th>Uraian Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lembur as $key => $lr)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{$lr->user->nama_pegawai}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($lr->tanggal), 'd F Y')}}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_mulai)->format('H:i') }}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_selesai)->format('H:i') }}
                                </td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_lembur)->format('H:i') }}</td>
                                <td id={{$key+1}}>{{$lr->tugas}}</td>
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

    </script>
    @endpush
