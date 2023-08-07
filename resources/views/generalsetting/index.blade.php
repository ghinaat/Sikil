@extends('adminlte::page')
@section('title', 'General Setting')
@section('content_header')
<style>
/* Gaya umum */
</style>
<link rel="stylesheet" href="{{ asset('css/generalsetting.css') }}">
<h1 class="m-0 text-dark">General Setting</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group1">
                    <label for="tahun_aktif" class='form-label'>Tahun Aktif</label>
                    <div class="form-input">
                        : {{$general->tahun_aktif ?? old('tahun_aktif')}}
                    </div>
                </div>
                <div class="form-group1">
                    <label for="id_ppk" class='form-label'>Nama PPK</label>
                    <div class="form-input">
                        : {{$general->id_users->nama_pegawai ?? old('id_users')}}
                    </div>
                </div>
                <div class="form-group1">
                    <label for="status" class='form-label'>Status</label>
                    <div class="form-input">
                        : {{$general->status ?? old('status')}}
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal">
                        Edit
                    </a>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Data General</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body form">
                                    <!-- Form untuk mengedit data -->
                                    <form action="{{ route('generalsetting.update', $general->id_general) }}"
                                        method="post" id="form" class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="tahun_aktif"> Tahun Aktif</label>
                                                            <select
                                                                class="form-control  @error('tahun_aktif') is-invalid @enderror"
                                                                id="tahun_aktif" name="tahun_aktif">
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                                <option value="2022">2022</option>
                                                                <option value="2023">2023</option>
                                                                <option value="2024">2024</option>
                                                                <option value="2025">2025</option>
                                                            </select>
                                                            @error('tahun_aktif')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="id_users">Nama PPK</label>
                                                            <select id="id_users" name="id_users"
                                                                class="form-control @error('id_users') is-invalid @enderror">
                                                                @foreach ($user as $us)
                                                                <option value="{{ $us->id_users }}" @if(
                                                                    old('id_users')==$us->id_users)
                                                                    selected @endif>
                                                                    {{ $us->nama_pegawai }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('id_users')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select
                                                                class="form-control @error('status') is-invalid @enderror"
                                                                id="status" name="status">
                                                                @if ($generalsetting->isNotEmpty())
                                                                <option value="1" @if ($generalsetting->first()->status
                                                                    == '1' ||
                                                                    old('status') == '1') selected @endif>
                                                                    Aktif
                                                                </option>
                                                                <option value="0" @if ($generalsetting->first()->status
                                                                    == '0' ||
                                                                    old('status') == '0') selected @endif>
                                                                    Tidak Aktif
                                                                </option>
                                                                @else
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Tidak Aktif</option>
                                                                @endif
                                                            </select>
                                                            @error('status') <span
                                                                class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Close Modal -->
                </div>
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
function submitEditForm() {
    // Mendapatkan nilai ID dan data lain dari form modal
    var id = document.getElementById('editModal').value;
    var name = document.getElementById('name').value;

    // Mengirimkan permintaan AJAX ke backend server untuk update data
    $.ajax({
        url: '/update_data/' + id, // Ganti dengan URL yang sesuai untuk update data
        method: 'PUT', // Ganti dengan metode HTTP yang sesuai
        data: {
            _token: '{{ csrf_token() }}', // Token CSRF untuk validasi
            name: name // Data lain yang ingin Anda update
        },
        success: function(response) {
            // Menangani respons sukses
            console.log(response);
            // Tutup modal setelah berhasil mengedit data
            $('#editModal').modal('hide');
            // Refresh halaman atau tampilan data jika perlu
            // ...
        },
        error: function(error) {
            // Menangani respons error
            console.log(error);
            // Tampilkan pesan error atau tindakan lain jika perlu
            // ...
        }
    });
}
</script>
@endpush