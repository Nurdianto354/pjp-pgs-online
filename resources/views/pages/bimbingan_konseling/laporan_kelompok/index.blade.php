@extends('layouts.app')
@php
use App\Models\MasterData\Tanggal;
@endphp
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Kelompok</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item active"><a href="{{ route('bimbingan_konseling.laporan_kelompok.index') }}">Laporan Kelompok</a></li>
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
                            Laporan Kelompok
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <form method="GET" action="{{ route('bimbingan_konseling.laporan_kelompok.index') }}">
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
                                <a href="{{ route('bimbingan_konseling.laporan_kelompok.create') }}">
                                    <button type="button" class="btn btn-success btn-sm mb-2">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </a>
                                <form method="GET" action="#">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa-regular fa-file-excel"></i> Export Excel
                                    </button>
                                </form>
                                <form method="GET" action="#">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa-regular fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="text-responsive">
                            <table id="dataTables" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 5%;">No</th>
                                        <th>Divisi</th>
                                        <th>Kelas</th>
                                        <th>Periode</th>
                                        <th>Kasus</th>
                                        <th>Tanggal Konsultasi / Bimbingan</th>
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
                                            <td>{{ $data->getDivisi->nama }}</td>
                                            <td>{{ $data->getKelas->nama }}</td>
                                            <td class="text-center">{{ Tanggal::listBulan[$data->bulan] . " " . $data->tahun }}</td>
                                            <td>{!! $data->kasus !!}</td>
                                            <td class="text-center">{{ date("d-m-Y", $data->tanggal) }}</td>
                                            <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $data->createdBy->nama }}</td>
                                            <td>{{ $data->updatedBy->nama }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('bimbingan_konseling.laporan_kelompok.create', $data->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="far fa-edit"></i> Ubah
                                                    </a>
                                                    @if ($data->status == 1)
                                                        <button type="button" class="btn btn-danger btn-sm delete-data"
                                                            data-id="{{ $data->id }}"
                                                            data-tahun="{{ $data->tahun }}"
                                                            data-bulan="{{ Tanggal::listBulan[$data->bulan] }}"
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
        let id    = $(this).data('id');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data laporan bk kelompok periode "+bulan+" "+tahun+" tahun ini !",
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
                    url     : "{{ url('/bimbingan-konseling/laporan-kelompok/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data laporan bk kelompok periode '+bulan+' '+tahun+' tahun',
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data laporan bk kelompok periode '+bulan+' '+tahun+' tahun',
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
