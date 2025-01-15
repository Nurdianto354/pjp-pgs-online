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
                                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
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
                            Pencapaian Target {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahun as $value)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('pencapaian_target.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
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
                                    <form method="GET" action="{{ route('pencapaian_target.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <input type="hidden" name="kelas_nama" value="{{ $kelasNama }}">
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
                            <!-- Kolom pertama: Daftar siswa -->
                            <div class="col-6 col-md-3" style="padding-right: 0px;">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center" style="height: 148px;">
                                            <th>Nama Murid</th>
                                            <th>Gender</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($listMurid) > 0)
                                            @foreach ($listMurid as $murid)
                                                <tr>
                                                    <td>{{ $murid->nama_panggilan }}</td>
                                                    <td class="text-center">{{ $murid->jenis_kelamin == 1 ? "L" : "P" }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="2">Data murid tidak ada</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Kolom kedua: Tabel Target Kurikulum -->
                            <div class="col-6 col-md-9 table-responsive" style="padding-left: 0px;">
                                <table class="table table-bordered table-striped">
                                    @if (count($listTargetKurikulum) > 0)
                                        <thead>
                                            <tr class="text-center">
                                                @php
                                                    $colspan = 0;
                                                    $karakterId = null;
                                                    $karakterName = null
                                                @endphp
                                                @foreach ($listTargetKurikulum as $targetKurikulum)
                                                    @if ($karakterId != $targetKurikulum->karakter_id)
                                                        @if ($karakterId != null)
                                                            <th colspan="{{ $colspan }}" class="text-nowrap">{{ $karakterName }}</th>
                                                        @endif
                                                        @php
                                                            $karakterId = $targetKurikulum->karakter_id;
                                                            $karakterName = $targetKurikulum->getKarakter->nama;
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
                                                @foreach ($listTargetKurikulum as $targetKurikulum)
                                                    <th class="text-nowrap">{{ $targetKurikulum->getMateri->nama }}</th>
                                                @endforeach
                                            </tr>
                                            <tr class="text-center">
                                                @foreach ($listTargetKurikulum as $targetKurikulum)
                                                    <th class="text-nowrap">{{ $targetKurikulum->target . " " . $targetKurikulum->getSatuan->nama }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listMurid as $murid)
                                                <tr>
                                                    @foreach ($listTargetKurikulum as $targetKurikulum)
                                                        @php
                                                            $id = $listPencapaianTarget[$murid->id][$targetKurikulum->id]['id'] ?? null;
                                                            $target = $listPencapaianTarget[$murid->id][$targetKurikulum->id]['target'] ?? null;
                                                        @endphp
                                                        <td style="padding: 5px 10px;">
                                                            <div class="form-group" style="margin: 0px;">
                                                                <input class="form-control nilai-pencapaian" min="0" type="number" placeholder="0" name="target" value="{{ $target }}"
                                                                    data-id="{{ $id }}"
                                                                    data-kelas_id="{{ $kelasId }}"
                                                                    data-murid_id="{{ $murid->id }}"
                                                                    data-kurikulum_target_detail_id="{{ $targetKurikulum->id }}"
                                                                    data-bulan="{{ $bulan }}"
                                                                    data-tahun="{{ $tahun }}"
                                                                >
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @else
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>Target kurikulum belum dibuat atau tidak ada</td>
                                            </tr>
                                        </tbody>
                                    @endif
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
<script>
    $(".nilai-pencapaian").on("change", function() {
        let id = $(this).data('id');
        let kelasId = $(this).data('kelas_id');
        let muridId = $(this).data('murid_id');
        let kurikulumTargetDetailId = $(this).data('kurikulum_target_detail_id');
        let bulan = $(this).data('bulan');
        let tahun = $(this).data('tahun');
        let target = $(this).val();

        $.ajax({
            url    : "{{ url('/pencapaian-target/store') }}",
            method : 'POST',
            data   : {
                id : id,
                kelas_id : kelasId,
                murid_id : muridId,
                kurikulum_target_detail_id : kurikulumTargetDetailId,
                target : target,
                bulan : bulan,
                tahun : tahun
            },
            success: function(response) {
                console.log('Response from server:', response);
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', error);
            }
        });
    });
</script>
@endsection
