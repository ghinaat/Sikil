@extends('adminlte::page')
@section('title', 'Detail Pengajuan Google Form')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">

<h1 class="m-0 text-dark">Detail Pengajuan Google Form</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                    <div class="form-input">
                        : {{ date_format( new DateTime($form->tgl_pengajuan), 'd F Y') ?? old('tgl_pengajuan')}}
                    </div>    
                </div>
                <div class="form-group">
                    <label for="id_user" class="form-label">Pemohon</label>
                    <div class="form-input">
                        : {{old('id_users',$form->user->nama_pegawai)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_digunakan" class="form-label">Tanggal Digunakan</label>
                    <div class="form-input">
                        : {{ date_format( new DateTime($form->tgl_digunakan), 'd F Y') ?? old('tgl_digunakan')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="jenis_form" class="form-label">Jenis Form</label>
                    <div class="form-input">
                        : {{old('jenis_form',$form->jenis_form)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <div class="form-input" >
                        <span style="margin-right: 5px;">:</span>
                        <span style="white-space: pre-line;">{{$form->nama_kegiatan ?? old('nama_kegiatan')}}</span>         
                    </div>
                </div>
                <div class="form-group">
                    <label for="bahasa" class="form-label">Bahasa</label>
                    <div class="form-input">
                        : {{old('bahasa',$form->bahasa)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="shortlink" class="form-label">Nama Shortlink</label>
                    <div class="form-input">
                        : {{old('shortlink',$form->shortlink)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="template" class="form-label">Format (Template)</label>
                    <div class="form-input">
                        @if ($form->template)
                            :&nbsp;<a href="{{ asset('/storage/template_form/'.$form->template) }}" download>
                                        <i class="fas fa-download" >
                                            <span style="font-size: 12px; font-family: Arial, sans-serif;">Download</span>
                                        </i>
                                    </a>
                        @else
                            :&nbsp; -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="contoh" class="form-label">Tautan Contoh</label>
                    <div class="form-input">
                        @if ($form->contoh)
                        : {{old('contoh',$form->contoh)}}
                        @else
                        : 
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="kolaborator" class="form-label">Email Kolaborator</label>
                    <div class="form-input">
                        @if ($form->kolaborator)
                        : {{old('kolaborator',$form->kolaborator)}}
                        @else
                        : 
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="merek" class="form-label">Keterangan pemohon</label>
                    <div class="form-input" >
                        <span style="margin-right: 5px;">:</span>
                        <span style="white-space: pre-line;">{{$form->keterangan_pemohon ?? old('keterangan_pemohon')}}</span>         
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_operator" class="form-label">Nama Operator</label>
                    <div class="form-input">
                        @if ($form->nama_operator)
                        : {{old('nama_operator',$form->nama_operator)}}
                        @else
                        : 
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-input">
                        @if ($form->status == 'diajukan')
                        :&nbsp;Diajukan
                        @elseif($form->status == 'diproses')
                        :&nbsp;Diproses
                        @else
                        :&nbsp;Ready
                        @endif
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="tautan_form" class="form-label" >Tautan Form</label>
                    <div class="form-input">
                        @if($form->tautan_form)
                        <span style="margin-right: 5px;">:</span>
                        <span style="white-space: pre-line;">{{$form->tautan_form ?? old('tautan_form')}}</span> 
                        @else
                        :
                        @endif                   
                    </div>
                </div>
            <div class="modal-footer">
                <a href="{{route('ajuanform.index')}}" class="btn btn-primary ">
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
