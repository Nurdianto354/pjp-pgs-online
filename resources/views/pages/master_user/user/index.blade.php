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
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users-cog"></i>
                            Data User
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('master_user.user.create') }}" class="btn btn-success btn-sm mb-2">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%;">No</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>
                                            @if(!empty($data->getRoleNames()))
                                                @foreach($data->getRoleNames() as $role)
                                                    <label class="badge badge-success">{{ $role }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('master_user.user.update', ['id' => $data->id]) }}" class="btn btn-success btn-sm">
                                                    <i class="far fa-edit"></i> Ubah
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger delete-data" data-id="{{ $data->id }}"
                                                    data-username="{{ $data->username }}" data-nama="{{ $data->nama }}">
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

@section('js')
<script>
    $(document).on('click', '.delete-data', function(e) {
        let id       = $(this).data('id');
        let username = $(this).data('username');
        let nama     = $(this).data('nama');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data nama "+nama+" username "+username+" ini !",
            icon: "warning",
            showDenyButton: true,
            cancelButtonColor: "#DC3741",
            confirmButtonColor: "#007BFF",
            confirmButtonText: '<i class="fa-solid fa-check"></i> Iya',
            denyButtonText: '<i class="fa-solid fa-xmark"></i> Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type    : "POST",
                    url     : "{{ url('/master-user/user/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data nama '+nama+' username '+username,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data nama '+nama+' username '+username,
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                return false;
            }
        });
    });
</script>
@endsection
