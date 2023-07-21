@extends('adminlte::page')

@section('title', 'SIKLIS')

@section('content_header')

{{-- <h1 class="m-0 text-dark">Dashboard</h1> --}}
<!--  <style>
.responsive-image {
    max-width: 100%;
    height: 20px;
    display: flex;
    justify-content: center;

}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script> -->
@stop


@section('content')
<div class="container">
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

    <h2 class="mb-4">Acara Yang Akan Datang</h2>

    <div class="row">
        @foreach ($kegiatans as $kegiatan)
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 >{{ $kegiatan->nama_kegiatan }}</h3>
                    <p class="card-text">{{ $kegiatan->tgl_mulai }}</p>
                    <a class="btn btn-outline-secondary" href="">Lihat Kegiatan</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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
                <td><button class="btn btn-outline-secondary">ok</button></td>
            </tr>    
            @endforeach
        </tbody>
    </table>      
</div>


@stop