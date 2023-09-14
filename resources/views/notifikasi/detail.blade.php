@extends('adminlte::page')

@section('title', 'SI-MASE | Notifikasi Detail')

@section('content_header')
    <h1 class="m-0">Notifikasi Detail</h1>

    <style>

        .main-profile .col-md-3 img{
            width: 100%;
        }

    </style>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <a href="{{ route('notifikasi.index') }}" class="btn btn-outline-secondary">Back</a>
                    <h1 class="mt-5">{{ $notifikasi->judul }}</h1>
                    {!! $notifikasi->pesan !!}
                    <br>
                    <br>
                        <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <a href="{{ $notifikasi->link }}" class="btn btn-primary w-100">Lihat Link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
