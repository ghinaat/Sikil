@extends('adminlte::page')
@section('title', 'List Pengajuan Perbaikan Barang TIK')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Pengajuan Perbaikan Barang TIK</h1>
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
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sortedTIK = $perbaikanBarang->sortByDesc('id_pengajuan_perbaikan');
                            $nomor = 1; // Initialize a variable to keep track of the sequence
                            @endphp
                            @foreach($sortedTIK as $key => $pk)
                            <tr>
                                <td></td>
                                <td id="">{{ \Carbon\Carbon::parse($pk->tgl_pengajuan)->format('d M Y') }}
                                </td>
                                <td>{{$pk->users->nama_pegawai}}</td>
                                <td>{{$pk->barang->nama_barang}}</td>
                                <td>
                                    @if($pk->status == 'diajukan')
                                    Diajukan
                                    @elseif($pk->status == 'diproses')
                                    Diproses
                                    @else
                                    Selesai
                                    @endif
                                </td>
                                <td>
                                    <div class='btn-group'>
                                        @if($pk->status == "diajukan" )
                                        <a href="{{ route('ajuanperbaikan' . '.show', $pk->id_pengajuan_perbaikan) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        @if(auth()->user()->id_users == $pk->id_users || auth()->user()->level ==
                                        'admin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$pk->id_pengajuan_perbaikan}}"
                                            data-id="{{$pk->id_pengajuan_perbaikan}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="{{route('ajuanperbaikan.destroy', $pk->id_pengajuan_perbaikan)}}"
                                            onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                            class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif
                                        @else
                                        <a href="{{ route('ajuanperbaikan' . '.show', $pk->id_pengajuan_perbaikan) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        @can('isAdmin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$pk->id_pengajuan_perbaikan}}"
                                            data-id="{{$pk->id_pengajuan_perbaikan}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="{{route('ajuanperbaikan.destroy', $pk->id_pengajuan_perbaikan)}}"
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Pengajuan Perbaikan Barang TIK </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanperbaikan.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-body">
                        <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">

                        <div class="form-group">
                            <label for="id_barang_tik" class="form-label">Nama Peralatan TIK</label>
                            <div class="form-input">
                                <select class="form-select" id="id_barang_tik" name="id_barang_tik" required>
                                    @foreach($barang as $key => $br)
                                    <option value="{{$br->id_barang_tik}}" @if (old('id_barang_tik')==$br->
                                        id_barang_tik) selected
                                        @endif>
                                        {{ $br->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_pemohon" class='form-label'>Keterangan</label>
                            <div class="form-input">
                                <textarea row="3" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror" required></textarea>
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
@foreach($perbaikanBarang as $pk)
<div class="modal fade" id="editModal{{$pk->id_pengajuan_perbaikan}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Pengajuan Perbaikan Barang TIK</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('ajuanperbaikan.update',$pk->id_pengajuan_perbaikan) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tgl_pengajuan" class='form-label'>Tanggal Pengajuan</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('tgl_pengajuan') is-invalid @enderror" id=""
                                name=""
                                value="{{ \Carbon\Carbon::parse($pk->tgl_pengajuan)->format('d M Y') ?? old('tgl_pengajuan')}}"
                                readonly>
                            @error('tgl_pengajuan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_users" class='form-label'>Pemohon</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('id_users') is-invalid @enderror" id=""
                                name="" value="{{  $pk->users->nama_pegawai ?? old('id_users')}}" readonly>
                            @error('id_users') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_barang_tik" class="form-label">Nama Peralatan TIK</label>
                        <div class="form-input">
                            <select class="form-select" id="id_barang_tik" name="id_barang_tik" required>
                                @foreach ($barang as $br)
                                <option value="{{ $br->id_barang_tik }}" @if( $pk->
                                    id_barang_tik == old('id_barang_tik', $br->id_barang_tik) )
                                    selected @endif>
                                    {{ $br->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pemohon" class='form-label'>Keterangan</label>
                        <div class="form-input">
                            <textarea row="3" name="keterangan_pemohon" id="keterangan_pemohon" class="form-control 
                            @error('keterangan_pemohon') is-invalid @enderror"
                                required>{{old('keterangan_pemohon', $pk->keterangan_pemohon)}}</textarea>
                            @error('keterangan_pemohon') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    @can('isAdmin')
                    <div class="form-group">
                        <label for="nama_operator" class="form-label">Nama Operator</label>
                        <div class="form-input">
                            <select class="form-select" id="nama_operator" name="nama_operator" required>
                                <option value="Hana" @if($pk->nama_operator == 'Hana' || old('nama_operator') == 'Hana')
                                    selected @endif>Hana</option>
                                <option value="Bayu" @if($pk->nama_operator == 'Bayu' ||
                                    old('nama_operator') == 'Bayu') selected @endif>Bayu</option>
                                <option value="Wendy" @if($pk->nama_operator == 'Wendy' ||
                                    old('nama_operator') == 'Wendy') selected @endif>Wendy</option>
                                <option value="Siswa Magang" @if($pk->nama_operator == 'Siswa Magang' ||
                                    old('nama_operator') == 'Siswa Magang') selected @endif>Siswa Magang</option>
                                <option value="Lainnya" @if($pk->nama_operator == 'Lainnya' ||
                                    old('nama_operator') == 'Lainnya') selected @endif>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pengecekan" class='form-label'>Tanggal Pengecekan </label>
                        <div class="form-input">
                            <input type="date" class="form-control @error('tgl_pengecekan') is-invalid @enderror"
                                id="tgl_pengecekan" name="tgl_pengecekan"
                                value="{{ $pk->tgl_pengecekan ?? old('tgl_pengecekan')}}">
                            @error('tgl_pengecekan') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_operator" class='form-label'>Keterangan Operator</label>
                        <div class="form-input">
                            <textarea row="3" name="keterangan_operator" id="keterangan_operator"
                                class="form-control 
                            @error('keterangan_operator') is-invalid @enderror">{{old('keterangan_operator', $pk->keterangan_operator)}}</textarea>
                            @error('keterangan_operator') <span class="textdanger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <div class="form-input">
                            <select class="form-select" id="status" name="status" required>
                                <option value="diajukan" @if($pk->status == 'diajukan' || old('status') ==
                                    'diajukan')
                                    selected @endif>Diajukan</option>
                                <option value="diproses" @if($pk->status == 'diproses' ||
                                    old('status') == 'diproses') selected @endif>Diproses</option>
                                <option value="selesai" @if($pk->status == 'selesai' ||
                                    old('status') == 'selesai') selected @endif>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai" class='form-label'>Tanggal Selesai</label>
                        <div class="form-input">
                            <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror"
                                id="tgl_selesai" name="tgl_selesai" value="{{ $pk->tgl_selesai ?? old('tgl_selesai')}}">
                            @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
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