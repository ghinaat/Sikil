<div class="card-header p-2">
    <ul class="nav nav-pills">
        @if (Route::currentRouteName() === 'profile.index')
            <li class="nav-item"><a class="nav-link active" href="{{ route('profile.index') }}">Data Pribadi</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('profile.index') }}">Data Pribadi</a></li>
        @endif

        @if (Route::currentRouteName() === 'keluarga.index' )
            <li class="nav-item"><a class="nav-link active" href="{{ route('keluarga.index') }}" >Keluarga</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('keluarga.index') }}" >Keluarga</a></li>
        @endif

        @if (Route::currentRouteName() === 'pendidikan.index')
            <li class="nav-item"><a class="nav-link active" href="{{ route('pendidikan.index') }}" >Pendidikan</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.index') }}" >Pendidikan</a></li>
        @endif

        @if (Route::currentRouteName() === 'penker.index')
            <li class="nav-item"><a class="nav-link active" href="{{ route('penker.index') }}" >Pengalaman Kerja</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('penker.index') }}" >Pengalaman Kerja</a></li>
        @endif

        @if (Route::currentRouteName() === 'diklat.index')
            <li class="nav-item"><a class="nav-link active" href="{{ route('diklat.index') }}" >Diklat</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('diklat.index') }}" >Diklat</a></li>
        @endif
        @if (Route::currentRouteName() === 'arsip.index')
            <li class="nav-item"><a class="nav-link active" href="{{ route('arsip.index') }}">Arsip</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('arsip.index') }}">Arsip</a></li>
        @endif
        
    </ul>
</div><!-- /.card-header -->