@extends('adminlte::page')
@section('title', 'Import & Export')
@section('content_header')
<h1 class="m-0 text-dark">&nbsp; Import & Export</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="id_users">Nama Pegawai</label>
                                <input type="file" name="file" id="file" required> @error('file')<span
                                    class="textdanger">{{ $message }}</span>@enderror
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
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Pegawai</th>
                                    <th>email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach($user as $s)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{$s->kode_finger}}</td>
                                    <td>{{$s->nama_pegawai}}</td>
                                    <td>{{$s->email}}</td>
                                </tr>
                                @endforeach
                            </tbody>
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