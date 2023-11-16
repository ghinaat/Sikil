@extends('adminlte::page')
@section('title', 'Detail Pengajuan Zoom')
@section('content_header')
<style>
   
 
</style>
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<h1 class="m-0 text-dark">Detail Pengajuan zoom</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="tgl_ajuan" class="form-label">Tanggal Ajuan</label>
                    <div class="form-input">
                        : {{ \Carbon\Carbon::parse($zoom->tgl_pengajuan)->format('d M Y') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_users" class="form-label">Pemohon</label>
                    <div class="form-input">
                        : {{old('id_users', $zoom->users->nama_pegawai)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_ajuan" class="form-label">Jenis Zoom</label>
                    <div class="form-input">
                        : {{old('jenis_zoom', $zoom->jenis_zoom)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="merek" class="form-label">Nama Kegiatan</label>
                    <div class="form-input">
                        : {{old('nama_kegiatan', $zoom->nama_kegiatan)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                    <div class="form-input">
                        : {{old('jumlah_peserta', $zoom->jumlah_peserta)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian" class="form-label">Tanggal Pelaksanaan</label>
                    <div class="form-input">
                        : {{ \Carbon\Carbon::parse($zoom->tgl_pelaksanaan)->format('d M Y') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_pelaksanaan" class='form-label'>Waktu Pelaksanaan (WIB)</label>
                    <div class="form-input">
                        : {{old('jam_mulai', $zoom->jam_mulai)}} &nbsp; s/d &nbsp; {{old('jam_selesai', $zoom->jam_selesai)}} 

                    </div>
              
                </div>
                <div class="form-group">
                    <label for="keterangan_pemohon" class="form-label">Keterangan Tambahan</label>
                    <div class="form-input">
                        : {{old('keterangan_pemohon', $zoom->keterangan_pemohon)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_operator" class="form-label">Nama Operator</label>
                    <div class="form-input">
                        @if($zoom->nama_operator)
                        : {{old('nama_operator', $zoom->nama_operator)}}
                        @else
                        : -
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="akun_zoom" class="form-label">Akun Zoom</label>
                    <div class="form-input">
                        @if($zoom->akun_zoom)
                        : {{old('akun_zoom', $zoom->akun_zoom)}}
                        @else
                        : -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-input">
                    : {{old('status', $zoom->status)}}
                    </div>
                </div>
                <div class="form-group ">
                    <label for="tautan_zoom" class="form-label">Tautan Zoom</label>
                    <div class="form-input " style="margin-right: 10px;">
                        @if($zoom->tautan_zoom)
                        <span style="margin-right: 5px;">:</span>
                        <span style="white-space: pre-line;">{{$zoom->tautan_zoom ?? old('tautan_zoom')}}</span>    
                        @else
                        : -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan_operator" class="form-label">Keterangan Operator</label>
                    <div class="form-input">
                        @if($zoom->keterangan_operator)
                        : {{old('keterangan_operator', $zoom->keterangan_operator)}}
                        @else
                        : -
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('ajuanzoom.index')}}" class="btn btn-primary ">
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