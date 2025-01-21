@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Daerah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('laporan.laporan_daerah.index') }}">Laporan Daerah</a>
                    </li>
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
                            Divisi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-tabs h-100">
                            @foreach ($listDivisi as $divisi)
                                <form method="GET" action="{{ route('laporan.laporan_daerah.index') }}">
                                    <input type="hidden" name="divisi_id" value="{{ $divisi->id }}">
                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Helpers::getTab($divisi->id, $divisiId) ? 'active' : '' }}">
                                        {{ $divisi->nama }}
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
                            Laporan {{ $divisiNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahun as $value)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('laporan.laporan_daerah.index') }}">
                                        <input type="hidden" name="divisi_id" value="{{ $divisiId }}">
                                        <input type="hidden" name="tahun" value="{{ $value }}">
                                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success text-left {{ App\Models\Helpers::getTab($value, $tahun) ? 'active' : '' }}">
                                            {{ $value }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <label>Bulan</label>
                        <ul class="nav mt-2">
                            @foreach ($listBulan as $value)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('laporan.laporan_daerah.index') }}">
                                        <input type="hidden" name="divisi_id" value="{{ $divisiId }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <input type="hidden" name="bulan" value="{{ $value }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success text-left {{ App\Models\Helpers::getTab($value, $bulan) ? 'active' : '' }}">
                                            {{ App\Models\MasterData\Tanggal::listBulan[$value] }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <form method="GET" action="{{ route('laporan.laporan_daerah.export_excel') }}">
                                    <input type="hidden" name="divisi_id" value="{{ $divisiId }}">
                                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa fa-download"></i> Download Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
