@extends('adminlte::page')
@section('title', 'Change Password')
@section('content_header')
<h1 class="m-0 text-dark">Change Password</h1>
@stop

@section('content')
<form method="POST" action="{{ route('user.saveChangePassword') }}">
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>    
    @endif
    @csrf
    <div class="mb-3">
        <label for="old_password" class="form-label">Old Password</label>
        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" autofocus>
        @error('old_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
        @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@stop