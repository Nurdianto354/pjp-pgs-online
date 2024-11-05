@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Kurikulum</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active"><a href="{{ route('kurikulum.index') }}">Data Kurikulum</a></li>
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
                                <form method="GET" action="{{ route('kurikulum.index') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                    <input type="hidden" name="kelas_nama" value="{{ $kelas->nama }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Kurikulum::getTab($kelas->id, $kelasId) ? 'active' : '' }}">
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
                            <i class="fas fa-book"></i>
                            Kurikulum {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun Ajaran</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahunAjaran as $tahunAjaran)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('kurikulum.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                        <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
                                        <button type="submit" class="btn btn-outline-success col-sm text-left {{ App\Models\Kurikulum::getTab($tahunAjaran->id, $tahunAjaranId) ? 'active' : '' }}">
                                            {{ $tahunAjaran->nama }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <form method="GET" action="{{ route('kurikulum.create') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                    <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                                    <button type="submit" class="btn btn-sm btn-success mr-1 text-right">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </form>
                                <form method="GET" action="{{ route('kurikulum.create') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                    <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
                                    <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success mx-1 text-right">
                                        <i class="far fa-edit"></i> Perbarui
                                    </button>
                                </form>
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
                                    <th style="width: 5%;">No</th>
                                    <th>Karakter</th>
                                    <th>Materi</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
