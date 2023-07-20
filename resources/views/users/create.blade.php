@extends('adminlte::page')
@section('title', 'Tambah Jabatan')
@section('content_header')
<h1 class="m-0 text-dark">Tambah Jabatan</h1>
@stop
@section('content')
<form action="{{ route('user.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" name="email" id="exampleInputEmail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" name="password" id="exampleInputPassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputlevel">Level</label>
                        <select class="form-control @error('level') isinvalid @enderror" id="exampleInputlevel"
                            name="level">
                            <option value="admin" @if(old('level')=='admin' )selected @endif>Admin</option>
                            <option value="kadiv" @if(old('level')=='kadiv' )selected @endif>Kadiv</option>
                            <option value="dda" @if(old('level')=='dda' )selected @endif>DDA</option>
                            <option value="ddo" @if(old('level')=='ddo' )selected @endif>DDO</option>
                            <option value="staff" @if(old('level')=='staff' )selected @endif>STAFF</option>
                        </select>
                        @error('level') <span class="textdanger">{{$message}}</span> @enderror
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