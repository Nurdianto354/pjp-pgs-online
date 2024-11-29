@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pencapaian Target</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('pencapaian_target.index') }}">Data Pencapaian Target</a></li>
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
                                <form method="GET" action="{{ route('pencapaian_target.index') }}">
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
                            Pencapaian Target {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun Ajaran</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahunAjaran as $tahunAjaran)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('pencapaian_target.index') }}">
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
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2" style="padding-right: 0px;">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center" style="height: 148px;">
                                            <th>Siswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listAnggota as $anggota)
                                            <tr>
                                                <td>{{ $anggota->nama_panggilan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-10 table-responsive" style="padding-left: 0px;">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            @php
                                                $colspan = 0;
                                                $karakterId = null;
                                                $karakterName = null
                                            @endphp

                                            @foreach ($datas as $data)
                                                @if ($karakterId != $data->karakter_id)
                                                    @if ($karakterId != null)
                                                        <th colspan="{{ $colspan }}" class="text-nowrap">{{ $karakterName }}</th>
                                                    @endif
                                                    @php
                                                        $karakterId = $data->karakter_id;
                                                        $karakterName = $data->getKarakter->nama;
                                                        $colspan = 1;
                                                    @endphp
                                                @else
                                                    @php
                                                        $colspan++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <th colspan="{{ $colspan }}" class="text-nowrap">{{ $karakterName }}</th>
                                        </tr>
                                        <tr class="text-center">
                                            @foreach ($datas as $data)
                                                <th class="text-nowrap">{{ $data->getMateri->nama }}</th>
                                            @endforeach
                                        </tr>
                                        <tr class="text-center">
                                            @foreach ($datas as $data)
                                                <th class="text-nowrap">{{ $data->target . " " . $data->getSatuan->nama }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listAnggota as $anggota)
                                            <tr>
                                                @foreach ($datas as $data)
                                                    <td style="padding: 5px 10px;">
                                                        <div class="form-group" style="margin: 0px;">
                                                            <input class="form-control" min="0" type="number" placeholder="" value="0">
                                                        </div>
                                                    </td>
                                                @endforeach
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
    </div>
</section>
@endsection
@section('js')
