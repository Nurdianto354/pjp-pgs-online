@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Profil</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users-cog"></i>
                            {{ $title }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profil.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ !empty($data) ? $data->id : NULL }}">
                            <input type="hidden" name="view" value="{{ !empty($view) ? $view : 'data' }}">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Password Lama</label>
                                        <input type="password" name="current_password" value="{{ old('current_password') }}"
                                            placeholder="Masukkan Password Lama"
                                            class="form-control @error('current_password') is-invalid @enderror" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input type="password" name="new_password" value="{{ old('new_password') }}"
                                            placeholder="Masukkan Password Baru"
                                            class="form-control @error('new_password') is-invalid @enderror" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Password Confirm</label>
                                        <input type="password" name="new_password_confirmation"
                                            value="{{ old('new_password_confirmation') }}"
                                            placeholder="Masukkan Konfirmasi Password" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary mr-1 btn-submit" type="submit">
                                <i class="fa-solid fa-floppy-disk"></i> Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
