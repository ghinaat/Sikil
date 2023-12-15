@extends('adminlte::page')
@section('title', 'List Pengajuan Desain')
@section('content_header')
<h1 class="m-0 text-dark">Pengajuan Desain</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tgl Ajuan</th>
                                <th>Pemohon</th>
                                <th>Jenis Desain</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ajuandesain as $key => $ad)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ \Carbon\Carbon::parse($ad->tgl_pengajuan)->format('d M Y') }}</td>
                                <td>{{$ad->users->nama_pegawai}}</td>
                                <td>{{$ad->jenis_desain}}</td>
                                <td>{{$ad->nama_kegiatan}}</td>
                                <td>@if($ad->status == 'diajukan')
                                    Diajukan
                                    @elseif($ad->status == 'diproses')
                                    Diproses
                                    @elseif($ad->status == 'dicek_kadiv')
                                    Dicek Kadiv
                                    @elseif($ad->status == 'disetujui_kadiv')
                                    Disetujui Kadiv
                                    @elseif($ad->status == 'revisi')
                                    Revisi
                                    @elseif($ad->status == 'selesai')
                                    Selesai
                                    @else
                                    Diajukan
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('ajuandesain' . '.show', $ad->id_pengajuan_desain)}}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                         @if(auth()->user()->level === 'admin')
                                            <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                data-target="#editModal{{$ad->id_pengajuan_desain}}"
                                                data-id="{{$ad->id_pengajuan_desain}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('ajuandesain' . '.destroy', $ad->id_pengajuan_desain) }}"
                                                onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                                class="btn btn-danger btn-xs mx-1">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @elseif(auth()->user()->level === 'staf' && $ad->status === 'disetujui_kadiv')
                                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                    data-target="#editModal{{$ad->id_pengajuan_desain}}"
                                                    data-id="{{$ad->id_pengajuan_desain}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>                                            
                                            @elseif(auth()->user()->level === 'staf' && $ad->status === 'diajukan')
                                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                        data-target="#editModal{{$ad->id_pengajuan_desain}}"
                                                        data-id="{{$ad->id_pengajuan_desain}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>   
                                                <a href="{{ route('ajuandesain' . '.destroy', $ad->id_pengajuan_desain) }}"
                                                        onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                                        class="btn btn-danger btn-xs mx-1">
                                                        <i class="fa fa-trash"></i>
                                                    </a> 
                                            @elseif(auth()->user()->level === 'kadiv' && $ad->status === 'dicek_kadiv')
                                                <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                    data-target="#editModal{{$ad->id_pengajuan_desain}}"
                                                    data-id="{{$ad->id_pengajuan_desain}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>   
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{$ad->id_pengajuan_desain}}" tabindex="-1"
                                role="dialog" aria-labelledby="editModalLabel{{$ad->id_pengajuan_desain}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Ajuan Desain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('ajuandesain.update', $ad->id_pengajuan_desain) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group row">
                                                    <label for="tgl_pengajuan" class="col-sm-3 col-form-label">Tgl Ajuan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror"
                                                            id="tgl_pengajuan" name="tgl_pengajuan" value="{{ \Carbon\Carbon::parse($ad->tgl_pengajuan)->format('d M Y') ?? old('tgl_pengajuan') }}" readonly>
                                                        @error('tgl_pengajuan') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="id_users" class="col-sm-3 col-form-label">Pemohon</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" class="form-control @error('id_users') is-invalid @enderror"
                                                            id="id_users" name="id_users" value="{{$ad->users->nama_pegawai ?? old('id_users')}}" readonly>
                                                        @error('id_users') <span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tgl_digunakan" class="col-sm-3 col-form-label">Tgl Digunakan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('tgl_digunakan') is-invalid @enderror"
                                                            id="tgl_digunakan" name="tgl_digunakan" value="{{ \Carbon\Carbon::parse($ad->tgl_digunakan)->format('d M Y') ?? old('tgl_digunakan') }}" readonly>
                                                        @error('tgl_digunakan')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenis_desain" class="col-sm-3 col-form-label">Jenis Desain</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-input">
                                                            <select class="form-select" id="jenis_desain" name="jenis_desain" required>
                                                                <option value="Cover Petunjuk Teknis" @if($ad->jenis_desain == 'Cover Petunjuk Teknis' || old('Cover Petunjuk Teknis') == 'Cover Petunjuk Teknis') selected @endif>Cover Petunjuk Teknis</option>
                                                                <option value="Cover Laporan" @if($ad->jenis_desain == 'Cover Laporan' || old('Cover Laporan') == 'Cover Laporan') selected @endif>Cover Laporan</option>
                                                                <option value="Cover Dokumen Pedukung" @if($ad->jenis_desain == 'Cover Dokumen Pedukung' || old('Cover Dokumen Pedukung') == 'Cover Dokumen Pedukung') selected @endif>Cover Dokumen Pedukung</option>
                                                                <option value="Cover Materi" @if($ad->jenis_desain == 'Cover Materi' || old('Cover Materi') == 'Cover Materi') selected @endif>Cover Materi</option>
                                                                <option value="Nametag" @if($ad->jenis_desain == 'Nametag' || old('Nametag') == 'Nametag') selected @endif>Nametag</option>
                                                                <option value="Spanduk Indoor" @if($ad->jenis_desain == 'Spanduk Indoor' || old('Spanduk Indoor') == 'Spanduk Indoor') selected @endif>Spanduk Indoor</option>
                                                                <option value="Spanduk Outdoor" @if($ad->jenis_desain == 'Spanduk Outdoor' || old('Spanduk Outdoor') == 'Spanduk Outdoor') selected @endif>Spanduk Outdoor</option>
                                                                <option value="Sertifikat" @if($ad->jenis_desain == 'Sertifikat' || old('Sertifikat') == 'Sertifikat') selected @endif>Sertifikat</option>
                                                                <option value="Social Media Feeds" @if($ad->jenis_desain == 'Social Media Feeds' || old('Social Media Feeds') == 'Social Media Feeds') selected @endif>Social Media Feeds</option>
                                                                <option value="Web-banner"  @if($ad->jenis_desain == 'Web-banner' || old('Web-banner') == 'Web-banner') selected @endif>Web-banner</option>
                                                                <option value="Lainnya"  @if($ad->jenis_desain == 'Lainnya' || old('Lainnya') == 'Lainnya') selected @endif>Lainnya</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                                        id="nama_kegiatan" name="nama_kegiatan" value="{{$ad-> nama_kegiatan ?? old('nama_kegiatan')}}">
                                                        @error('nama_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tempat_kegiatan" class="col-sm-3 col-form-label">Tempat Kegiatan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('tempat_kegiatan') is-invalid @enderror" 
                                                        id="tempat_kegiatan" name="tempat_kegiatan" value="{{$ad-> tempat_kegiatan ?? old('tempat_kegiatan')}}">
                                                        @error('tempat_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tgl_kegiatan" class="col-sm-3 col-form-label">Tgl Kegiatan</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control @error('tgl_kegiatan') is-invalid @enderror"
                                                            id="tgl_kegiatan" name="tgl_kegiatan" value="{{$ad-> tgl_kegiatan ?? old('tgl_kegiatan')}}">
                                                        @error('tgl_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('ukuran') is-invalid @enderror" 
                                                        id="ukuran" name="ukuran" value="{{$ad->ukuran ?? old('ukuran')}}">
                                                        @error('ukuran')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="no_sertifikat" class="col-sm-3 col-form-label">No. Sertifikat</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control @error('no_sertifikat') is-invalid @enderror"
                                                            id="no_sertifikat" name="no_sertifikat" value="{{$ad->no_sertifikat ?? old('no_sertifikat') }}">
                                                        @error('no_sertifikat')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lampiran_pendukung" class="col-sm-3 col-form-label">Lampiran Pendukung</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control @error('lampiran_pendukung') is-invalid @enderror" id="lampiran_pendukung" name="lampiran_pendukung"
                                                            enctype="multipart/form-data" accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                                        @error('lampiran_pendukung') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>

                                                        Previous File: 
                                                        <a href="{{ asset('/storage/lampiran_pendukung_desain/'. $ad->lampiran_pendukung)}}"
                                                        target="_blank">{{ $ad->lampiran_pendukung}}</a>
                                                        @error('lampiran_pendukung')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lampiran_qrcode" class="col-sm-3 col-form-label">Lampiran QR-Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control @error('lampiran_qrcode') is-invalid @enderror"
                                                            id="lampiran_qrcode" name="lampiran_qrcode" enctype="multipart/form-data"
                                                            accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                                        @error('lampiran_qrcode') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>

                                                        Previous File: 
                                                        <a href="{{ asset('/storage/lampiran_qrcode_desain/'. $ad->lampiran_qrcode)}}"
                                                        target="_blank">{{ $ad->lampiran_qrcode}}</a>
                                                        @error('lampiran_pendukung')<span class="text-danger">{{$message}}</span>@enderror
                                                        @error('lampiran_qrcode')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan_pemohon" class="col-sm-3 col-form-label">Keterangan Pemohon</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                                            id="keterangan_pemohon" name="keterangan_pemohon" rows="4">{{$ad->keterangan_pemohon ?? old('keterangan_pemohon') }}</textarea>
                                                        @error('keterangan_pemohon')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-input">
                                                            <select class="form-select" id="status" name="status" required>
                                                                @if(auth()->user()->level == 'admin')
                                                                    <option value="diproses" @if($ad->status == 'diproses' || old('status') == 'diproses') selected @endif>Diproses</option>
                                                                    <option value="dicek_kadiv" @if($ad->status == 'dicek_kadiv' || old('status') == 'dicek_kadiv') selected @endif>Dicek Kadiv</option>
                                                                @elseif(auth()->user()->level == 'kadiv')
                                                                    <option value="disetujui_kadiv" @if($ad->status == 'disetujui_kadiv' || old('status') == 'disetujui_kadiv') selected @endif>Disetujui Kadiv</option>
                                                                    <option value="revisi" @if($ad->status == 'revisi' || old('status') == 'revisi') selected @endif>Revisi</option>
                                                                    <option value="selesai" @if($ad->status == 'selesai' || old('status') == 'selesai') selected @endif>Selesai</option>
                                                                @elseif(auth()->user()->level == 'staf')
                                                                    <option value="diajukan" @if($ad->status == 'diajukan' || old('status') == 'diajukan') selected @endif>Diajukan</option>
                                                                    <option value="revisi" @if($ad->status == 'revisi' || old('status') == 'revisi') selected @endif>Revisi</option>
                                                                    <option value="selesai" @if($ad->status == 'selesai' || old('status') == 'selesai') selected @endif>Selesai</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('isAdmin')
                                                <div class="form-group row">
                                                    <label for="lampiran_desain" class="col-sm-3 col-form-label">Lampiran Desain</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control @error('lampiran_desain') is-invalid @enderror"
                                                            id="lampiran_desain" name="lampiran_desain" enctype="multipart/form-data"
                                                            accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                                        @error('lampiran_desain') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>
                                                        @error('lampiran_desain')<span class="textdanger">{{$message}}</span>@enderror

                                                        Previous File: 
                                                        <a href="{{ asset('/storage/lampiran_desain/'. $ad->lampiran_desain)}}"
                                                        target="_blank">{{ $ad->lampiran_desain}}</a>
                                                        @error('lampiran_desain')<span class="text-danger">{{$message}}</span>@enderror
                                                        @error('lampiran_desain')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                                            id="keterangan" name="keterangan" rows="4">{{$ad->keterangan ?? old('keterangan')}}</textarea>
                                                        @error('keterangan')<span class="textdanger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                @endcan
                                                @can('isKadiv')
                                                <div class="form-group row">
                                                    <label for="lampiran_desain" class="col-sm-3 col-form-label">Lampiran Desain</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control @error('lampiran_desain') is-invalid @enderror"
                                                            id="lampiran_desain" name="lampiran_desain" enctype="multipart/form-data"
                                                            accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                                        @error('lampiran_desain') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>
                                                        @error('lampiran_desain')<span class="textdanger">{{$message}}</span>@enderror

                                                        Previous File: 
                                                        <a href="{{ asset('/storage/lampiran_desain/'. $ad->lampiran_desain)}}"
                                                        target="_blank">{{ $ad->lampiran_desain}}</a>
                                                        @error('lampiran_desain')<span class="text-danger">{{$message}}</span>@enderror
                                                        @error('lampiran_desain')<span class="text-danger">{{$message}}</span>@enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                                            id="keterangan" name="keterangan" rows="4">{{$ad->keterangan ?? old('keterangan')}}</textarea>
                                                        @error('keterangan')<span class="textdanger">{{$message}}</span>@enderror
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Ajuan Desain</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuandesain.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="jenis_desain" class="col-sm-3 col-form-label">Jenis Desain</label>
                                        <div class="col-sm-9">
                                            <div class="form-input">
                                                <select class="form-select" id="jenis_desain" name="jenis_desain" required>
                                                    <option value="Cover Petunjuk Teknis">Cover Petunjuk Teknis</option>
                                                    <option value="Cover Laporan">Cover Laporan</option>
                                                    <option value="Cover Dokumen Pedukung">Cover Dokumen Pedukung</option>
                                                    <option value="Cover Materi">Cover Materi</option>
                                                    <option value="Nametag">Nametag</option>
                                                    <option value="Spanduk Indoor">Spanduk Indoor</option>
                                                    <option value="Spanduk Outdoor">Spanduk Outdoor</option>
                                                    <option value="Sertifikat">Sertifikat</option>
                                                    <option value="Social Media Feeds">Social Media Feeds</option>
                                                    <option value="Web-banner">Web-banner</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                            id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan')}}">
                                            @error('nama_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tempat_kegiatan" class="col-sm-3 col-form-label">Tempat Kegiatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('tempat_kegiatan') is-invalid @enderror" 
                                            id="tempat_kegiatan" name="tempat_kegiatan" value="{{ old('tempat_kegiatan') }}">
                                            @error('tempat_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_kegiatan" class="col-sm-3 col-form-label">Tgl Kegiatan</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control @error('tgl_kegiatan') is-invalid @enderror"
                                                id="tgl_kegiatan" name="tgl_kegiatan" value="{{ old('tgl_kegiatan') }}">
                                            @error('tgl_kegiatan')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_digunakan" class="col-sm-3 col-form-label">Tgl Digunakan</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control @error('tgl_digunakan') is-invalid @enderror"
                                                id="tgl_digunakan" name="tgl_digunakan" value="{{ old('tgl_digunakan') }}">
                                            @error('tgl_digunakan')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('ukuran') is-invalid @enderror" 
                                            id="ukuran" name="ukuran" value="{{ old('ukuran') }}">
                                            @error('ukuran')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="no_sertifikat" class="col-sm-3 col-form-label">No. Sertifikat</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('no_sertifikat') is-invalid @enderror"
                                                id="no_sertifikat" name="no_sertifikat" value="{{ old('no_sertifikat') }}">
                                            @error('no_sertifikat')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lampiran_pendukung" class="col-sm-3 col-form-label">Lampiran Pendukung</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control @error('lampiran_pendukung') is-invalid @enderror" id="lampiran_pendukung" name="lampiran_pendukung"
                                                enctype="multipart/form-data" accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                            @error('lampiran_qrcode') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                            <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>
                                            @error('lampiran_pendukung')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lampiran_qrcode" class="col-sm-3 col-form-label">Lampiran QR-Code</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control @error('lampiran_qrcode') is-invalid @enderror"
                                                id="lampiran_qrcode" name="lampiran_qrcode" enctype="multipart/form-data"
                                                accept="image/jpeg, image/jpg, image/png, application/pdf, application/doc, application/docx, application/zip, application/xlsx">
                                            @error('lampiran_qrcode') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                            <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png .pdf .doc .docx .zip .xlsx</small>
                                            @error('lampiran_qrcode')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan_pemohon" class="col-sm-3 col-form-label">Keterangan Pemohon</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                                id="keterangan_pemohon" name="keterangan_pemohon" rows="4">{{ old('keterangan_pemohon') }}</textarea>
                                            @error('keterangan_pemohon')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
    $(document).ready(function () {
        var table = $('#example2').DataTable({
            "responsive": true,
        });

        // Inisialisasi nomor yang disimpan di data-attribute
        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
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
