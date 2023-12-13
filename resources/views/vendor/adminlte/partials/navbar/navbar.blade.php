<style>
    #navbar-navbar{
        line-height: 50px;
        font-size: 25px;
        text-align: center;
    }

    #navbar-navbar-navbar{
        line-height: 50px;
        font-size: 25px;
        text-align: center;
        display: none;
    }

    @media(max-width:712px){
        #navbar-navbar{
            line-height: normal;
            font-size: 16px;
            text-align: center;
            display: none;
        }

        #navbar-navbar-navbar{
            margin-top: 8px;
            line-height: 20px;
            font-size: 20px;
            text-align: center;
            display: block;
        }
    }
</style>
<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">


    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>
    <h2 id="navbar-navbar" style="white-space: nowrap">Sistem Informasi Kepegawaian & Layanan Internal SEAQIL</h2>
    <h2 id="navbar-navbar-navbar">SIKLIS</h2>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>


</nav>
