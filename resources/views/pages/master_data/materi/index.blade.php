@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Materi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active"><a href="{{ route('master_data.materi.index') }}">Data Materi</a></li>
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
                            <i class="fas fa-table"></i>
                            Data Materi
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
                                    <th>Materi</th>
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
                                        <td>{{ $data->nama }}</td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
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
<div class="modal hide fade in" data-keyboard="false" data-backdrop="static" id="modalInput">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="overlay loading">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 100px; height: 100px; margin: 25% 0;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title"><span id="title"></span> Data Materi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('master_data.materi.create')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label>Materi</label>
                        <input type="text" class="form-control" placeholder="Input materi" id="nama" name="nama">
                    </div>
                    <small class="form-text text-danger error-nama" style="margin-top: -15px;">Harap masukan materi !</small>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mb-2 mr-sm-2" data-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2" id="btnSave"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('.loading').hide();

        $('.error-nama').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '#nama', errorSelector: '.error-nama' },
        ];

        fields.forEach(field => {
            const value = $(field.selector).val();

            if (value === null || value === '') {
                $(field.errorSelector).show();
                status = false;
            } else {
                $(field.errorSelector).hide();
            }
        });

        if (!status) {
            $('.loading').hide();
        }

        return status;
    }

    $('#tambahData').on('click', function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Tambah');
        $('#title').text('Tambah');

        $('#id').val('');
        $('#nama').val('');

        $('.error-nama').hide();
    });

    $('.update-data').on("click", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        var id = $(this).data('id');
        var nama = $(this).data('nama');

        $('#id').val(id);
        $('#nama').val(nama);

        $('.error-nama').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id   = $(this).data('id');
        let nama = $(this).data('nama');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data materi "+nama+" ini !",
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
                    url     : "{{ url('/master-data/materi/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data materi '+nama,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data materi '+nama,
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
