@extends('adminlte::page')
@section('title', 'Detail Peminjaman Barang TIK')
@section('content_header')
<style>
/* Gaya umum */
</style>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail Peminjaman Barang TIK</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="tgl_peminjaman" class='form-label'>Tanggal Peminjaman</label>
                    <div class="form-input">
                        :
                        {{ \Carbon\Carbon::parse($peminjaman->tgl_peminjaman)->format('d M Y') ?? old('tgl_peminjaman')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_pengembalian" class='form-label'>Tanggal Pengembalian</label>
                    <div class="form-input">
                        :
                        {{ \Carbon\Carbon::parse($peminjaman->tgl_pengembalian)->format('d M Y') ?? old('tgl_pengembalian')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="kegiatan" class="form-label">Tanggal Selesai</label>
                    <div class="form-input">
                        : {{$peminjaman-> kegiatan ?? old('kegiatan')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-input">
                        : {{$peminjaman-> status ?? old('status')}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <div class="form-input">
                        : {{$peminjaman-> keterangan ?? old('keterangan')}}
                    </div>
                </div>

                <div style="margin-top: 30px;"></div>
                <label>Data Barang</label>
                <div class="table-container">
                    <div class="table-responsive">
                        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal_form">Add</button>
                        <table class="table table-hover table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th class="center-th">No.</th>
                                    <th class="center-th">Nama Barang</th>
                                    <th class="center-th">Kondisi Awal</th>
                                    <th class="center-th">Kondisi Akhir</th>
                                    <th class="center-th">Tanggal Kembali</th>
                                    <th class="center-th">Keterangan</th>
                                    <th class="center-th" style='width: 50px;'>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailPeminjaman as $key => $dpj)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$dpj->barang->nama_barang}}</td>
                                    <td>{{$dpj->barang->kondisi }}</td>
                                    <td>{{$dpj->keterangan_akhir}}</td>
                                    <td>
                                        @if($dpj->tgl_kembali )
                                        {{ \Carbon\Carbon::parse($dpj->tgl_kembali)->format('d M Y') ?? old('tgl_kembali')}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{$dpj->keterangan_awal}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if($dpj->status == null)
                                            <a href="{{route('peminjaman.destroyDetail', $dpj->id_detail_peminjaman)}}"
                                                onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            &nbsp;
                                            <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                data-target="#editModal{{$dpj->id_detail_peminjaman}}"
                                                data-id="{{$dpj->id_detail_peminjaman}}">
                                                <i class="fa fa-undo"></i>
                                            </a>
                                            @elseif($dpj->status == 'dipinjam')
                                            @if(auth()->user()->level != 'admin')
                                            <i class="fas fa-check-circle  fa-2x"
                                                style="color: #42e619; align-items: center;"></i>
                                            @else
                                            <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                data-target="#editModal{{$dpj->id_detail_peminjaman}}"
                                                data-id="{{$dpj->id_detail_peminjaman}}">
                                                <i class="fa fa-undo"></i>
                                            </a>
                                            @endif
                                            @else
                                            <i class="fas fa-check-circle  fa-2x"
                                                style="color: #42e619; align-items: center;"></i>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="{{route('peminjaman.index')}}" class="btn btn-primary ">
                    Data Peminjaman Barang
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap modal Create -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data Barang TIK</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action='{{route("peminjaman.storeDetailPeminjaman")}}' method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">
                                <table class="table table-hover table-bordered table-stripped" id="example2">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Barang</th>
                                            <th>Kondisi</th>
                                            <th>Kelengkapan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barang as $index => $barang)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->kondisi }}</td>
                                            <td>{{ $barang->kelengkapan }}</td>
                                            <td>
                                                @php
                                                // Check if the user is already selected for the current $id_kegiatan
                                                $isBarangSelected = $detailPeminjaman->contains('barang.id_barang_tik',
                                                $barang->id_barang_tik);
                                                @endphp
                                                @if (!$isBarangSelected)
                                                <button type="button" class="btn btn-primary btn-xs"
                                                    onclick="pilih('{{ $barang->id_barang_tik }}','{{ $barang->nama_barang }}', '{{ $barang->kondisi }}', '{{ $barang->kelengkapan }}' )"
                                                    data-bs-dismiss="modal">
                                                    Pilih
                                                </button>
                                                @else
                                                <p>Sudah dipilih</p>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 mt-4" id="scroll-target">
                                    <div class="form-group ">
                                        <label class="control-label col-md-6">Nama Barang</label>
                                        <!-- Tambahkan input tersembunyi untuk menyimpan data yang dipilih -->
                                        <input type="hidden" id="selected_id_barang_tik" name="id_barang_tik" value="">
                                        <input type="text" class="form-control @error('barang') is-invalid @enderror"
                                            placeholder="barang" id="barang" name="barang" aria-label="barang"
                                            aria-describedby="cari" readonly>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-6" for="keterangan_awal">Keterangan Awal</label>
                                <div class="form-input">
                                    <input type="text"
                                        class="form-control @error('keterangan_awal') is-invalid @enderror"
                                        id="keterangan_awal" name="keterangan_awal" value="{{ old('keterangan_awal')}}">
                                    @error('keterangan_awal') <span class="textdanger">{{$message}}</span> @enderror
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
<!-- /.modal -->

@foreach($detailPeminjaman as $dpj)
<div class="modal fade" id="editModal{{$dpj->id_detail_peminjaman}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Pengembalian Barang TIK</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('peminjaman.updateDetailPeminjaman', $dpj->id_detail_peminjaman) }}"
                    method="POST" id="form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label" for="id_barang_tik">Nama Barang</label>
                        <div class="form-input">
                            <select id="id_barang_tik" name="id_barang_tik"
                                class="form-select @error('id_barang_tik') is-invalid @enderror">
                                @foreach ($barangs->all() as $id_barang_tik => $nama_barang)
                                <option value="{{ $id_barang_tik }}" @if($dpj->id_barang_tik ==
                                    $id_barang_tik) selected @endif>{{ $nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_awal" class="form-label">Keterangan Awal</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('keterangan_awal') is-invalid @enderror"
                                id="keterangan_awal" name="keterangan_awal"
                                value="{{ $dpj->keterangan_awal ?? old('keterangan_awal') }}">
                            @error('keterangan_awal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_akhir" class="form-label">Keterangan Akhir</label>
                        <div class="form-input">
                            <input type="text" class="form-control @error('keterangan_akhir') is-invalid @enderror"
                                id="keterangan_akhir" name="keterangan_akhir"
                                value="{{ $dpj->keterangan_akhir ?? old('keterangan_akhir') }}">
                            @error('keterangan_akhir') <span class="text-danger">{{ $message }}</span> @enderror
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
</script>
<script>
function pilih(id, nama_barang) {
    // Mengisi nilai input dengan data yang dipilih dari tabel
    document.getElementById('selected_id_barang_tik').value = id;
    document.getElementById('barang').value = nama_barang;

    // Gulir ke elemen dengan id "scroll-target"
    const scrollTarget = document.getElementById('scroll-target');
    scrollTarget.scrollIntoView({
        behavior: 'smooth'
    });
}
</script>


@endpush