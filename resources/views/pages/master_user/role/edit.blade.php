@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('master_user.role.index') }}">Data Role</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('master_user.role.set_akses', ['id' => $role->id]) }}">Set Akses</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-solid fa-user-gear"></i>
                            Set Akses Role User
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('master_user.role.store') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Masukkan Nama Role"
                                    class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Set Akses</label>

                                <div class="row">
                                    @foreach ($listPermission as $permission)
                                        <div class="col-md-4 mb-3">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="permissions[]"
                                                    value="{{ $permission->name }}"
                                                    id="switch-{{ $permission->id }}"
                                                    @if($role->permissions->contains($permission)) checked @endif>

                                                <label class="custom-control-label" for="switch-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary mr-1 btn-submit" type="submit">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                            <button class="btn btn-sm btn-warning btn-reset" type="reset">
                                <i class="fa fa-redo"></i> Reset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
