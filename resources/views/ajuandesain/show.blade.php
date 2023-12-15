@extends('adminlte::page')
@section('title', 'Detail Pengajuan Desain')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">

    <h1 class="m-0 text-dark">Detail Pengajuan Desain</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="tgl_pengajuan" class="form-label">Tgl Ajuan</label>
                        <div class="form-input">
                            : {{ \Carbon\Carbon::parse($ajuandesain->tgl_pengajuan)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_pemohon" class="form-label">Pemohon</label>
                        <div class="form-input">
                            : {{$ajuandesain->users->nama_pegawai ?? old('id_users')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_digunakan" class="form-label">Tgl Digunakan</label>
                        <div class="form-input">
                            : {{ \Carbon\Carbon::parse($ajuandesain->tgl_digunakan)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_desain" class="form-label">Jenis Desain</label>
                        <div class="form-input">
                            : {{$ajuandesain -> jenis_desain ?? old('jenis_desain')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            : {{$ajuandesain -> nama_kegiatan ?? old('nama_kegiatan')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tempat_kegiatan" class="form-label">Tempat Kegiatan</label>
                        <div class="form-input">
                            : {{$ajuandesain -> tempat_kegiatan ?? old('tempat_kegiatan')}} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_kegiatan" class="form-label">Tgl Kegiatan</label>
                        <div class="form-input">
                        : {{ \Carbon\Carbon::parse($ajuandesain->tgl_kegiatan)->format('d M Y') }} 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <div class="form-input">
                        @if($ajuandesain->no_sertifikat)
                            : {{$ajuandesain -> ukuran ?? old('ukuran')}} 
                        @else
                            : -
                        @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_sertifikat" class="form-label">No. Sertifikat</label>
                        <div class="form-input">
                        @if($ajuandesain->no_sertifikat)
                            : {{$ajuandesain -> no_sertifikat ?? old('no_sertifikat')}} 
                        @else
                            : -
                        @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lampiran_pendukung" class="form-label">Lampiran Pendukung</label>
                        <div class="form-input">
                            @if(isset($ajuandesain) && $ajuandesain->lampiran_pendukung)
                                : <a href="{{ asset('storage/lampiran_pendukung/' . $ajuandesain->lampiran_pendukung)}}" download>
                                    &nbsp;<i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>                         
                            </a>
                            @else
                                : -
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lampiran_qrcode" class="form-label">Lampiran QR-Code</label>
                        <div class="form-input">
                            @if(isset($ajuandesain) && $ajuandesain->lampiran_qrcode)
                                : <a href="{{ asset('storage/lampiran_qrcode/' . $ajuandesain->lampiran_qrcode)}}" download>
                                    &nbsp;<i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>                         
                            </a>
                            @else
                                : -
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pemohon" class="form-label">Keterangan Pemohon</label>
                            <div class="form-input " style="margin-right: 10px;">
                            @if($ajuandesain->keterangan_pemohon)
                                <span style="margin-right: 5px;">:</span>
                                <span style="white-space: pre-line;">{{$ajuandesain->keterangan_pemohon ?? old('keterangan_pemohon')}}</span>    
                            @else
                            : -
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-input">
                            : 
                            @php
                                $status = $ajuandesain->status ?? old('status');
                                echo ($status === 'dicek_kadiv') ? ucfirst(strtolower(str_replace('_', ' ', $status))) : ucfirst(strtolower($status));
                            @endphp
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lampiran_desain" class="form-label">Lampiran Desain</label>
                        <div class="form-input">
                            @if(isset($ajuandesain) && $ajuandesain->lampiran_desain)
                                : <a href="{{ asset('storage/lampiran_desain/' . $ajuandesain->lampiran_desain)}}" download>
                                    &nbsp;<i class="fas fa-download" style="display: inline-block; line-height: normal; vertical-align: middle;"></i>                         
                            </a>
                            @else
                                : -
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                            <div class="form-input " style="margin-right: 10px;">
                            @if($ajuandesain->keterangan)
                                <span style="margin-right: 5px;">:</span>
                                <span style="white-space: pre-line;">{{$ajuandesain->keterangan ?? old('keterangan')}}</span>    
                            @else
                            : -
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('ajuandesain.index')}}" class="btn btn-primary">Kembali</a>
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
