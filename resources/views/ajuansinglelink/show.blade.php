@extends('adminlte::page')
@section('title', 'Detail Pengajuan Single Link')
@section('content_header')
    <h1 class="m-0 text-dark">Detail Pengajuan Single Link</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="tgl_pengajuan" class="col-sm-3 col-form-label">Tgl Ajuan</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{ \Carbon\Carbon::parse($ajuansinglelink->tgl_pengajuan)->format('d M Y') ?? old('tgl_pengajuan')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_pemohon" class="col-sm-3 col-form-label">Pemohon</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{$ajuansinglelink->users->nama_pegawai ?? old('id_users')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{$ajuansinglelink -> nama_kegiatan ?? old('nama_kegiatan')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_shortlink" class="col-sm-3 col-form-label">Nama Shortlink</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{$ajuansinglelink -> nama_shortlink ?? old('nama_shortlink')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan_pemohon" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{$ajuansinglelink->keterangan_pemohon ?? old('keterangan_pemohon')}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            : {{ ucfirst(strtolower($ajuansinglelink->status)) ?? old('status') }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan_operator" class="col-sm-3 col-form-label">Keterangan Operator</label>
                        <div class="col-sm-9">
                            <span style="white-space: pre-line;"> : {{$ajuansinglelink->keterangan_operator ?? '-'}}</span>
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
