@extends('adminlte::page')

@section('title', 'SIKIL | Email Cofiguration')

@section('content_header')
    <h1 class="m-0">Email Configuration</h1>
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('emailConfiguration.update') }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label for="protocol" class="form-label">Protocol</label>
                        <input type="name" class="form-control @error('protocol') is-invalid @enderror" id="protocol" aria-describedby="protocol" value="{{ old('protocol', $email_configuration->protocol) }}" name="protocol" required>
                        @error('protocol')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="host" class="form-label">Host</label>
                        <input type="name" class="form-control @error('host') is-invalid @enderror" id="host" aria-describedby="host" value="{{ old('host', $email_configuration->host) }}" name="host" required>
                        @error('host')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="port" class="form-label">Port</label>
                        <input type="name" class="form-control @error('port') is-invalid @enderror" id="port" aria-describedby="port" value="{{ old('port', $email_configuration->port) }}" name="port" required>
                        @error('port')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="timeout" class="form-label">Timeout</label>
                        <input type="name" class="form-control @error('timeout') is-invalid @enderror" id="timeout" aria-describedby="timeout" value="{{ old('timeout', $email_configuration->timeout) }}" name="timeout" required>
                        @error('timeout')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="name" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="username" value="{{ old('username', $email_configuration->username) }}" name="username" required>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="name" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="email" value="{{ old('email', $email_configuration->email) }}" name="email" required>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="name" class="form-control @error('password') is-invalid @enderror" id="password" aria-describedby="password" value="{{ old('password', $email_configuration->password) }}" name="password" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
