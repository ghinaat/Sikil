@extends('adminlte::page')
@section('title', 'Detail Barang TIK')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/barangtik.css') }}">
<h1 class="m-0 text-dark">Detail Barang TIK</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_barang" class="form-label">Jenis Aset</label>
                    <div class="form-input">
                        : &nbsp;{{old('jenis_aset', $barangTik->jenis_aset)}}
                    </div>    
                </div>
                <div class="form-group">
                    <label for="kode_barang" class="form-label">Kode Barang</label>
                    <div class="form-input">
                        : &nbsp;{{old('kode_barang', $barangTik->kode_barang)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <div class="form-input">
                        : &nbsp;{{old('nama_barang', $barangTik->nama_barang)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="merek" class="form-label">Merek</label>
                    <div class="form-input">
                        : &nbsp;{{old('merek', $barangTik->merek)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="kelengkapan" class="form-label">Kelengkapan</label>
                    <div class="form-input">
                        : &nbsp;{{old('kelengkapan', $barangTik->kelengkapan)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                    <div class="form-input">
                        : &nbsp;{{old('tahun_pembelian', $barangTik->tahun_pembelian)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <div class="form-input">
                        : &nbsp;{{old('kondisi', $barangTik->kondisi)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_pinjam" class="form-label">Status Boleh Pinjam</label>
                    <div class="form-input">
                        : &nbsp;{{old('status_pinjam', $barangTik->status_pinjam)}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="id_ruangan" class="form-label">Lokasi</label>
                    <div class="form-input">
                        : &nbsp;{{old('id_ruangan', $barangTik->ruangan->nama_ruangan)}} 
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <div class="form-input">
                        : &nbsp;{{old('keterangan', $barangTik->keterangan)}}
                    </div>
                </div>    
                <div class="form-group">
                    <label for="status_pinjam" class="form-label">Ketersediaan</label>
                    <div class="form-input">
                        @if ($detailPeminjaman)
                            @if ($detailPeminjaman->status == 'dipinjam')
                                : &nbsp;Dipinjam
                            @elseif ($detailPeminjaman->status == 'dikembalikan')
                                : &nbsp;Ada
                            @else
                                : &nbsp;Ada
                            @endif
                        @else
                            : &nbsp;Ada
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Gambar</label>
                    <div class="form-input">
                        @if($barangTik->image)
                        : &nbsp;<img src="{{ asset('/storage/imageTIK/'. $barangTik->image)}}">
                        @else
                        :&nbsp;-                      
                        @endif
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <a href="{{route('barangtik.index')}}" class="btn btn-primary ">
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
