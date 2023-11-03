@extends('adminlte::page')
@section('title', 'List Ruangan')
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form">
                        Tambah
                    </button>
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
                                <th>Status</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $showDetail = true; @endphp
                            @foreach($barangTik as $key => $bt)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$bt->nama_barang}}</td>
                                <td>{{$bt->jenis_aset}}</td>
                                <td>{{$bt->ruangan->nama_ruangan}}</td>
                                <td>{{$bt->status_pinjam}}</td>
                                <td>
                                    @include('components.action-buttons', ['id' => $bt->id_barang_tik, 'key' => $key,
                                    'route' => 'barangtik'])
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
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/jpg, image/jpeg, image/png">
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
                <h4 class="modal-title" id="exampleModalLabel">Edit Data Ruangan</h4>
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
                    <div class="form-group mb-0">
                        <label for="image" class="form-label">Image</label>
                        <div class="form-input">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/jpg, image/jpeg, image/png">
                        
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-label">&nbsp;</label>
                        <div class="form-input">
                            <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png</small>
                            <p>Previous File: <a href="{{ asset('/storage/imageTIK/'. $bt->image) }}"
                                target="_blank">{{ $bt->image }}</a></p>
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
        "order": [[1, 'asc']],
        "columnDefs": [
            { "orderable": false, "targets": [0] }
        ]
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