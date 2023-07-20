@extends('adminlte::page')
@section('title', 'Tambah Jabatan')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Jabatan</h1>
@stop
@section('content')
<form action="{{route('jabatan.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_jabatan">Jabatan</label>
                        <input type="text" class="form-control
@error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" placeholder="Jabatan" name="nama_jabatan"
                            value="{{old('nama_jabatan')}}">
                        @error('nama_jabatan') <span class="textdanger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('jabatan.index')}}" class="btn
btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
    @stop