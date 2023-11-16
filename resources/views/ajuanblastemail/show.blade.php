@extends('adminlte::page')
@section('title', 'Detail Pengajuan Blast Email')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/barangtik.css') }}">
<h1 class="m-0 text-dark">Detail Pengajuan Blast Email</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_barang" class="form-label">Tanggal Pengajuan</label>
                    <div class="form-input">
                        : &nbsp;{{ date_format( new DateTime($BlastEmail->tgl_pengajuan), 'd F Y') ?? old('tgl_pengajuan')}}
                    </div>    
                </div>
                <div class="form-group">
                    <label for="kode_barang" class="form-label">Pemohon</label>
                    <div class="form-input">
                        : &nbsp;{{old('id_users', $BlastEmail->user->nama_pegawai)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_barang" class="form-label">Nama Kegiatan</label>
                    <div class="form-input">
                        : &nbsp;{{old('nama_kegiatan', $BlastEmail->nama_kegiatan)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="merek" class="form-label"  style="flex: 1; min-width: 150px;">Keterangan</label>
                    <div class="form-input"  style="display: flex;">
                        <span style="margin-right: 5px;">:</span>
                        <span style="white-space: pre-line;">{{$BlastEmail->keterangan_pemohon ?? old('keterangan_pemohon')}}</span>         
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="kelengkapan" class="form-label">Lampiran Dokumen</label>
                    <div class="form-input">
                        : &nbsp;<a href="{{ asset('/storage/lampiran_blast_email/'. $BlastEmail->lampiran) }}" download>
                                    <i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>
                                </a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian" class="form-label">Status</label>
                    <div class="form-input">
                        @if($BlastEmail->status)
                            @if($BlastEmail->status == 'diajukan')
                            : &nbsp;Diajukan
                            @else
                            : &nbsp;Diajukan
                            @endif
                        @else
                        :&nbsp;-
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian" class="form-label" >Nama Operator</label>
                    <div class="form-input">
                        @if($BlastEmail->nama_operator)
                        : &nbsp;{{old('nama_operator', $BlastEmail->nama_operator)}}
                        @else
                        :&nbsp;-
                        @endif
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="kondisi" class="form-label">Tanggal Pengiriman</label>
                    <div class="form-input">
                        @if($BlastEmail->tgl_kirim)
                        : &nbsp;{{ date_format( new DateTime($BlastEmail->tgl_kirim), 'd F Y') ?? old('tgl_kirim')}}
                        @else
                        :&nbsp;-
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_pinjam" class="form-label" style="flex: 1; min-width: 150px;">Keterangan Operator</label>
                    <div class="form-input" style="display: flex;">
                        @if($BlastEmail->keterangan_operator)
                        <span style="margin-right: 6px;">:</span>
                        <span style="white-space: pre-line;">{{$BlastEmail->keterangan_operator ?? old('keterangan_operator')}}</span> 
                        @else
                        :&nbsp;- 
                        @endif                   
                    </div>
                </div>
            <div class="modal-footer">
                <a href="{{route('ajuanblastemail.index')}}" class="btn btn-primary ">
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
