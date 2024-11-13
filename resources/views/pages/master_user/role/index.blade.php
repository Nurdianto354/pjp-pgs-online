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
                    <li class="breadcrumb-item active"><a href="{{ route('master_user.role.index') }}">Data Role</a></li>
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
                            <i class="fas fa-users-cog"></i>
                            Data Role
                        </h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalInput" id="tambahData">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%;">No</th>
                                    <th>Role</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}" data-nama="{{ $data->nama }}">
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-data" data-id="{{ $data->id }}" data-nama="{{ $data->nama }}">
                                                    <i class="far fa-trash-alt"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
