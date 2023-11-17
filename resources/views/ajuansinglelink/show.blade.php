@extends('adminlte::page')
@section('title', 'Detail Pengajuan Single Link')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">

    <h1 class="m-0 text-dark">Detail Pengajuan Single Link</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="tgl_pengajuan" class="form-label">Tgl Ajuan</label>
                        <div class="form-input">
                            : {{ \Carbon\Carbon::parse($ajuansinglelink->tgl_pengajuan)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_pemohon" class="form-label">Pemohon</label>
                        <div class="form-input">
                            : {{$ajuansinglelink->users->nama_pegawai ?? old('id_users')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            : {{$ajuansinglelink -> nama_kegiatan ?? old('nama_kegiatan')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_shortlink" class="form-label">Nama Shortlink</label>
                        <div class="form-input">
                            : {{$ajuansinglelink -> nama_shortlink ?? old('nama_shortlink')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pemohon" class="form-label">Keterangan</label>
                        <div class="form-input">
                            : {{$ajuansinglelink -> keterangan_pemohon ?? old('keterangan_pemohon')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Status" class="form-label">Status</label>
                        <div class="form-input">
                            : {{ucfirst(strtolower($ajuansinglelink->status)) ?? old('status')}}
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="keterangan_operator" class="form-label">Keterangan Operator</label>
                            <div class="form-input " style="margin-right: 10px;">
                            @if($ajuansinglelink->keterangan_operator)
                                <span style="margin-right: 5px;">:</span>
                                <span style="white-space: pre-line;">{{$ajuansinglelink->keterangan_operator ?? old('keterangan_operator')}}</span>    
                            @else
                            : -
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('ajuansinglelink.index')}}" class="btn btn-primary">Kembali</a>
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
