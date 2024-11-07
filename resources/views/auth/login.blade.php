<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PJP PGS II Online</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
</head>

<style>
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 3px 5px rgba(0, 0, 0, .2);
        margin-bottom: 1rem;
    }
</style>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo mb-5">
            <a href="{{ route('login') }}">
                <h4 class="font-weight-bold m-0">PJP Online</h4>
                <h3 class="m-0">Pagesangan II</h3>
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <h3 class="login-box-msg font-weight-bold mb-2">Sign In</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" id="username" name="username"  value="{{ old('username') }}" required autocomplete="username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password"  name="password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row mt-1 mb-3">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label fas-6">Remember me</label>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('password.request') }}" class="fs-6">Forgot password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-success">Sign In</button>
                </form>
                <div class="col-12 col-md-12 d-flex justify-content-center mt-4">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js')}}"></script>
</body>
</html>
