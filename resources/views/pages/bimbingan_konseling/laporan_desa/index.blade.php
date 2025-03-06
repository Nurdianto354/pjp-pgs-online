@extends('layouts.app')
@php
use App\Models\MasterData\Tanggal;
@endphp
@section('content')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-dropdown {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Desa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item active"><a href="{{ route('bimbingan_konseling.laporan_desa.index') }}">Laporan Desa</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-user-graduate"></i>
                            Laporan Desa
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <form method="GET" action="{{ route('bimbingan_konseling.laporan_desa.index') }}">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="tahun">
                                                    @foreach ($listTahun as $value)
                                                        <option value="{{ $value }}" @if ($value == $tahun) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <select class="form-control" name="bulan">
                                                    @foreach ($listBulan as $value)
                                                        <option value="{{ $value }}" @if ($value == $bulan) selected @endif>{{ Tanggal::listBulan[$value] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <button type="submit" class="btn btn-success btn-sm mb-2"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-md-6 d-flex justify-content-end">
                                <a href="{{ route('bimbingan_konseling.laporan_desa.create') }}">
                                    <button type="button" class="btn btn-success btn-sm mb-2">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </a>
                                <form method="GET" action="{{ route('bimbingan_konseling.laporan_desa.export_excel') }}">
                                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa fa-download"></i> Export Excel
                                    </button>
                                </form>
                                <form method="GET" action="#">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa-regular fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTables" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 5%;">No</th>
                                        <th>Program</th>
                                        <th>Periode</th>
                                        <th>Kategori</th>
                                        <th>Realisasi</th>
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
                                            <td style="width: 30%;">{{ $data->program }}</td>
                                            <td class="text-center">{{ Tanggal::listBulan[$data->bulan] . " " . $data->tahun }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    {{ $listKategori[$data->kategori] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    if ($data->realisasi == 0) {
                                                        $badgeColor = "badge-info";
                                                    } else if ($data->realisasi == 1) {
                                                        $badgeColor = "badge-warning";
                                                    } else {
                                                        $badgeColor = "badge-success";
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeColor }}">
                                                    {{ $listRealisasi[$data->realisasi] }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $data->createdBy->nama }}</td>
                                            <td>{{ $data->updatedBy->nama }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('bimbingan_konseling.laporan_desa.create', $data->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="far fa-edit"></i> Ubah
                                                    </a>
                                                    @if ($data->status == 1)
                                                        <button type="button" class="btn btn-danger btn-sm delete-data"
                                                            data-id="{{ $data->id }}"
                                                            data-tahun="{{ $data->tahun }}"
                                                            data-bulan="{{ Tanggal::listBulan[$data->bulan] }}"
                                                            data-program="{{ $data->program }}"
                                                        >
                                                            <i class="far fa-trash-alt"></i> Hapus
                                                        </button>
                                                    @endif
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
    </div>
</section>
@endsection
@section('js')
<script>
    $(document).on('click', '.delete-data', function(e) {
        let id   = $(this).data('id');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');
        let program = $(this).data('program');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data laporan desa periode "+bulan+" "+tahun+" program "+program+" ini !",
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
                    url     : "{{ url('/bimbingan-konseling/laporan-desa/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data laporan desa periode '+bulan+' '+tahun+' program '+program,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data laporan desa periode '+bulan+' '+tahun+' program '+program,
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
