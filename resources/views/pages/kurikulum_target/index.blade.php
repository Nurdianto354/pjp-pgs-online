@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Kurikulum & Target</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('kurikulum_target.index') }}">Data Kurikulum & Target</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa-solid fa-bars"></i>
                            Kelas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-tabs h-100">
                            @foreach ($listKelas as $kelas)
                                <form method="GET" action="{{ route('kurikulum_target.index') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                    <input type="hidden" name="kelas_nama" value="{{ $kelas->nama }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Helpers::getTab($kelas->id, $kelasId) ? 'active' : '' }}">
                                        {{ $kelas->nama }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            Kurikulum & Target {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                @if ($id != null)
                                    <form method="GET" action="{{ route('kurikulum_target.create') }}">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                        <button type="submit" class="btn btn-sm btn-success mx-1 text-right">
                                            <i class="far fa-edit"></i> Perbarui
                                        </button>
                                    </form>
                                @else
                                    <form method="GET" action="{{ route('kurikulum_target.create') }}">
                                        <input type="hidden" name="id" value="">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                        <button type="submit" class="btn btn-sm btn-success mr-1 text-right">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </form>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#modalImportData">
                                    <i class="fas fa-file-import"></i> Import Data
                                </button>
                                <form method="GET" action="{{ route('kurikulum_target.export_template') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa fa-download"></i> Download Template
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Karakter</th>
                                    <th>Materi</th>
                                    <th>Target</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $data->getKarakter->nama }}</td>
                                        <td>{{ $data->getMateri->nama }}</td>
                                        <td>{{ $data->target . " " . $data->getSatuan->nama }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger btn-sm delete-data" data-id="{{ $data->id }}"
                                                    data-karakter="{{ $data->getKarakter->nama }}" data-materi="{{ $data->getMateri->nama }}">
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
<div class="modal fade" id="modalImportData" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="margin-bottom: -25px;">
                    <i class="fa-solid fa-file-import"></i>
                    Import Data Kurikulum & Target {{ $kelasNama }}
                    <p class="small">Pilih file untuk memulai import data</p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('kurikulum_target.import_data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File</label>
                        <input type="file" name="file" class="form-control" required>
                        <small>file size import max 2mb</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <img src="{{ asset('assets/icon/svg/cancel.svg') }}" style="width: 20px;">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-file-arrow-up"></i>
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).on('click', '.delete-data', function(e) {
        let id   = $(this).data('id');
        let karakter = $(this).data('karakter');
        let materi = $(this).data('materi');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data kurikulum & target karakter " + karakter + " materi " + materi + " ini !",
            icon: "warning",
            showDenyButton: true,
            cancelButtonColor: "#DC3741",
            confirmButtonColor: "#007BFF",
            confirmButtonText: '<i class="fa-solid fa-check"></i> Iya',
            denyButtonText: '<i class="fa-solid fa-xmark"></i> Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type    : "DELETE",
                    url     : "{{ url('/kurikulum-target/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data kurikulum & target karakter ' + karakter + ' materi ' + materi,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data kurikulum & target karakter ' + karakter + ' materi ' + materi,
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
