@extends('adminlte::page')
@section('title', 'List Sirkulasi Inventaris PPR')
@section('content_header')
<h1 class="m-0 text-dark">Sirkulasi Inventaris PPR</h1>
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
                                <th>Jumlah</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>PIC</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sirkulasibarang as $key => $sb)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$sb->barangppr->nama_barang}}</td>
                                <td>{{$sb->jumlah}}</td>
                                <td>{{$sb->jenis_sirkulasi}}</td>
                                <td>{{ \Carbon\Carbon::parse($sb->tgl_sirkulasi)->format('d M Y') }}</td>
                                <td>{{$sb->users->nama_pegawai}}</td>
                                <td>{{$sb->keterangan}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@can('isAdmin')
<!-- Create Modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Sirkulasi Inventaris PPR</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('sirkulasibarang.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <input type="hidden" name="id_users" value="{{ Auth::user()->id_users}}">
                                <div class="col-md-12">
                                <div class="form-group">
                                        <label class="control-label col-md-6" for="id_barang_ppr">Nama Barang</label>
                                        <select id="id_barang_ppr" name="id_barang_ppr"
                                            class="form-select @error('id_barang_ppr') is-invalid @enderror" required>
                                            @foreach ($barangppr as $bp)
                                            <option value="{{ $bp->id_barang_ppr }}" @if( old('id_barang_ppr')==$bp->id_barang_ppr )selected @endif>
                                                {{ $bp->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}">
                                        @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_sirkulasi">Jenis Sirkulasi</label>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis_sirkulasi" value="penambahan" id="penambahanRadio">
                                                    <label class="form-check-label" for="penambahanRadio">Penambahan</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis_sirkulasi" value="pengurangan" id="penguranganRadio">
                                                    <label class="form-check-label" for="penguranganRadio">Pengurangan</label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('jenis_sirkulasi') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                        @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
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
@endcan
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
            "order": [
                [1, 'asc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }]
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
@endpush
