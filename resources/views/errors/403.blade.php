@extends('layouts.app')

@section('content')
<section class="content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Akses Ditolak</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center text-danger">
                            <strong>403</strong>
                        </h4>
                        <p class="text-center">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                        <p class="text-center">Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator.</p>

                        <div class="text-center mt-4">
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
