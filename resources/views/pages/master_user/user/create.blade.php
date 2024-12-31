@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master User</li>
                    <li class="breadcrumb-item active"><a href="{{ route('master_user.user.index') }}">Data User</a></li>
                    <li class="breadcrumb-item">{{ $title }} User</li>
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
                            {{ $title }} Data User
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master_user.user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ !empty($data) ? $data->id : NULL }}">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="{{ old('username', !empty($data) ? $data->username : NULL) }}"
                                    placeholder="Masukkan Username"
                                    class="form-control @error('username') is-invalid @enderror">

                                @error('username')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', !empty($data) ? $data->nama : NULL) }}"
                                    placeholder="Masukkan nama"
                                    class="form-control @error('nama') is-invalid @enderror">

                                @error('nama')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" value="{{ old('email', !empty($data) ? $data->email : NULL) }}"
                                            placeholder="Masukkan E-mail"
                                            class="form-control @error('email') is-invalid @enderror">

                                        @error('email')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>No Telp</label>
                                        <input type="text" name="no_telp" value="{{ old('no_telp', !empty($data) ? $data->no_telp : NULL) }}"
                                            placeholder="Masukkan No Telp" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" value="{{ old('password') }}"
                                            placeholder="Masukkan Password"
                                            class="form-control @error('password') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>Password Confirm</label>
                                        <input type="password" name="password_confirmation"
                                            value="{{ old('password_confirmation') }}"
                                            placeholder="Masukkan Konfirmasi Password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Set Role</label>
                                <br>
                                @foreach ($listRole as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            id="check-{{ $role->id }}"
                                            {{ !empty($data) ? ($data->roles->contains($role->id) ? 'checked' : '') : '' }}>
                                        <label class="form-check-label" for="check-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
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
