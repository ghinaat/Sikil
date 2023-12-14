@extends('adminlte::page')
@section('title', 'List Pengajuan Blast Email')
@section('content_header')
<h1 class="m-0 text-dark">Pengajuan Blast Email</h1>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- @can('isAdmin') --}}
                <div class="mb-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
                </div>
                {{-- @endcan --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Ajuan</th>
                                <th>Pemohon</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th style="width:180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $showDetail = true; 
                            $sortedBlastEmail = $BlastEmail->sortByDesc('id_pengajuan_blastemail');
                            $nomor = 1; // Inisialisasi variabel untuk nomor urutan
                            @endphp
                            @foreach($sortedBlastEmail as $key => $email)
                                <tr>
                                    <td id={{$key+1}}>{{$nomor}}</td>
                                    <td id={{$key+1}}>{{ \Carbon\Carbon::parse($email->tgl_pengajuan)->format('d M Y') }}</td>
                                    <td id={{$key+1}}>{{$email->user->nama_pegawai}}</td>
                                    <td id={{$key+1}}>{{$email->nama_kegiatan}}</td>
                                    <td id={{$key+1}}>
                                        @if($email->status == 'diajukan')
                                            Diajukan
                                        @else
                                            Selesai
                                        @endif
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('ajuanblastemail' . '.show', $email->id_pengajuan_blastemail)}}" class="btn btn-info btn-xs mx-1">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </a>
    
                                            @if(auth()->user()->level === 'admin' || (auth()->user()->id_users == $email->id_users && $email->status !== 'selesai'))
                                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal" data-target="#editModal{{$email->id_pengajuan_blastemail}}" data-id="{{$email->id_pengajuan_blastemail}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('ajuanblastemail' . '.destroy',$email->id_pengajuan_blastemail) }}" onclick="notificationBeforeDelete(event, this, {{$key+1}})" class="btn btn-danger btn-xs mx-1">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                        </div>
    
                                    </td>
                                </tr>
                                @php
                                $nomor++; // Tingkatkan nomor urutan setiap kali iterasi berlangsung
                                @endphp
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="addMeditlLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pengajuan Blast Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajuanblastemail.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_users"
                    value="{{ Auth::user()->id_users}}">
                    <div class="form-group">
                        <label for="jenis_blast" class="form-label">Jenis Email</label>
                        <div class="form-input">
                            <select class="form-select" id="jenis_blast" name="jenis_blast" required>
                                <option value="Sertifikat Kegiatan">Sertifikat Kegiatan</option> 
                                <option value="Surat Undangan">Surat Undangan</option> 
                                <option value="Informasi Lainnya">Informasi Lainnya</option>                            
                            </select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan" required>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="keterangan_pemohon" class="form-label">Keterangan</label>
                        <div class="form-input">
                            <textarea rows="5" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror"required></textarea>
                        @error('keterangan_pemohon') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> 
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="lampiran" class="form-label">Lampiran Dokumen</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('lampiran') is-invalid @enderror"
                            id="lampiran" name="lampiran" accept=".doc,.docx,.xlsx,.zip" required>
                            <small class="form-text text-muted">Allow file extensions : .doc .docx .xlsx .zip </small>

                        @error('lampiran') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">  
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($BlastEmail as $email)
<div class="modal fade" id="editModal{{$email->id_pengajuan_blastemail}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Pengajuan Blast Email</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanblastemail.update',$email->id_pengajuan_blastemail) }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror"
                                value="{{ date_format( new DateTime($email->tgl_pengajuan), 'd F Y') ?? old('tgl_pengajuan')}}" readonly>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_users" class="form-label">Pemohon</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('id_users') is-invalid @enderror"
                                value="{{old('id_users', $email->user->nama_pegawai)}}" readonly>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_blast" class="form-label">Jenis Email</label>
                        <div class="form-input">
                            <select class="form-select" id="jenis_blast" name="jenis_blast" required>
                                <option value="Sertifikat Kegiatan" @if($email->jenis_blast == 'Sertifikat Kegiatan' || old('Sertifikat Kegiatan') == 'Sertifikat Kegiatan') selected @endif>Sertifikat Kegiatan</option> 
                                <option value="Surat Undangan" @if($email->jenis_blast == 'Surat Undangan' || old('Surat Undangan') == 'Surat Undangan') selected @endif>Surat Undangan</option> 
                                <option value="Informasi Lainnya" @if($email->jenis_blast == 'Informasi Lainnya' || old('Informasi Lainny') == 'Informasi Lainny') selected @endif>Informasi Lainnya</option>                            
                            </select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan" value="{{old('nama_kegiatan', $email->nama_kegiatan)}}" required>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="keterangan_pemohon" class="form-label">Keterangan</label>
                        <div class="form-input">
                            <textarea rows="5" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror" required>{{old('keterangan_pemohon', $email->keterangan_pemohon)}}</textarea>
                        @error('keterangan_pemohon') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div> 
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="lampiran" class="form-label">Lampiran Dokumen</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('lampiran') is-invalid @enderror"
                            id="lampiran" name="lampiran" accept=".doc,.docx,.xlsx,.zip">
                            <small class="form-text text-muted">Allow file extensions : .doc .docx .xlsx .zip</small>
                            Previous File: 
                                <a href="{{ asset('/storage/lampiran_blast_email/'. $email->lampiran) }}"
                                target="_blank">{{ $email->lampiran }}</a>
                            
                        @error('lampiran') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @can('isAdmin')
                    <div class="form-group">
                        <label for="nama_operator" class="form-label">Nama Operator</label>
                        <div class="form-input">
                            <select id="nama_operator" name="nama_operator" class="form-select @error('nama_operator') is-invalid @enderror">
                                <option value="Hana" @if($email->nama_operator == 'Hana' || old('Hana') == 'Hana') selected @endif>Hana</option>
                                <option value="Bayu"@if($email->nama_operator == 'Bayu' || old('Bayu') == 'Bayu') selected @endif>Bayu</option>
                                <option value="Wendy" @if($email->nama_operator == 'Wendy' || old('Wendy') == 'Wendy') selected @endif>Wendy</option>
                                <option value="Siswa Magang" @if($email->nama_operator == 'Siswa Magang' || old('Siswa Magang') == 'Siswa Magang') selected @endif>Siswa Magang</option>
                                <option value="Lainnya" @if($email->nama_operator == 'Lainnya' || old('Lainnya') == 'Lainnya') selected @endif>Lainnya</option>
                            </select>
                        </div>
                        @error('kode_finger') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="Status" class="form-label">Status</label>
                        <div class="form-input form-inline">
                            <label style="display: inline-flex; align-items: center; margin-right: 50px; font-weight: normal;">
                                <input type="radio" name="status" id="status" value="diajukan" @if ($email->status === 'diajukan') checked @endif>
                                &nbsp;diajukan
                            </label>
                            <label style="font-weight: normal;">
                                <input type="radio" name="status" id="status" value="selesai"  @if ($email->status === 'selesai') checked @endif>
                                &nbsp;Selesai
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_kirim" class="form-label">Tanggal Kirim</label>
                        <div class="form-input">
                            <input type="date" name="tgl_kirim" id="tgl_kirim" class="form-control @error('keterangan_operator') is-invalid @enderror"
                            value="{{old('tgl_kirim', $email->tgl_kirim)}}" required>
                            @error('tgl_kirim') <span class="text-danger">{{ $message }}</span> @enderror                            
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="keterangan_operator" class="form-label">Keterangan Operator</label>
                        <div class="form-input">
                            <textarea rows="5" name="keterangan_operator" id="keterangan_operator" class="form-control 
                            @error('keterangan_operator') is-invalid @enderror" required>{{old('keterangan_operator', $email->keterangan_operator)}}</textarea>
                        @error('keterangan_operator') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endcan
                    <div class="modal-footer">  
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach



@stop

@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
$(document).ready(function() {
    var table = $('#example2').DataTable({
        "responsive": true,
    });

});

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapus data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>

@if(count($errors))
<script>
Swal.fire({
    title: 'Input tidak sesuai!',
    text: 'Pastikan inputan sudah sesuai',
    icon: 'error',
});
</script>
@endif
@endpush