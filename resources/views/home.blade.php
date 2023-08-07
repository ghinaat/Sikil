@extends('adminlte::page')

@section('title', 'SIKLIS')

@section('content_header')

<style>
    @media(max-width:512px){
        .header-text-home{
            font-size: 24px;
        }
    }
</style>

@stop



@section('content')
<div class="container" style="overflow:scroll; height:90vh;">

    <hr>

    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>44</h3>
                    <p>Staff Hadir</p>
                </div>
                <div class="icon"><i class="fas fa-user"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>Staff Ijin</p>
                </div>
                <div class="icon"><i class="fas fa-plane-departure"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>44</h3>
                    <p>Staff Sakit</p>
                </div>
                <div class="icon"><i class="fas fa-head-side-cough"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                    <h3 >{{ $kegiatan->nama_kegiatan }}</h3>
                    <p class="card-text">Tanggal Mulai : {{ date_format( new DateTime($kegiatan->tgl_mulai), 'd F Y')}} &nbsp; &nbsp;  Tanggal Selesai : {{ date_format( new DateTime($kegiatan->tgl_selesai), 'd F Y')}} <br> Lokasi : {{ $kegiatan->lokasi }}</p>
                    <a class="btn btn-outline-dark" href="{{ route('kegiatan.show', $kegiatan->id_kegiatan) }}">Lihat Kegiatan</a>
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
            @foreach ($all_kegiatan as $kegiatan)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ $kegiatan->tgl_mulai }}</td>
                <td>{{ $kegiatan->tgl_selesai }}</td>
                <td><a href="{{ route('kegiatan.show', $kegiatan->id_kegiatan) }}" class="btn btn-outline-secondary">Lihat</a></td>
            </tr>    
            @endforeach
        </tbody>
    </table>      
</div>


@stop