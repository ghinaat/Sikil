<div class="card-header p-2">
    <ul class="nav nav-pills">
        @if (Route::currentRouteName() === 'user.showAdmin')
            <li class="nav-item"><a class="nav-link active" href="{{ route('user.showAdmin', $id_users) }}">Data Pribadi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('keluarga.showAdmin', $id_users) }}" >Keluarga</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.showAdmin', $id_users) }}" >Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('penker.showAdmin', $id_users) }}" >Pengalaman Kerja</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('diklat.showAdmin', $id_users) }}" >Diklat</a></li>
        @endif

        @if (Route::currentRouteName() === 'keluarga.showAdmin')
            <li class="nav-item"><a class="nav-link" href="{{ route('user.showAdmin', $id_users) }}">Data Pribadi</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('keluarga.showAdmin', $id_users) }}" >Keluarga</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.showAdmin', $id_users) }}" >Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('penker.showAdmin', $id_users) }}" >Pengalaman Kerja</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('diklat.showAdmin', $id_users) }}" >Diklat</a></li>
        @endif

        @if (Route::currentRouteName() === 'pendidikan.showAdmin')
            <li class="nav-item"><a class="nav-link" href="{{ route('user.showAdmin', $id_users) }}">Data Pribadi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('keluarga.showAdmin', $id_users) }}" >Keluarga</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('pendidikan.showAdmin', $id_users) }}" >Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('penker.showAdmin', $id_users) }}" >Pengalaman Kerja</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('diklat.showAdmin', $id_users) }}" >Diklat</a></li>
        @endif

        @if (Route::currentRouteName() === 'penker.showAdmin')
            <li class="nav-item"><a class="nav-link" href="{{ route('user.showAdmin', $id_users) }}">Data Pribadi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('keluarga.showAdmin', $id_users) }}" >Keluarga</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.showAdmin', $id_users) }}" >Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('penker.showAdmin', $id_users) }}" >Pengalaman Kerja</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('diklat.showAdmin', $id_users) }}" >Diklat</a></li>
        @endif

        @if (Route::currentRouteName() === 'diklat.showAdmin')
            <li class="nav-item"><a class="nav-link" href="{{ route('user.showAdmin', $id_users) }}">Data Pribadi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('keluarga.showAdmin', $id_users) }}" >Keluarga</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('pendidikan.showAdmin', $id_users) }}" >Pendidikan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('penker.showAdmin', $id_users) }}" >Pengalaman Kerja</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('diklat.showAdmin', $id_users) }}" >Diklat</a></li>
        @endif

        <li class="nav-item"><a class="nav-link" href="{{ route('profile.pdfAdmin', $id_users) }}" >Unduh CV</a></li>
    </ul>
</div><!-- /.card-header -->