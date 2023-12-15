@extends('adminlte::page')
@section('title', 'Detail Ajuan Perbaikan Alat TIK')
@section('content_header')
<style>


</style>
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<h1 class="m-0 text-dark">Detail Ajuan Perbaikan Alat TIK</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="tgl_ajuan" class="form-label">Tanggal Ajuan</label>
                    <div class="form-input">
                        : {{ \Carbon\Carbon::parse($ajuanperbaikan->tgl_pengajuan)->format('d M Y') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_users" class="form-label">Pemohon</label>
                    <div class="form-input">
                        : {{old('id_users', $ajuanperbaikan->users->nama_pegawai)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_ajuan" class="form-label">Nama Peralatan TIK</label>
                    <div class="form-input">
                        : {{old('id_barang_tik', $ajuanperbaikan->barang->nama_barang)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="merek" class="form-label">Keterangan</label>
                    <div class="form-input">
                        : {{old('keterangan_pemohon', $ajuanperbaikan->keterangan_pemohon)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian" class="form-label">Tanggal Pengecekan</label>
                    <div class="form-input">
                        @if($ajuanperbaikan->tgl_pengecekan)
                        : {{ \Carbon\Carbon::parse($ajuanperbaikan->tgl_pengecekan)->format('d M Y') }}
                        @else
                        : -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan_pemohon" class="form-label">Keterangan Operator</label>
                    <div class="form-input">
                        @if($ajuanperbaikan->keterangan_operator)
                        : {{old('keterangan_operator', $ajuanperbaikan->keterangan_operator)}}
                        @else
                        : -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-input">
                        @if($ajuanperbaikan->status == 'diajukan')
                        : Diajukan
                        @elseif($ajuanperbaikan->status == 'diproses')
                        : Diproses
                        @else
                        : Selesai
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="jumlah_peserta" class="form-label">Tanggal Selesai</label>
                    <div class="form-input">
                        @if($ajuanperbaikan->tgl_selesai)
                        : {{old('tgl_selesai', $ajuanperbaikan->tgl_selesai)}}
                        @else
                        : -
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('ajuanperbaikan.index')}}" class="btn btn-primary ">
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



@endpush