@extends('adminlte::page')
@section('title', 'General Setting')
@section('content_header')
<h1 class="m-0 text-dark">General Setting</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pegawai</th>
                                <th>Tahun Aktif</th>
                                <th>Status</th>
                                <th style="width:189px;">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($generalsetting as $key => $gs)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$gs->users->nama_pegawai}}</td>
                                <td>{{$gs->tahun_aktif}}</td>
                                <td>
                                    @if ($gs->status == 1)
                                    Aktif
                                    @elseif ($gs->status == 0)
                                    Tidak Aktif
                                    @else
                                    Unknown
                                    @endif
                                <td>
                                    @include('components.action-buttons', ['id' => $gs->id_setting, 'key' => $key,
                                    'route' => 'generalsetting'])
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


<!-- Modal -->
<!-- Bootstrap modal Create -->
<!-- Modal Tambah  -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">PPK</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('generalsetting.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-6" for="tahun_aktif">Tahun Aktif</label>
                        <select id="tahun_aktif" name="tahun_aktif"
                            class="form-select @error('tahun_aktif') is-invalid @enderror">
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-6" for="id_users">Nama Pegawai</label>
                        <select id="id_users" name="id_users"
                            class="form-select @error('id_users') is-invalid @enderror">
                            @foreach ($user as $us)
                            <option value="{{ $us->id_users }}" @if( old('id_users')==$us->id_users )
                                selected @endif">
                                {{ $us->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status"></label>
                        <select class="form-select @error('status') isinvalid @enderror" id="status" name="status">
                            <option value="1" @if(old('status')=='1' )selected @endif>Aktif</option>
                            <option value="0" @if(old('status')=='0' )selected @endif>Tidak Aktif </option>
                        </select>
                        @error('status') <span class="textdanger">{{$message}}</span> @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
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

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }

    // Access the select element
    const tahun_aktif = document.getElementById('tahun_aktif');

    // Listen for the 'change' event to capture user selection
    tahun_aktif.addEventListener('change', function() {
        const selectedYear = tahun_aktif.value;
        console.log(`Selected Year: ${selectedYear}`);
    });
}
</script>
@endpush