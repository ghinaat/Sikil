@extends('adminlte::page')
@section('title', 'List Barang TIK')
@section('content_header')
<h1 class="m-0 text-dark">Barang TIK</h1>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('isAdmin')
                <div class="mb-2">
                    @can('isAdmin')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
                    @endcan
                </div>
                @endcan
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Ketersediaan</th>
                                <th style="width:180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $showDetail = true; 
                            $sortedbarangTik = $barangTik->sortBy('nama_barang');
                            $nomor = 1; // Inisialisasi variabel untuk nomor urutan
                            @endphp
                            @foreach($sortedbarangTik as $key => $bt)
                                <tr>
                                    <td id={{$key+1}}>{{$nomor}}</td>
                                    <td id={{$key+1}}>{{$bt->nama_barang}}</td>
                                    <td id={{$key+1}}>{{$bt->jenis_aset}}</td>
                                    <td id={{$key+1}}>{{$bt->ruangan->nama_ruangan}}</td>
                                    <td id={{$key+1}}>
                                       @php
                                            $detail = $detailPeminjaman->where('id_barang_tik', $bt->id_barang_tik)->first();
                                        @endphp
                                        @if ($detail)
                                             @if ($detail->status == 'dipinjam')
                                                Dipinjam
                                             @elseif($detail->status == 'dikembalikan')
                                                Ada
                                            @else
                                                Ada
                                             @endif
                                        @else
                                            Ada
                                        @endif
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('barangtik' . '.show', $bt->id_barang_tik) }}" class="btn btn-info btn-xs">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            @can('isAdmin')
                                                <a href="#" class="btn btn-primary btn-xs edit-button mx-1" data-toggle="modal"
                                                        data-target="#editModal{{$bt->id_barang_tik}}"
                                                        data-id="{{$bt->id_barang_tik}}">
                                                        <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{route('barangtik.destroy', $bt->id_barang_tik)}}"
                                                    onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                                    class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
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
                <h5 class="modal-title" id="addModalLabel">Tambah Barang TIK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('barangtik.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Jenis Aset</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="jenis_aset" value="BMN"  checked> &nbsp;BMN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="jenis_aset" value="Non-BMN" checked> &nbsp;Non-BMN<br>
                            </div>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('kode_barang') is-invalid @enderror"
                            id="kode_barang" name="kode_barang">
                        @error('kode_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                            id="nama_barang" name="nama_barang" required>
                            @error('nama_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('merek') is-invalid @enderror"
                            id="merek" name="merek" required>
                        @error('merek') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelengkapan" class="form-label">Kelengkapan</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('kelengkapan') is-invalid @enderror"
                            id="kelengkapan" name="kelengkapan" required>
                        @error('kelengkapan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('tahun_pembelian') is-invalid @enderror"
                            id="tahun_pembelian" name="tahun_pembelian" required>
                        @error('tahun_pembelian') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kondisi" class="form-label">Kondisi</label>
                        <div class="form-input">
                            <select class="form-select" id="kondisi" name="kondisi" required>
                                <option value="Baik">Baik</option>
                                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                                <option value="Rusak Total">Rusak Total</option>
                            </select>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pinjam" class="form-label">Status Boleh Pinjam</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="status_pinjam" value="Ya"  checked>&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="status_pinjam" value="Tidak" checked >&nbsp;Tidak<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_ruangan" class="form-label">Lokasi</label>
                        <div class="form-input">
                            <select class="form-select" id="id_ruangan" name="id_ruangan" required>
                                @foreach($ruangan as $key => $rn)
                                <option value="{{$rn->id_ruangan}}" @if( old('id_ruangan')==$rn->id_ruangan
                                    )selected @endif>
                                    {{ $rn->nama_ruangan }}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <div class="form-input">
                            <textarea row="3" name="keterangan" id="keterangan" class="form-control 
                            @error('keterangan') is-invalid @enderror"required></textarea>
                        @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>    
                    <div class="form-group-page">
                        <label for="image" class="form-label">Image</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/jpg, image/jpeg, image/png">
                            <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png </small>
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
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


@foreach($barangTik as $bt)
<div class="modal fade" id="editModal{{$bt->id_barang_tik}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Barang Tik</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('barangtik.update',$bt->id_barang_tik) }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Jenis Aset</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="jenis_aset" value="BMN" @if ($bt->jenis_aset === 'BMN') checked @endif> &nbsp;BMN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="jenis_aset" value="Non-BMN" @if ($bt->jenis_aset === 'Non-BMN') checked @endif> &nbsp;Non-BMN<br>
                            </div>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('kode_barang') is-invalid @enderror"
                            id="kode_barang" name="kode_barang" value="{{old('kode_barang', $bt->kode_barang)}}" required>
                        @error('kode_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                            id="nama_barang" name="nama_barang" value="{{old('nama_barang', $bt->nama_barang)}}" required>
                            @error('nama_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('merek') is-invalid @enderror"
                            id="merek" name="merek" value="{{old('merek', $bt->merek)}}" required >
                        @error('merek') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelengkapan" class="form-label">Kelengkapan</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('kelengkapan') is-invalid @enderror"
                            id="kelengkapan" name="kelengkapan" value="{{old('kelengkapan', $bt->kelengkapan)}}" required>
                        @error('kelengkapan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                        <div class="form-input">
                            <input type="text"
                            class="form-control @error('tahun_pembelian') is-invalid @enderror"
                            id="tahun_pembelian" name="tahun_pembelian"  value="{{old('tahun_pembelian', $bt->tahun_pembelian)}}" required>
                        @error('tahun_pembelian') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kondisi" class="form-label">Kondisi</label>
                        <div class="form-input">
                            <select class="form-select" id="kondisi" name="kondisi" required>
                                <option value="Baik"  @if($bt->kondisi == 'Baik' || old('kondisi') == 'Baik') selected @endif>Baik</option>
                                <option value="Perlu Perbaikan"  @if($bt->kondisi == 'Perlu Perbaikan' || old('kondisi') == 'Perlu Perbaikan') selected @endif>Perlu Perbaikan</option>
                                <option value="Rusak Total"  @if($bt->kondisi == 'Rusak Total' || old('kondisi') == 'Rusak Total') selected @endif>Rusak Total</option>
                            </select>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_pinjam" class="form-label">Status Boleh Pinjam</label>
                        <div class="form-input">
                            <div class="form-inline">
                                <input type="radio" name="status_pinjam" value="Ya"  @if ($bt->status_pinjam === 'Ya') checked @endif>&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <input type="radio" name="status_pinjam" value="Tidak"  @if ($bt->status_pinjam === 'Tidak') checked @endif >&nbsp;Tidak<br>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_ruangan" class="form-label">Lokasi</label>
                        <div class="form-input">
                            <select class="form-select" id="id_ruangan" name="id_ruangan" required>
                                @foreach($ruangan as $key => $rn)
                                <option value="{{$rn->id_ruangan}}" @if($bt->id_ruangan == $rn->id_ruangan || old('id_ruangan') == $rn->id_ruangan) selected @endif>
                                    {{ $rn->nama_ruangan }}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <div class="form-input">
                            <textarea row="3" name="keterangan" id="keterangan" class="form-control 
                            @error('keterangan') is-invalid @enderror"required>{{old('keterangan', $bt->keterangan)}}</textarea>
                        @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>    
                    <div class="form-group-page">
                        <label for="image" class="form-label">Image</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/jpg, image/jpeg, image/png">
                            @if($bt->image)
                            <p>Previous File: <a href="{{ asset('/storage/imageTIK/'. $bt->image) }}"
                                target="_blank">{{ $bt->image }}</a></p>
                            @endif
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
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
@endpush