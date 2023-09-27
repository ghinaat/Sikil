@extends('adminlte::page')
@section('title', 'Laporan Kegiatan')
@section('content_header')
<h1 class="m-0 text-dark">&nbsp; Laporan Kegiatan</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ route('laporan') }}" class="form-inline">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="id_users">Nama Pegawai</label>
                                <select id="id_users" name="id_users"
                                    class="form-select @error('id_users') is-invalid @enderror">
                                    <!-- Tambahkan opsi All dengan value 0 -->
                                    <option value="0" @if(session('selected_id_users', 0)==0) selected @endif>All
                                    </option>
                                    @foreach ($user as $us)
                                    <option value="{{ $us->id_users }}" @if($us->id_users ==
                                        session('selected_id_users')) selected @endif>{{ $us->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group ">
                                <label for="id_peran">Peran</label>
                                <select id="id_peran" name="id_peran"
                                    class="form-select @error('id_peran') is-invalid @enderror">
                                    <option value="0" @if(session('selected_id_peran', 0)==0) selected @endif>All
                                    </option>
                                    @foreach ($peran as $p)
                                    <option value="{{ $p->id_peran }}" @if($p->id_peran ==
                                        session('selected_id_peran')) selected @endif>
                                        {{ $p->nama_peran }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary mb-2">
                                <i class="fa fa-filter"></i> &nbsp; Filter
                            </button>
                        </div>
                    </form>
                    <br>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Nama pegawai</th>
                                    <th>Peran</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timkegiatan as $key => $tk)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$tk->kegiatan->nama_kegiatan }}</td>
                                    <td>{{$tk->user->nama_pegawai}}</td>
                                    <td>{{$tk->peran->nama_peran}}</td>

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