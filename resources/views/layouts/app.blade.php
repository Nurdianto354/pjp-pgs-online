<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        @include('partials.navbar')
        @include('partials.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    @include('components.js')
</body>
</html>
