@extends('adminlte::page')
@section('title', 'Detail Kegiatan')
@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail Kegiatan</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">



                <div class="form-group">
                    <label for="nama_kegiatan" class='form-label'>Nama Kegiatan</label>
                    <div class="form-input">

                        <input type="text" class="form-control
@error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" placeholder="Nama Kegiatan" name="nama_kegiatan"
                            value="{{$kegiatan -> nama_kegiatan ?? old('nama_kegiatan')}}" readonly>
                        @error('nama_kegiatan') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_mulai" class='form-label'>Tanggal Mulai Acara</label>
                    <div class="form-input">
                        <input type="date" class="form-control"
                            class="form-control @error('tgl_mulai') is-invalid @enderror" id="tgl_mulai"
                            placeholder="Tanggal Mulai" name="tgl_mulai"
                            value="{{$kegiatan -> tgl_mulai ?? old('tgl_mulai')}}" readonly>
                        @error('tgl_mulai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="tgl_selesai" class="form-label">Tanggal Selese</label>
                    <div class="form-input">
                        <input type="date" class="form-control"
                            class="form-control @error('tgl_selesai') is-invalid @enderror" id="tgl_selesai"
                            placeholder="Tanggal Mulai" name="tgl_selesai"
                            value="{{$kegiatan -> tgl_selesai ?? old('tgl_selesai')}}" readonly>
                        @error('tgl_selesai') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <div class="form-input">
                        <input type="text" class="form-control
@error('lokasi') is-invalid @enderror" id="lokasi" placeholder="Lokasi" name="lokasi"
                            value="{{$kegiatan -> lokasi ?? old('lokasi')}}" readonly>
                        @error('lokasi') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="peserta" class="form-label">Peserta</label>
                    <div class="form-input">
                        <input type="text" class="form-control
@error('peserta') is-invalid @enderror" id="peserta" placeholder="Peserta" name="peserta"
                            value="{{$kegiatan -> peserta ?? old('peserta')}}" readonly>
                        @error('peserta') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>

                <div style="margin-top: 30px;"></div>
                <label for="">Data Tim Seaqil</label>

            </div>
            <div class="modal-footer">

                <a href="{{route('kegiatan.index')}}" class="btn
btn-primary ">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@stop
@push('js')

<script>

</script>
@endpush