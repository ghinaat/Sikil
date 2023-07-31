@extends('adminlte::page')
@section('title', 'Data Tim Kegiatan')
@section('content_header')
<h1 class="m-0 text-dark">Data Tim Kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                @endcan
                <table class="table table-hover table-bordered table-stripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Nama pegawai</th>
                            <th>Peran</th>
                            @can('isAdmin')
                            <th>Opsi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timkegiatan as $key => $tk)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$tk->kegiatan->nama_kegiatan }}</td>
                            <td>{{$tk->user->nama_pegawai}}</td>
                            <td>{{$tk->peran->nama_peran}}</td>
                            @can('isAdmin')
                            <td>
                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                    data-target="#editModal{{$tk->id_tim}}" data-id="{{$tk->id_tim}}">Edit</a>
                                <a href="{{route('timkegiatan.destroy', $tk->id_tim)}}"
                                    onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                    class="btn btn-danger btn-xs">
                                    Delete
                                </a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@can('isAdmin')

<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Tim Kegiatan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('timkegiatan.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_kegiatan">Nama Kegiatan</label>
                                    <select id="id_kegiatan" name="id_kegiatan"
                                        class="form-select @error('id_kegiatan') is-invalid @enderror">
                                        @foreach ($kegiatan as $kg)
                                        <option value="{{ $kg->id_kegiatan }}" @if( old('id_kegiatan')==$kg->id_kegiatan
                                            ) selected @endif>
                                            {{ $kg->nama_kegiatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
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
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_peran">Peran</label>
                                    <select class="form-select @error('nama') isinvalid @enderror" id="id_peran"
                                        name="id_peran">
                                        @foreach ($peran as $p)
                                        <option value="{{ $p->id_peran }}" @if( old('id_peran')==$p->
                                            id_peran )
                                            selected @endif">
                                            {{ $p->nama_peran }}</option>
                                        @endforeach
                                    </select>
                                    @error('level') <span class="textdanger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($timkegiatan as $tk)
<div class="modal fade" id="editModal{{$tk->id_tim}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Tim Kegiatan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('timkegiatan.update', $tk->id_tim) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Ganti "value" dengan nilai ID timkegiatan yang sesuai -->
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-6" for="id_kegiatan">Nama Kegiatan</label>
                                    <select id="id_kegiatan" name="id_kegiatan"
                                        class="form-select @error('id_kegiatan') is-invalid @enderror">
                                        @foreach ($kegiatan as $kg)
                                        <option value="{{ $kg->id_kegiatan }}" @if( old('id_kegiatan')==$kg->id_kegiatan
                                            ) selected @endif>
                                            {{ $kg->nama_kegiatan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
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
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_peran">Peran</label>
                                    <select class="form-select @error('nama') isinvalid @enderror" id="id_peran"
                                        name="id_peran">
                                        @foreach ($peran as $p)
                                        <option value="{{ $p->id_peran }}" @if( old('id_peran')==$p->
                                            id_peran )
                                            selected @endif">
                                            {{ $p->nama_peran }}</option>
                                        @endforeach
                                    </select>
                                    @error('level') <span class="textdanger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endcan


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



function notificationBeforeDelete(event, el, dt) {
    event.preventDefault();


    var user = document.getElementById(dt).innerHTML;

    // Menampilkan SweetAlert dengan opsi konfirmasi
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: 'Apakah Anda yakin akan menghapus data User "' + user + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        // Jika pengguna mengklik tombol "Ya, Hapus!"
        if (result.isConfirmed) {
            // Ambil atribut href dari elemen yang diklik dan gunakan sebagai action form
            $("#delete-form").attr('action', $(el).attr('href'));
            // Submit form
            $("#delete-form").submit();
        }
    });
}
</script>
@endpush