@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <!-- Profile Section -->
            <div class="col-md-3">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (empty($data->photo))
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/img/blank-profile.png')}}" alt="Foto Profil">
                            @else
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/'.$data->photo)}}" alt="Foto Profil">
                            @endif
                        </div>
                        <h3 class="profile-username text-center">{{ $data->nama }}</h3>
                        <p class="text-muted text-center">{{ $data->role }}</p>
                    </div>
                </div>
            </div>

            <!-- User Data Section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-4 col-md-8">
                                <h3 class="card-title">User Information</h3>
                            </div>
                            <div class="col-8 col-md-4 text-right">
                                <div class="btn-group">
                                    <a href="{{ route('profil.update', ['id' =>  $data->id, 'view' => 'data']) }}" class="btn btn-success">
                                        <i class="fa-regular fa-pen-to-square fa-sm"></i> Perbarui Data
                                    </a>
                                    <a href="{{ route('profil.update', ['id' =>  $data->id, 'view' => 'password']) }}" class="btn btn-warning">
                                        <i class="fa-regular fa-pen-to-square fa-sm"></i> Change Password
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="username" class="col-12 col-sm-4 col-form-label">Username</label>
                            <div class="col-12 col-sm-8">
                                <p class="form-control-plaintext">{{ $data->username }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fullName" class="col-12 col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="col-12 col-sm-8">
                                <p class="form-control-plaintext">{{ $data->nama }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-12 col-sm-4 col-form-label">No Telp</label>
                            <div class="col-12 col-sm-8">
                                <p class="form-control-plaintext">{{ !empty($data->no_telp) ? $data->no_telp : "-" }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-12 col-sm-4 col-form-label">Email</label>
                            <div class="col-12 col-sm-8">
                                <p class="form-control-plaintext">{{ $data->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-12 col-sm-4 col-form-label">Role</label>
                            <div class="col-12 col-sm-8">
                                <p class="form-control-plaintext">{{ ucfirst($data->getRoleNames()->first()) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
