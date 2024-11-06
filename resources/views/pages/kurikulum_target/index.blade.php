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
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active"><a href="{{ route('kurikulum_target.index') }}">Data Kurikulum</a></li>
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
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\KurikulumTarget\KurikulumTarget::getTab($kelas->id, $kelasId) ? 'active' : '' }}">
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
                        <label>Tahun Ajaran</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahunAjaran as $tahunAjaran)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('kurikulum_target.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
                                        <button type="submit" class="btn btn-outline-success col-sm text-left {{ App\Models\KurikulumTarget\KurikulumTarget::getTab($tahunAjaran->id, $tahunAjaranId) ? 'active' : '' }}">
                                            {{ $tahunAjaran->nama }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                @if ($id != null)
                                    <form method="GET" action="{{ route('kurikulum_target.create') }}">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                                        <button type="submit" class="btn btn-sm btn-success mx-1 text-right">
                                            <i class="far fa-edit"></i> Perbarui
                                        </button>
                                    </form>
                                @else
                                    <form method="GET" action="{{ route('kurikulum_target.create') }}">
                                        <input type="hidden" name="id" value="">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                                        <button type="submit" class="btn btn-sm btn-success mr-1 text-right">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </form>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#modalImportData">
                                    <i class="fas fa-file-import"></i> Import Data
                                </button>
                                <a href="#" class="btn btn-sm btn-outline-success ml-1">
                                    <i class="fa fa-download"></i> Download Template
                                </a>
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

    var toastMixin = Swal.mixin({
        toast: true,
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endsection
