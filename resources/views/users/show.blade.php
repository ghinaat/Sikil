@extends('adminlte::page')
@section('title', 'Detail User')
@section('content_header')
<style>
/* Gaya umum */
</style>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail User</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_pegawai" class='form-label'>Nama Pegawai</label>
                    <div class="form-input">
                        <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" placeholder="Nama Pegawai" name="nama_pegawai"
                            value="{{$user->nama_pegawai ?? old('nama_pegawai')}}" readonly>
                        @error('nama_pegawai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class='form-label'>Email</label>
                    <div class="form-input">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email"
                            value="{{$user->email ?? old('email')}}" readonly>
                        @error('email') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="jabatan" class='form-label'>Jabatan</label>
                    <div class="form-input">
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" placeholder="jabatan" name="jabatan"
                            value="{{$user->jabatan->nama_jabatan ?? old('jabatan')}}" readonly>
                        @error('jabatan') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="level" class='form-label'>Level</label>
                    <div class="form-input">
                        <input type="text" class="form-control @error('level') is-invalid @enderror" id="level" placeholder="level" name="level"
                            value="{{$user->level ?? old('level')}}" readonly>
                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('user.index')}}" class="btn btn-primary ">
                    Kembali
                </a>
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
<script>
function pilih(id, nama_pegawai) {
    // Mengisi nilai input dengan data yang dipilih dari tabel
    document.getElementById('selected_id_users').value = id;
    document.getElementById('pegawai').value = nama_pegawai;
}
</script>


@endpush
