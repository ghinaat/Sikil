@extends('adminlte::page')
@section('title', 'Detail Kegiatan')
@section('content_header')
<style>
/* Gaya umum */
</style>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail Kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_kegiatan" class='form-label'>Nama Kegiatan</label>
                    <div class="form-input">
                        : {{$kegiatan -> nama_kegiatan ?? old('nama_kegiatan')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_mulai" class='form-label'>Tanggal Mulai</label>
                    <div class="form-input">
                        : {{$kegiatan -> tgl_mulai ?? old('tgl_mulai')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <div class="form-input">
                        : {{$kegiatan -> tgl_selesai ?? old('tgl_selesai')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <div class="form-input">
                        : {{$kegiatan -> lokasi ?? old('lokasi')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="peserta" class="form-label">Peserta</label>
                    <div class="form-input">
                        : {{$kegiatan -> peserta ?? old('peserta')}}
                    </div>
                </div>

                <div style="margin-top: 30px;"></div>
                <label>Data Tim SEAQIL</label>
                <div class="table-container">
                    <div class="table-responsive">
                        @can('isAdmin')
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form">Add</button>
                        @endcan
                        <table class="table table-hover table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama pegawai</th>
                                    <th>Jabatan</th>
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
                                    <td>{{$tk->user->nama_pegawai}}</td>
                                    <td>{{ $tk->user->jabatan->nama_jabatan }}</td>
                                    <td>{{$tk->peran->nama_peran}}</td>
                                    @can('isAdmin')
                                    <td> <a href="{{route('timkegiatan.destroy', $tk->id_tim)}}"
                                            onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                            class="btn btn-danger btn-xs">
                                            Delete
                                        </a></td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="{{route('kegiatan.index')}}" class="btn btn-primary ">
                    Daftar Kegiatan
                </a>
            </div>
        </div>
    </div>
</div>
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
                <form action="{{ route('kegiatan.storeTimKegiatan') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
                                <table class="table table-hover table-bordered table-stripped" id="example2">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->nama_pegawai }}</td>
                                            <td>{{ $user->jabatan?->nama_jabatan }}</td>
                                            <td>
                                                @php
                                                // Check if the user is already selected for the current $id_kegiatan
                                                $isUserSelected = $timkegiatan->contains('user.id_users',
                                                $user->id_users);
                                                @endphp
                                                @if (!$isUserSelected)
                                                <button type="button" class="btn btn-primary btn-xs"
                                                    onclick="pilih('{{ $user->id_users }}','{{ $user->nama_pegawai }}', '{{ $user->jabatan?->nama_jabatan }}')"
                                                    data-bs-dismiss="modal">
                                                    Pilih
                                                </button>
                                                @else
                                                <p>Sudah dipilih</p>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-4" id="scroll-target">
                                    <div class="form-group ">
                                        <label class="control-label col-md-6">Nama Pegawai</label>
                                        <!-- Tambahkan input tersembunyi untuk menyimpan data yang dipilih -->
                                        <input type="hidden" id="selected_id_users" name="id_users" value="">
                                        <input type="text" class="form-control @error('pegawai') is-invalid @enderror"
                                            placeholder="pegawai" id="pegawai" name="pegawai" aria-label="pegawai"
                                            aria-describedby="cari" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6" for="id_peran">Peran</label>
                                <div class="form-input">
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
<!-- /.modal -->


<!-- <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable p-5">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="myModalLabel">Pencarian Data Pegawai</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-bordered tablestripped" id="example2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->nama_pegawai }}</td>
                            <td>{{ $user->jabatan?->nama_jabatan }}</td>
                            <td>
                                @if($user->timkegiatans->isEmpty())
                                <button type="button" class="btn btn-primary btn-xs"
                                    onclick="pilih('{{ $user->id_users }}','{{ $user->nama_pegawai }}', '{{ $user->jabatan?->nama_jabatan }}')"
                                    data-bs-dismiss="modal">
                                    Pilih
                                </button>
                                @else
                                <p>Sudah dipilih</p>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div> -->
<!-- End Modal -->
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

    // Gulir ke elemen dengan id "scroll-target"
    const scrollTarget = document.getElementById('scroll-target');
    scrollTarget.scrollIntoView({
        behavior: 'smooth'
    });
}
</script>


@endpush