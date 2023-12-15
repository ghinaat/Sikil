@extends('adminlte::page')
@section('title', 'List Pengajuan Form')
@section('content_header')
<h1 class="m-0 text-dark">Pengajuan Google Form</h1>

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
                                <th>Jenis Form</th>
                                <th>Status</th>
                                <th style="width:100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $showDetail = true; 
                            $sortedForm = $ajuanform->sortByDesc('id_pengajuan_form');
                            $nomor = 1; // Inisialisasi variabel untuk nomor urutan
                            @endphp
                            @foreach($sortedForm as $key => $form)
                                <tr>
                                    <td id={{$key+1}}>{{$nomor}}</td>
                                    <td id={{$key+1}}>{{ \Carbon\Carbon::parse($form->tgl_pengajuan)->format('d M Y') }}</td>
                                    <td id={{$key+1}}>{{$form->user->nama_pegawai}}</td>
                                    <td id={{$key+1}}>{{$form->nama_kegiatan}}</td>
                                    <td id={{$key+1}}>{{$form->jenis_form}}</td>
                                    <td id={{$key+1}}>
                                        @if($form->status == 'diajukan')
                                            Diajukan
                                        @elseif($form->status == 'diproses')
                                            Diproses
                                        @else   
                                            Ready
                                        @endif
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('ajuanform' . '.show', $form->id_pengajuan_form)}}" class="btn btn-info btn-xs mx-1">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </a>
    
                                            @if(auth()->user()->level === 'admin' || (auth()->user()->id_users == $form->id_users && $form->status !== 'ready'))
                                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal" data-target="#editModal{{$form->id_pengajuan_form}}" data-id="{{$form->id_pengajuan_form}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('ajuanform' . '.destroy',$form->id_pengajuan_form) }}" onclick="notificationBeforeDelete(event, this, {{$key+1}})" class="btn btn-danger btn-xs mx-1">
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
                <h5 class="modal-title" id="addModalLabel">Tambah Pengajuan Google Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajuanform.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_users"
                    value="{{ Auth::user()->id_users}}">
                    <div class="form-group">
                        <label for="jenis_form" class="form-label">Jenis Form</label>
                        <div class="form-input">
                            <select class="form-select" id="jenis_form" name="jenis_form" required>
                                <option value="Biodata">Biodata</option> 
                                <option value="Daftar Hadir">Daftar Hadir</option> 
                                <option value="Evaluasi">Evaluasi</option>                            
                                <option value="Konfirmasi Keikutsertaan">Konfirmasi Keikutsertaan</option>                            
                                <option value="Pendaftaran">Pendaftaran</option>                            
                                <option value="Pendaftaran">Pengumpulan Tugas</option>                            
                                <option value="Pendaftaran">Validasi</option>                            
                            </select>  
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            <textarea rows="3" type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan"  required></textarea>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_digunakan" class="form-label">Tanggal Digunakan</label>
                        <div class="form-input">
                            <input type="date" class="form-control @error('tgl_digunakan') is-invalid @enderror"
                                id="tgl_digunakan" name="tgl_digunakan" required>
                        @error('tgl_digunakan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bahasa" class="form-label">Bahasa</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="bahasa" id="bahasa" value="Indonesia" >&nbsp;Indonesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="bahasa" id="bahasa" value="Inggris"  >&nbsp;Inggris<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shortlink" class="form-label">Nama Shortlink</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('shortlink') is-invalid @enderror"
                                id="shortlink" name="shortlink" required>
                        @error('shortlink') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="template" class="form-label">Format (Template)</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('template') is-invalid @enderror"
                            id="template" name="template" accept=".jpg,.jpeg,.png,.doc,.docx,.xls,.zip">
                            <small class="form-text text-muted">Allow file extensions : .jpg .jpeg .png .doc .docx .xls .zip </small>

                        @error('lampiran') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contoh" class="form-label">Tautan Contoh (Jika ada)</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('contoh') is-invalid @enderror"
                                id="contoh" name="contoh">
                        @error('contoh') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kolaborator" class="form-label">Email Kolaborator</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('kolaborator') is-invalid @enderror"
                                id="kolaborator" name="kolaborator" >
                        @error('kolaborator') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="keterangan_pemohon" class="form-label">Keterangan Tambahan</label>
                        <div class="form-input">
                            <textarea rows="3" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror"></textarea>
                        @error('keterangan_pemohon') <span class="text-danger">{{ $message }}</span> @enderror
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

@foreach($ajuanform as $form)
<div class="modal fade" id="editModal{{$form->id_pengajuan_form}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Pengajuan Google Form</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanform.update',$form->id_pengajuan_form) }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tgl_pengajuan" class="form-label">Tanggal Ajuan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror"
                            id="tgl_pengajuan" value="{{ date_format( new DateTime($form->tgl_pengajuan), 'd F Y') ?? old('tgl_pengajuan')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_users" class="form-label">Pemohon</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                            id="id_users" name="id_users" value="{{old('id_users', $form->user->nama_pegawai)}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_digunakan" class="form-label">Tanggal Digunakan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('tgl_digunakan') is-invalid @enderror"
                            id="tgl_digunakan" name="tgl_digunakan" value="{{ date_format( new DateTime($form->tgl_digunakan), 'd F Y') ?? old('tgl_digunakan')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_form" class="form-label">Jenis Form</label>
                        <div class="form-input">
                            <select class="form-select" id="jenis_form" name="jenis_form" required>
                                <option value="Biodata" @if($form->jenis_form == 'Biodata' || old('Biodata') == 'Biodata') selected @endif>Biodata</option> 
                                <option value="Daftar Hadir" @if($form->jenis_form  == 'Daftar Hadir' || old('Daftar Hadir') == 'Daftar Hadir') selected @endif>Daftar Hadir</option> 
                                <option value="Evaluasi" @if($form->jenis_form == 'Evaluasi' || old('Evaluasi') == 'Evaluasi') selected @endif>Evaluasi</option>                            
                                <option value="Konfirmasi Keikutsertaan" @if($form->jenis_form == 'Konfirmasi Keikutsertaan' || old('Konfirmasi Keikutsertaan') == 'Konfirmasi Keikutsertaan') selected @endif>Konfirmasi Keikutsertaan</option>                            
                                <option value="Pendaftaran" @if($form->jenis_form == 'Pendaftaran' || old('Pendaftaran') == 'Pendaftaran') selected @endif>Pendaftaran</option>                            
                                <option value="Pengumpulan Tugas" @if($form->jenis_form == 'Pengumpulan Tugas' || old('Pengumpulan Tugas') == 'Pengumpulan Tugas') selected @endif>Pengumpulan Tugas</option>                            
                                <option value="Pendaftaran" @if($form->jenis_form == 'Biodata' || old('Biodata') == 'Biodata') selected @endif>Validasi</option>                            
                            </select>  
                        </div>
                    </div>
                    <div class="form-group " style="align-items: flex-start;">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <div class="form-input">
                            <textarea rows="3" type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan" value="" required>{{old('nama_kegiatan', $form->nama_kegiatan)}}</textarea>
                        @error('nama_kegiatan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bahasa" class="form-label">Bahasa</label>
                        <div class="form-check form-check-inline">
                            <label style="display: inline-flex; align-items: center; margin-right: 50px; font-weight: normal;">
                                <input type="radio" name="bahasa" id="bahasa" value="Indonesia" @if ($form->bahasa === 'Indonesia') checked @endif>
                                &nbsp;Indonesia
                            </label>
                            <label style="font-weight: normal;">
                                <input type="radio" name="bahasa" id="bahasa" value="Inggris" @if ($form->bahasa === 'Inggris') checked @endif>
                                &nbsp;Inggris
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shortlink" class="form-label">Nama Shortlink</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('shortlink') is-invalid @enderror"
                                id="shortlink" name="shortlink" value="{{old('shortlink', $form->shortlink)}}" required>
                        @error('shortlink') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="template" class="form-label">Format (Template)</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('template') is-invalid @enderror"
                            id="template" name="template" accept=".jpg,.jpeg,.png,.doc,.docx,.xls,.zip" >
                            <small class="form-text text-muted mt-0">Allow file extensions : .jpg .jpeg .png .doc .docx .xls .zip </small>
                            @if($form->template)
                            Previous File: 
                                <a href="{{ asset('/storage/template_form/'. $form->template) }}"
                                target="_blank">{{ $form->template }}</a>
                            @endif
                        @error('lampiran') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contoh" class="form-label">Tautan Contoh (Jika ada)</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('contoh') is-invalid @enderror"
                                id="contoh" name="contoh"  value="{{old('contoh', $form->contoh)}}">
                            
                            
                        @error('contoh') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kolaborator" class="form-label">Email Kolaborator</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('kolaborator') is-invalid @enderror"
                                id="kolaborator" name="kolaborator" value="{{old('kolaborator', $form->kolaborator)}}">
                        @error('kolaborator') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="keterangan_pemohon" class="form-label">Keterangan Tambahan</label>
                        <div class="form-input">
                            <textarea rows="3" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror">{{old('keterangan_pemohon', $form->keterangan_pemohon)}}"</textarea>
                        @error('keterangan_pemohon') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    @can('isAdmin')
                    <div class="form-group">
                        <label for="nama_operator" class="form-label">Nama Operator</label>
                        <div class="form-input">
                            <select id="nama_operator" name="nama_operator" class="form-select @error('nama_operator') is-invalid @enderror">
                                <option value="Hana" @if($form->nama_operator == 'Hana' || old('Hana') == 'Hana') selected @endif>Hana</option>
                                <option value="Bayu"@if($form->nama_operator == 'Bayu' || old('Bayu') == 'Bayu') selected @endif>Bayu</option>
                                <option value="Wendy" @if($form->nama_operator == 'Wendy' || old('Wendy') == 'Wendy') selected @endif>Wendy</option>
                                <option value="Siswa Magang" @if($form->nama_operator == 'Siswa Magang' || old('Siswa Magang') == 'Siswa Magang') selected @endif>Siswa Magang</option>
                                <option value="Lainnya" @if($form->nama_operator == 'Lainnya' || old('Lainnya') == 'Lainnya') selected @endif>Lainnya</option>
                            </select>
                        </div>
                        @error('kode_finger') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-input">
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="diajukan" @if($form->status == 'diajukan' || old('diajukan') == 'diajukan') selected @endif>Diajukan</option>
                                <option value="diproses"@if($form->status == 'diproses' || old('diproses') == 'diproses') selected @endif>Diproses</option>
                                <option value="ready" @if($form->status == 'ready' || old('ready') == 'ready') selected @endif>Ready</option>
                            </select>
                        </div>
                        @error('kode_finger') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group" style="align-items: flex-start;">
                        <label for="tautan_form" class="form-label">Tautan Form</label>
                        <div class="form-input">
                            <textarea rows="5" name="tautan_form" id="tautan_form" class="form-control 
                            @error('keterangan_operator') is-invalid @enderror">{{old('tautan_form', $form->tautan_form)}}</textarea>
                        @error('tautan_form') <span class="text-danger">{{ $message }}</span> @enderror
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