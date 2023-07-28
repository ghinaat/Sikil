@extends('adminlte::page')
@section('title', 'Report Generate')
@section('content_header')
<h1 class="m-0 text-dark">&nbsp; Report Generate</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ route('laporan') }}" class="form-inline">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label class="control-label " for="id_pegawai">Nama Pegawai</label>
                                <select id="id_pegawai" name="id_pegawai"
                                    class="form-select @error('id_pegawai') is-invalid @enderror">
                                    @foreach ($user as $us)
                                    <option value="{{ $us->id_users }}" @if(old('id_pegawai')==$us->id_users) selected
                                        @endif>
                                        {{ $us->nama_pegawai }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group ">
                                <label for="id_peran">Peran</label>
                                <select id="id_peran" name="id_peran"
                                    class="form-select @error('id_peran') is-invalid @enderror">
                                    @foreach ($peran as $p)
                                    <option value="{{ $p->id_peran }}" @if(old('id_peran')==$p->id_peran) selected
                                        @endif>
                                        {{ $p->nama_peran }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fa fa-filter"></i> &nbsp; Filter
                        </button>
                    </form>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-stripped" id="example2">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Nama pegawai</th>
                                    <th>Peran</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timkegiatan as $key => $tk)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$tk->kegiatan->nama_kegiatan }}</td>
                                    <td>{{$tk->user->nama_pegawai}}</td>
                                    <td>{{$tk->peran->nama_peran}}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$tk->id_tim}}" data-id="{{$tk->id_tim}}">Edit</a>
                                        <a href="{{route('timkegiatan.destroy', $tk->id_tim)}}"
                                            onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                            class="btn btn-danger btn-xs">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('table:not(#laporan)').DataTable();

        $('#laporan').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pdfHtml5',
                'print'
            ],
            footer: true
        });
    });
    </script>
</div>

@endsection