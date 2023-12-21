@extends('adminlte::page')
@section('title', 'List Inventaris PPR')
@section('content_header')
<h1 class="m-0 text-dark">Inventaris PPR</h1>
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
                                <th>Tahun</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangppr as $key => $bp)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{$bp->nama_barang}}</td>
                                <td id={{$key+1}}>{{$bp->tahun_pembuatan}}</td>
                                <td id={{$key+1}}>{{$bp->jumlah}}</td>
                                <td id={{$key+1}}>{{$bp->keterangan}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('barangppr' . '.show', $bp->id_barang_ppr) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                        @if(auth()->user()->level === 'admin')
                                        <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                            data-target="#editModal{{$bp->id_barang_ppr}}"
                                            data-id="{{$bp->id_barang_ppr}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('barangppr' . '.destroy', $bp->id_barang_ppr) }}"
                                            onclick="notificationBeforeDelete(event, this, {{$key+1}})"
                                            class="btn btn-danger btn-xs mx-1">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{$bp->id_barang_ppr}}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{$bp->id_barang_ppr}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Inventaris PPR</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('barangppr.update', $bp->id_barang_ppr) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="nama_barang" class='form-label'>Nama Barang</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                                            id="nama_barang" name="nama_barang" value="{{$bp-> nama_barang ?? old('nama_barang')}}">
                                                        @error('nama_barang') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tahun_pembuatan" class='form-label'>Tahun Pembuatan</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control" class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                                                            id="tahun_pembuatan" name="tahun_pembuatan" value="{{$bp-> tahun_pembuatan ?? old('tahun_pembuatan')}}">
                                                        @error('tahun_pembuatan') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah" class="form-label">Jumlah</label>
                                                    <div class="form-input">
                                                        <input type="number" class="form-control" class="form-control @error('jumlah') is-invalid @enderror"
                                                            id="jumlah" name="jumlah" value="{{$bp-> jumlah ?? old('jumlah')}}">
                                                        @error('jumlah') <span class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="id_ruangan">Lokasi Barang</label>
                                                    <select class="form-select @error('nama') isinvalid @enderror" id="id_ruangan" name="id_ruangan">
                                                        @foreach ($ruangan as $pn)
                                                        <option value="{{$pn->id_ruangan}}" @if($bp-> id_ruangan === old('id_ruangan',$pn->id_ruangan )) selected @endif">
                                                            {{ $pn->nama_ruangan }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('level') <span class="textdanger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <div class="form-input">
                                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                                            id="keterangan" name="keterangan" value="{{$bp-> keterangan ?? old('keterangan')}}">
                                                        @error('keterangan') <span
                                                            class="textdanger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Gambar</label>
                                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                        id="image" name="image" accept="image/jpeg ,image/jpg ,image/png ,application/pdf ,application/docx"> 
                                                        @error('image') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                                    <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png</small>
                                                    @if ($bp->image)
                                                    <p>Previous File: <a href="{{ asset('/storage/image_barangppr/'. $bp->image) }}" target="_blank">{{ $bp->image }}</a></p>
                                                    @endif
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Inventaris PPR</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('barangppr.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text"
                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                            id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}">
                                        @error('nama_barang') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_pembuatan">Tahun Pembuatan</label>
                                        <input type="text"
                                            class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                                            id="tahun_pembuatan" name="tahun_pembuatan"
                                            value="{{ old('tahun_pembuatan') }}">
                                        @error('tahun_pembuatan') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah') }}">
                                        @error('jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-6" for="id_ruangan">Lokasi Barang</label>
                                        <select id="id_ruangan" name="id_ruangan"
                                            class="form-select @error('id_ruangan') is-invalid @enderror" required>
                                            @foreach ($ruangan as $rn)
                                            <option value="{{ $rn->id_ruangan }}" @if( old('id_ruangan')==$rn->id_ruangan )selected @endif>
                                                {{ $rn->nama_ruangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                        @error('keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" enctype="multipart/form-data" name="image"
                                            accept="image/jpeg ,image/jpg ,image/png ,application/pdf ,application/docx">
                                        @error('image') <span class="invalid" role="alert">{{$message}}</span> @enderror
                                        <small class="form-text text-muted">Allow file extensions : .jpeg .jpg .png</small>
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
