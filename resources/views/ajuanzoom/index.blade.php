@extends('adminlte::page')
@section('title', 'List Pengajuan Zoom Meeting')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Pengajuan Zoom Meeting</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form"
                    role="dialog">
                    Tambah
                </button>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Ajuan</th>
                                <th>Pemohon</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sortedZoom = $zoom->sortByDesc('id_pengajuan_zoom');
                            $nomor = 1; // Initialize a variable to keep track of the sequence
                            @endphp
                            @foreach($sortedZoom as $key => $pz)
                            <tr>
                                <td></td>
                                <td id="">{{ \Carbon\Carbon::parse($pz->tgl_pengajuan)->format('d M Y') }}
                                </td>
                                <td>{{$pz->users->nama_pegawai}}</td>
                                <td>{{$pz->nama_kegiatan}}</td>
                                <td>
                                    @if($pz->status == 'diajukan')
                                    Diajukan
                                    @else
                                    Ready
                                    @endif
                                </td>
                                <td>
                                    <div class='btn-group'>
                                        @if($pz->status == "diajukan" )
                                        <a href="{{ route('ajuanzoom' . '.show', $pz->id_pengajuan_zoom) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        @if(auth()->user()->id_users == $pz->id_users || auth()->user()->level ==
                                        'admin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$pz->id_pengajuan_zoom}}"
                                            data-id="{{$pz->id_pengajuan_zoom}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="{{route('ajuanzoom.destroy', $pz->id_pengajuan_zoom)}}"
                                            onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                            class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif
                                        @elseif($pz->status == "ready" )
                                        <a href="{{ route('ajuanzoom' . '.show', $pz->id_pengajuan_zoom) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        @can('isAdmin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$pz->id_pengajuan_zoom}}"
                                            data-id="{{$pz->id_pengajuan_zoom}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="{{route('ajuanzoom.destroy', $pz->id_pengajuan_zoom)}}"
                                            onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                            class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @php
                            $nomor++; // Increment the sequence for the next row
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Pengajuan Zoom </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanzoom.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-body">
                        <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                        <div class="form-group">
                            <label for="jenis_zoom" class="form-label">Jenis Meeting</label>
                            <div class="form-input">
                                <div class="form-inline">
                                    <input type="radio" name="jenis_zoom" value="meeting"
                                        checked>&nbsp;Meeting&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="radio" name="jenis_zoom" value="webinar">&nbsp;Webinar<br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_kegiatan" class='form-label'>Nama Kegiatan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                    id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan')}}">
                                @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_peserta" class='form-label'>Jumlah Peserta</label>
                            <div class="form-input">
                                <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                    id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta')}}">
                                @error('jumlah_peserta') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pelaksanaan" class='form-label'>Tanggal Pelaksanaan</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_pelaksanaan') is-invalid @enderror"
                                    id="tgl_pelaksanaan" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan')}}">
                                @error('tgl_pelaksanaan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pelaksanaan" class='form-label'>Waktu Pelaksanaan (WIB)</label>
                            <div class="form-input">
                                <div class="form-inline">
                                    <input type="time"
                                        class="form-control @error('jam_mulai') is-invalid @enderror custom-time-input mr-2"
                                        id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai')}}">
                                    @error('jam_mulai') <span class="text-danger">{{$message}}</span> @enderror
                                    <small><b>s/d</b></small>
                                    <input type="time"
                                        class="form-control @error('jam_selesai') is-invalid @enderror custom-time-input ml-2"
                                        id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai')}}">
                                    @error('jam_selesai') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_pemohon" class='form-label'>Keterangan Tambahan</label>
                            <div class="form-input">
                                <input type="text"
                                    class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                    id="keterangan_pemohon" name="keterangan_pemohon"
                                    value="{{ old('keterangan_pemohon')}}">
                                @error('keterangan_pemohon') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ajukan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($zoom as $pz)
<div class="modal fade" id="editModal{{$pz->id_pengajuan_zoom}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Pengajuan Zoom</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanzoom.update',$pz->id_pengajuan_zoom) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tgl_pengajuan" class='form-label'>Tanggal Pengajuan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror"
                                id="tgl_pengajuan" name="tgl_pengajuan"
                                value="{{ \Carbon\Carbon::parse($pz->tgl_pengajuan)->format('d M Y') ?? old('tgl_pengajuan')}}"
                                readonly>
                            @error('tgl_pengajuan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_users" class='form-label'>Pemohon</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('id_users') is-invalid @enderror"
                                id="id_users" name="id_users" value="{{  $pz->users->nama_pegawai ?? old('id_users')}}"
                                readonly>
                            @error('id_users') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis_zoom" class="form-label">Jenis Meeting</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="jenis_zoom" value="meeting" @if ($pz->jenis_zoom ==
                                'meeting') checked @endif>&nbsp;Meeting&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="jenis_zoom" value="webinar" @if ($pz->jenis_zoom ==
                                'webinar') checked @endif>&nbsp;Webinar<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan" class='form-label'>Nama Kegiatan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan"
                                value="{{$pz->nama_kegiatan ?? old('nama_kegiatan')}}">
                            @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_peserta" class='form-label'>Jumlah Peserta</label>
                        <div class="form-input">
                            <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                id="jumlah_peserta" name="jumlah_peserta"
                                value="{{ $pz->jumlah_peserta ?? old('jumlah_peserta')}}">
                            @error('jumlah_peserta') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pelaksanaan" class='form-label'>Tanggal Pelaksanaan</label>
                        <div class="form-input">
                            <input type="date" class="form-control @error('tgl_pelaksanaan') is-invalid @enderror"
                                id="tgl_pelaksanaan" name="tgl_pelaksanaan"
                                value="{{ $pz->tgl_pelaksanaan ?? old('tgl_pelaksanaan')}}">
                            @error('tgl_pelaksanaan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pelaksanaan" class='form-label'>Waktu Pelaksanaan (WIB)</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="time"
                                    class="form-control @error('jam_mulai') is-invalid @enderror custom-time-input mr-2"
                                    id="jam_mulai" name="jam_mulai" value="{{ $pz->jam_mulai ?? old('jam_mulai')}}">
                                @error('jam_mulai') <span class="textdanger">{{$message}}</span> @enderror
                                <small><b>s/d</b></small>
                                <input type="time"
                                    class="form-control @error('jam_selesai') is-invalid @enderror custom-time-input ml-2"
                                    id="jam_selesai" name="jam_selesai"
                                    value="{{$pz->jam_selesai ?? old('jam_selesai')}}">
                                @error('jam_selesai') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pemohon" class='form-label'>Keterangan Tambahan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('keterangan_pemohon') is-invalid @enderror"
                                id="keterangan_pemohon" name="keterangan_pemohon"
                                value="{{$pz->keterangan_pemohon ?? old('keterangan_pemohon')}}">
                            @error('keterangan_pemohon') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    @can('isAdmin')
                    <div class="form-group">
                        <label for="nama_operator" class="form-label">Nama Operator</label>
                        <div class="form-input">
                            <select class="form-select" id="nama_operator" name="nama_operator" required>
                                <option value="Hana" @if($pz->nama_operator == 'Hana' || old('nama_operator') == 'Hana')
                                    selected @endif>Hana</option>
                                <option value="Bayu" @if($pz->nama_operator == 'Bayu' ||
                                    old('nama_operator') == 'Bayu') selected @endif>Bayu</option>
                                <option value="Wendy" @if($pz->nama_operator == 'Wendy' ||
                                    old('nama_operator') == 'Wendy') selected @endif>Wendy</option>
                                <option value="Siswa Magang" @if($pz->nama_operator == 'Siswa Magang' ||
                                    old('nama_operator') == 'Siswa Magang') selected @endif>Siswa Magang</option>
                                <option value="Lainnya" @if($pz->nama_operator == 'Lainnya' ||
                                    old('nama_operator') == 'Lainnya') selected @endif>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="akun_zoom" class="form-label">Akun Zoom</label>
                        <div class="form-input">
                            <select class="form-select" id="akun_zoom" name="akun_zoom" required>
                                <option value="ict.seaqil@gmail.com" @if($pz->akun_zoom == 'ict.seaqil@gmail.com' ||
                                    old('akun_zoom') == 'ict.seaqil@gmail.com')
                                    selected @endif>ict.seaqil@gmail.com</option>
                                <option value="training.qiteplanguage.org" @if($pz->akun_zoom ==
                                    'training.qiteplanguage.org' ||
                                    old('akun_zoom') == 'training.qiteplanguage.org') selected
                                    @endif>training.qiteplanguage.org</option>
                                <option value="seameoqil@gmail.com" @if($pz->akun_zoom == 'seameoqil@gmail.com' ||
                                    old('akun_zoom') == 'seameoqil@gmail.com') selected @endif>seameoqil@gmail.com
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tautan_zoom" class='form-label'>Tautan Zoom</label>
                        <div class="form-input">
                            <textarea row="3" name="tautan_zoom" id="tautan_zoom" class="form-control 
                            @error('tautan_zoom') is-invalid @enderror"
                                required>{{old('tautan_zoom', $pz->tautan_zoom)}}</textarea>
                            @error('tautan_zoom') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-input mb-30">
                            <div class="form-inline">
                                <input type="radio" name="status" value="diajukan" @if ($pz->status ==
                                'diajukan') checked @endif>&nbsp;Diajukan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="status" value="ready" @if ($pz->status ==
                                'ready') checked @endif>&nbsp;Ready<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_operator" class='form-label'>Keterangan Operator</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('keterangan_operator') is-invalid @enderror"
                                id="keterangan_operator" name="keterangan_operator"
                                value="{{$pz->keterangan_operator ?? old('keterangan_operator')}}">
                            @error('keterangan_operator') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    @endcan('isAdmin')
            </div>
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
        "order": [
            [1, 'desc']
        ]
    });

    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
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