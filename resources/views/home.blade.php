@extends('adminlte::page')

@section('title', 'SIKLIS | Home')

@section('content_header')

<style>
@media(max-width:512px) {
    .header-text-home {
        font-size: 24px;
    }

    h2{
        font-size: 24px;
    }

    h3{
        font-size: 20px;
    }
}
</style>

@stop

@section('content')
<div class="container" style="overflow:scroll; height:90vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $staf_dinas_luar }}</h3>
                    <p>Staff Dinas Luar</p>
                </div>
                <div class="icon"><i class="fas fa-plane-departure"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $staf_ijin }}</h3>
                    <p>Staff Ijin/Cuti</p>
                </div>
                <div class="icon"><i class="fas fa-glass-cheers"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $staf_sakit }}</h3>
                    <p>Staff Sakit</p>
                </div>
                <div class="icon"><i class="fas fa-head-side-cough"></i></div>
            </div>
        </div>
    </div>

    <hr>

    <h2 class="mb-4">Kegiatan Yang Sedang Berlangsung</h2>
    @foreach ($kegiatans as $kegiatan)
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $kegiatan->nama_kegiatan }}</h3>
                    <p class="card-text">
                        Tanggal Kegiatan:
                        @if($kegiatan->tgl_mulai === $kegiatan->tgl_selesai)
                        {{ \Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('d M Y') }}
                        @else
                        {{ \Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('d M Y') }} &nbsp; s.d. &nbsp;
                        {{ \Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('d M Y') }}
                        @endif
                        <br> Lokasi: {{ $kegiatan->lokasi }}
                    </p>

                    <a class="btn btn-primary" href="{{ route('kegiatan.show', $kegiatan->id_kegiatan) }}">Detail
                        Kegiatan</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <hr>

    <h2 class="mb-4">Acara Tahun Ini</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Kegiatan</th>
                <th scope="col">Tanggal Mulai</th>
                <th scope="col">Tanggal Selesai</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $nomor_urutan = 1;
            @endphp
            @foreach ($all_kegiatan->where('tgl_mulai', '>', now())->sortBy('tgl_mulai') as $kegiatan)
            @if ($kegiatan->tgl_mulai > now())
            <tr>
                <th scope="row">{{ $nomor_urutan }}</th>
                <td>{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($kegiatan->tgl_mulai)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($kegiatan->tgl_selesai)->format('d M Y') }}</td>
                <td><a href="{{ route('kegiatan.show', $kegiatan->id_kegiatan) }}" class="btn btn-primary">Detail</a></td>
            </tr>
            @php
                $nomor_urutan++;
            @endphp
            @endif
            @endforeach
        </tbody>
    </table>

</div>

@stop
