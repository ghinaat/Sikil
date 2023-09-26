<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIKLIS | Login</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('style/login.css') }}" rel="stylesheet">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="icon" type="image/x-icon" href="{{ asset('/favicons/favicon.ico') }}">

</head>

<body>
    <div id="app">
        <main>
            <div class="body d-md-flex  justify-content-between">

                <!--kiri-->

                <div class="box-1 mt-md-0 mt-5">
                    <img src="https://source.unsplash.com/random/600x1000?nature" class="image" alt="Random Image">
                    <div class="text">
                        <p>"Ing Ngarso Sung Tulodo, Ing Madyo Mangun Karsa, Tut Wuri Handayani"</p>
                    </div>
                </div>

                <!--kanan-->

                <div class=" box-2 d-flex flex-column h-100">
                    <div class="mt-auto mb-auto">
                        <p class="heading mb-3 h-1 text-black">Holla!</p>
                        <p class="desc p-color-2 mb-3 text-black">Selamat datang kembali, di siklis.</p>
                        <div class="d-flex flex-column">
                            <div class="mt-5">
                                @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" >
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                            aria-label="Username" aria-describedby="basic-addon1" required autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="input-group mb-5">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Kata Sandi" aria-label="Password" aria-describedby="basic-addon1">
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <input type="submit" value="Masuk" class="btn btn-outline-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <p class="footer mb-0 mt-md-0 mt-3 text-secondary">
                            SIKLIS
                            <span class="p-color me-1">1.0</span>
                            Develop by SEAQIL's ICT Team
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
