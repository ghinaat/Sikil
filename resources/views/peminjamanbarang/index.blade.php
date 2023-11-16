@extends('adminlte::page')
@section('title', 'List Peminjaman Barang TIK')
@section('content_header')
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Peminjaman Barang TIK</h1>
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
                                <th>Tanggal Pinjam</th>
                                <th>Kegiatan</th>
                                <th>PIC</th>
                                <th>Status</th>
                                <th style="width:115px;">Detail Barang</th>
                                <th style="width:189px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sortedPeminjaman = $peminjaman->sortByDesc('tgl_peminjaman');
                            $nomor = 1; // Initialize a variable to keep track of the sequence
                            @endphp
                            @foreach($sortedPeminjaman as $key => $pj)
                            <tr>
                                <td ></td>
                                <td >{{ \Carbon\Carbon::parse($pj->tgl_peminjaman)->format('d M Y') }}</td>
                                <td>{{$pj->kegiatan}}</td>
                                <td>{{$pj->users->nama_pegawai}}</td>
                                <td>@if($pj->status == 'belum_diajukan')
                                    Belum Diajukan
                                    @elseif($pj->status == 'dikembalikan_sebagian')
                                    Dikembalikan Sebagian
                                    @elseif($pj->status == 'dikembalikan')
                                    Dikembalikan
                                    @elseif($pj->status == 'dipinjam')
                                    Dipinjam
                                    @else
                                    Diajukan
                                    @endif</td>
                                <td>
                                <a href="{{ route('peminjaman' . '.show', $pj->id_peminjaman) }}"
                                            class="btn btn-info btn-xs mx-1">
                                            <i class="fa fa-rectangle-list"></i>
                                </a>
                                </td>
                                <td>
                                    <div class='btn-group'>
                                    @if($pj->status == "belum_diajukan" )
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                data-target="#editModal{{$pj->id_peminjaman}}"
                                                data-id="{{$pj->id_peminjaman}}">
                                                <i class="fa fa-edit"></i>
                                    </a>
                                    &nbsp;
                                    <a href="{{route('peminjaman.destroy', $pj->id_peminjaman)}}"
                                                onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                    </a>
                                    <!-- @include('components.action-buttons', ['id' => $pj->id_peminjaman, 'key' => $key,
                                    'route' => 'peminjaman']) -->
                                    @else
                                        @if(auth()->user()->level != 'admin')
                                    <i class="fas fa-check-circle  fa-2x"
                                                style="color: #42e619; align-items: center;"></i>
                                    @endif
                                    @can('isAdmin', 'isKadiv')
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                                data-target="#editModal{{$pj->id_peminjaman}}"
                                                data-id="{{$pj->id_peminjaman}}">
                                                <i class="fa fa-edit"></i>
                                    </a>
                                    <!-- <a href="{{route('peminjaman.destroy', $pj->id_peminjaman)}}"
                                                onclick="notificationBeforeDelete(event, this, <?php echo $key+1; ?>)"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i>
                                    </a> -->
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
                <h4 class="modal-title" id="exampleModalLabel">Tambah Peminjaman Barang TIK </h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('peminjaman.store') }}" method="POST" id="form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="id">
                    <div class="form-body">
                        <input type="hidden" name="id_users"
                            value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                        <div class="form-group">
                            <label for="tgl_peminjaman" class='form-label'>Tanggal Peminjaman</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror"
                                    id="tgl_peminjaman" name="tgl_peminjaman" value="{{ old('tgl_peminjaman')}}">
                                @error('tgl_peminjaman') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengembalian" class='form-label'>Tanggal Pengembalian</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror"
                                    id="tgl_pengembalian" name="tgl_pengembalian" value="{{ old('tgl_pengembalian')}}">
                                @error('tgl_pengembalian') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan" class='form-label'>Nama Kegiatan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('kegiatan') is-invalid @enderror"
                                    id="kegiatan" name="kegiatan" value="{{ old('kegiatan')}}">
                                @error('kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class='form-label'>Keterangan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan" name="keterangan" value="{{ old('keterangan')}}">
                                @error('keterangan') <span class="textdanger">{{$message}}</span> @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal Edit -->
@foreach($peminjaman as $pj)
<div class="modal fade" id="editModal{{$pj->id_peminjaman}}" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Peminjaman</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body form">
                <form action="{{ route('peminjaman.update',$pj->id_peminjaman) }}" method="POST" id="form"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  
                    <div class="form-body">
                        <input type="hidden" name="id_users"
                            value="@if(isset($id_users)) {{ $id_users }} @else {{ Auth::user()->id_users }} @endif">
                        <div class="form-group">
                            <label for="tgl_peminjaman" class='form-label'>Tanggal Peminjaman</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_peminjaman') is-invalid @enderror"
                                    id="tgl_peminjaman" name="tgl_peminjaman"
                                    value="{{ $pj->tgl_peminjaman ?? old('tgl_peminjaman')}}">
                                @error('tgl_peminjaman') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pengembalian" class='form-label'>Tanggal
                                Pengembalian</label>
                            <div class="form-input">
                                <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror"
                                    id="tgl_pengembalian" name="tgl_pengembalian"
                                    value="{{ $pj->tgl_pengembalian ?? old('tgl_pengembalian')}}">
                                @error('tgl_pengembalian') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan" class='form-label'>Nama Kegiatan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('kegiatan') is-invalid @enderror"
                                    id="kegiatan" name="kegiatan" value="{{ $pj->kegiatan ?? old('kegiatan')}}">
                                @error('kegiatan') <span class="textdanger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @can('isAdmin', 'isKadiv')
                        <div class="form-group">
                            <label for="status" class='form-label'>Status</label>
                            <div class="form-input">
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="belum_diajukan" @if($pj->status == 'belum_diajukan' ||
                                        old('status')=='belum_diajukan' )selected
                                        @endif>Belum Diajukan</option>
                                    <option value="diajukan" @if($pj->status == 'diajukan' ||
                                        old('status')=='diajukan' )selected
                                        @endif>Diajukan</option>
                                    <option value="dipinjam" @if($pj->status == 'dipinjam' ||
                                        old('status')=='dipinjam' )selected @endif>Dipinjam
                                    </option>
                                    <option value="dikembalikan_sebagian" @if($pj->status == 'dikembalikan_sebagian' ||
                                        old('status')=='dikembalikan_sebagian' )selected
                                        @endif>Dikembalikan Sebagian</option>
                                    <option value="dikembalikan" @if($pj->status == 'dikembalikan' ||
                                        old('status')=='dikembalikan' )selected @endif>Dikembalikan
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        @endcan
                        <div class="form-group">
                            <label for="keterangan" class='form-label'>Keterangan</label>
                            <div class="form-input">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                    id="keterangan" name="keterangan" value="{{ $pj->keterangan ?? old('keterangan')}}">
                                @error('keterangan') <span class="textdanger">{{$message}}</span>
                                @enderror
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
$(document).ready(function() {
    var table = $('#example2').DataTable({
        "responsive": true,
        "order": [[1, 'desc']]
    });

    table.on('order.dt search.dt', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
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