<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <span class="animation__shake">PJP Online</span>
        </div>

        @include('partials.navbar')
        @include('partials.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    @include('components.js')
    @include('sweetalert::alert')
</body>
</html>
