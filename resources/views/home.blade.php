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
{{-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100"
                                src="/img/Premium Vector _ Sunset landscape of bali with temple and lake.jpg"
                                alt="First slide" class='responsive-image'>

                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="/img/Premium Vector _ Summer vacation concept on blue background.jpg"
                                alt="Second slide" class='responsive-image'>


                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"
                                src="/img/Sea Mountain Temple Beratan Lake Bedugul Bali Landscape View Illustration.jpg"
                                alt="Third slide" class='responsive-image'>

                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div> --}}
<div class="container">
    <h1 class="mb-4">Acara Terkini</h1>

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