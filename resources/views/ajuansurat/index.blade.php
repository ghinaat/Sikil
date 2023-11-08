@extends('adminlte::page')
@section('title', 'Nomor Surat')
@section('content_header')
<h1 class="m-0 text-dark">Kelola Nomor Surat</h1>
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
                                <th>Tanggal Surat</th>
                                <th>Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Keterangan</th>
                                <th>Nomor Surat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sortedAjuanSurat = $surat->sortByDesc('created_at');
                            $nomor = 1; // Initialize a variable to keep track of the sequence
                            @endphp
                            @foreach($sortedAjuanSurat as $key => $sr)
                            <tr>
                                <td id={{$key+1}}>{{$nomor}}</td>
                                <td id={{$key+1}}>{{$sr->created_at->format('d M Y')}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($sr->tgl_surat), 'd M Y')}}</td>
                                <td id={{$key+1}}>{{$sr->user->nama_pegawai}}</td>
                                @if($sr->jenis_surat === 'nota_dinas')
                                <td id={{$key+1}}>Nota Dinas</td>
                                @elseif($sr->jenis_surat === 'notula_rapat')
                                <td id={{$key+1}}>Notula Rapat</td>
                                @elseif($sr->jenis_surat === 'sertifikat_kegiatan')
                                <td id={{$key+1}}>Sertifikat Kegiatan</td>
                                @elseif($sr->jenis_surat === 'sertifikat_magang')
                                <td id={{$key+1}}>Sertifikat Magang</td>
                                @elseif($sr->jenis_surat === 'surat_keluar')
                                <td id={{$key+1}}>Surat Keluar</td>
                                @endif
                                <td id={{$key+1}}>{{$sr->keterangan}}</td>
                                <td id={{$key+1}}>{{$sr->no_surat}}</td>
                                <td id={{$key+1}}>
                                    @if($sr->status === '1')
                                    Disetujui
                                    @else
                                    Menunggu Persetujuan
                                    @endif
                                </td>
                                <td id={{$key+1}}>
                                    @if($sr->status === '1')
                                        <i class="fas fa-check-circle  fa-2x" style="color: #42e619; align-items: center;"></i>
                                    @else
                                        @include('components.action-buttons', ['id' => $sr->id_surat, 'key' => $key, 'route' => 'ajuansurat'])
                                    @endif
                                </td>
                            </tr>
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
                <h4 class="modal-title" id="exampleModalLabel">Ajuan Nomor Surat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuansurat.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Jenis Surat </label>
                                        <select class="form-select  @error('jenis_surat') is-invalid @enderror"
                                        id="jenis_surat" name="jenis_surat">
                                        <option value="nota_dinas">Nota Dinas</option>
                                        <option value="notula_rapat">Notula Rapat</option>
                                        <option value="sertifikat_kegiatan">Sertifikat Kegiatan</option>
                                        <option value="sertifikat_magang">Sertifikat Magang</option>
                                        <option value="surat_keluar">Surat Keluar</option>
                                    </select>
                                        @error('divisi') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="id_kode_surat">Kode Surat</label>
                                        <select id="id_kode_surat" name="id_kode_surat"class="form-select @error('id_kode_surat') is-invalid @enderror">
                                            @foreach ($kodesurat as $ks)
                                            <option value="{{ $ks->id_kode_surat }}" @if( old('id_kode_surat')==$ks->
                                                id_kode_surat )selected
                                                @endif>
                                                {{ $ks->kode_surat }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_surat') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" value="{{old('keterangan')}}">{{old('id_kode_surat')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_surat">Tanggal Surat</label>
                                        <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror"
                                        id="tgl_surat" name="tgl_surat" value="{{old('tgl_surat')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="bulan_kegiatan">Bulan Kegiatan</label>
                                        <select class="form-select" id="bulan_kegiatan" name="bulan_kegiatan">
                                            <option value="I">Januari</option>
                                            <option value="II">Februari</option>
                                            <option value="III">Maret</option>
                                            <option value="IV">April</option>
                                            <option value="V">Mei</option>
                                            <option value="VI">Juni</option>
                                            <option value="VII">Juli</option>
                                            <option value="VIII">Agustus</option>
                                            <option value="IX">September</option>
                                            <option value="X">Oktober</option>
                                            <option value="XI">November</option>
                                            <option value="XII">Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($surat as $sr)
<div class="modal fade" id="editModal{{$sr->id_surat}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Kode Surat</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuansurat.update',$sr->id_surat) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $sr->id_surat }}">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_users" value={{ $sr->id_users }}>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputName">Jenis Surat </label>
                                        <select class="form-select  @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat">
                                            <option value="nota_dinas" @if($sr->jenis_surat === 'nota_dinas' || old('jenis_surat') === 'nota_dinas') selected @endif>Nota Dinas</option>
                                            <option value="notula_rapat" @if($sr->jenis_surat === 'notula_rapat' || old('jenis_surat') === 'notula_rapat') selected @endif>Notula Rapat</option>
                                            <option value="sertifikat_kegiatan" @if($sr->jenis_surat === 'sertifikat_kegiatan' || old('jenis_surat') === 'sertifikat_kegiatan') selected @endif>Sertifikat Kegiatan</option>
                                            <option value="sertifikat_magang" @if($sr->jenis_surat === 'sertifikat_magang' || old('jenis_surat') === 'sertifikat_magang') selected @endif>Sertifikat Magang</option>
                                            <option value="surat_keluar" @if($sr->jenis_surat === 'surat_keluar' || old('jenis_surat') === 'surat_keluar') selected @endif>Surat Keluar</option>
                                        </select>
                                        @error('divisi') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="id_kode_surat">Kode Surat</label>
                                        <select id="id_kode_surat" name="id_kode_surat"class="form-select @error('id_kode_surat') is-invalid @enderror">
                                            @foreach ($kodesurat as $ks)
                                            <option value="{{ $ks->id_kode_surat }}" @if($sr->id_kode_surat == $ks->id_kode_surat || old('id_kode_surat') === $ks->id_kode_surat) selected @endif>
                                                {{ $ks->kode_surat }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_surat') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                        id="keterangan" name="keterangan" value="{{old('keterangan', $sr->keterangan )}}">{{old('id_kode_surat', $sr->keterangan )}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_surat">Tanggal Surat</label>
                                        <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror"
                                        id="tgl_surat" name="tgl_surat" value="{{old('tgl_surat', $sr->tgl_surat)}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="bulan_kegiatan">Bulan Kegiatan</label>
                                        <select class="form-select" id="bulan_kegiatan" name="bulan_kegiatan">
                                            <option value="I" @if($sr->bulan_kegiatan === "I" || old('bulan_kegiatan') === "I" ) selected @endif>Januari</option>
                                            <option value="II" @if($sr->bulan_kegiatan === "II" || old('bulan_kegiatan') === "II" ) selected @endif>Februari</option>
                                            <option value="III" @if($sr->bulan_kegiatan === "III" || old('bulan_kegiatan') === "III" ) selected @endif>Maret</option>
                                            <option value="IV" @if($sr->bulan_kegiatan === "IV" || old('bulan_kegiatan') === "IV" ) selected @endif>April</option>
                                            <option value="V" @if($sr->bulan_kegiatan === "V" || old('bulan_kegiatan') === "V" ) selected @endif>Mei</option>
                                            <option value="VI" @if($sr->bulan_kegiatan === "VI" || old('bulan_kegiatan') === "VI" ) selected @endif>Juni</option>
                                            <option value="VII" @if($sr->bulan_kegiatan === "VII" || old('bulan_kegiatan') === "VII" ) selected @endif>Juli</option>
                                            <option value="VIII" @if($sr->bulan_kegiatan === "VIII" || old('bulan_kegiatan') === "VIII" ) selected @endif>Agustus</option>
                                            <option value="IX" @if($sr->bulan_kegiatan === "IX" || old('bulan_kegiatan') === "IX" ) selected @endif>September</option>
                                            <option value="X" @if($sr->bulan_kegiatan === "X" || old('bulan_kegiatan') === "X" ) selected @endif>Oktober</option>
                                            <option value="XI" @if($sr->bulan_kegiatan === "XI" || old('bulan_kegiatan') === "XI" ) selected @endif>November</option>
                                            <option value="XII" @if($sr->bulan_kegiatan === "XII" || old('bulan_kegiatan') === "XII" ) selected @endif>Desember</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_izin_atasan">Apakah anda menyetujui
                                            Surat {{$sr->no_surat}}?</label>
                                        <div class="input">
                                            <input type="radio" name="status"
                                                value="1" @if ($sr->status === '1')
                                            checked @endif> Disetujui<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
$('#example2').DataTable({
    "responsive": true,
});

function notificationBeforeDelete(event, el) {
    event.preventDefault();
    if (confirm('Apakah anda yakin akan menghapks data ? ')) {
        $("#delete-form").attr('action', $(el).attr('href'));
        $("#delete-form").submit();
    }
}
</script>
@endpush
