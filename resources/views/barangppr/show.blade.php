@extends('adminlte::page')
@section('title', 'Detail Inventaris PPR')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail Inventaris PPR</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_barang" class='form-label'>Nama Barang</label>
                    <div class="form-input">
                        : {{$barangppr -> nama_barang ?? old('nama_barang')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembuatan" class='form-label'>Tahun Pembuatan</label>
                    <div class="form-input">
                        : {{$barangppr -> tahun_pembuatan ?? old('tahun_pembuatan')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <div class="form-input">
                        : {{$barangppr -> jumlah ?? old('jumlah')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_ruangan" class="form-label">Lokasi Barang</label>
                    <div class="form-input">
                        : {{$barangppr->ruangan->nama_ruangan ?? old('id_ruangan')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <div class="form-input">
                        : {{$barangppr -> keterangan ?? old('keterangan')}}                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Gambar</label>
                    <div class="form-input">
                        @if(isset($barangppr) && $barangppr->image)
                            : <img src="{{ asset('storage/image_barangppr/' . $barangppr->image) }}" style="max-width: 100%; max-height: 200px;">
                        @else
                            : -
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('barangppr.index')}}" class="btn btn-primary ">Kembali</a>
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
    function pilih(id, nama_pegawai) {
        // Mengisi nilai input dengan data yang dipilih dari tabel
        document.getElementById('selected_id_users').value = id;
        document.getElementById('pegawai').value = nama_pegawai;
    }
</script>
@endpush
