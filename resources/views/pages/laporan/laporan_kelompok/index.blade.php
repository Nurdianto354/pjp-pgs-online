@extends('layouts.app')

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
                <h1 class="m-0">Laporan Kelompok</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('laporan.laporan_kelompok.index') }}">Laporan Kelompok</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <label>Filter Data</label>
                        <form method="GET" action="{{ route('laporan.laporan_kelompok.index') }}" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="form-group">
                                        <select name="tahun" class="form-control select2-tahun select2-success" data-placeholder="Pilih Tahun" data-dropdown-css-class="select2-success">
                                            @foreach ($listTahun as $value)
                                                <option value="{{ $value }}" @if ($tahun == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <select name="bulan" class="form-control select2-bulan select2-success" data-placeholder="Pilih Bulan" data-dropdown-css-class="select2-success">
                                            @foreach ($listBulan as $value)
                                                <option value="{{ $value }}" @if ($bulan == $value) selected @endif>{{ App\Models\MasterData\Tanggal::listBulan[$value] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                @foreach ($listDivisi as $divisi)
                    <div class="card card-success">
                        @php
                            $listKelas = App\Models\MasterData\Kelas::where([['divisi_id', $divisi->id], ['status', true]])->orderBy('level', 'ASC')->get();
                        @endphp
                        <div class="card-header text-center">
                            <h3 class="card-title">
                                <i class="fas fa-clipboard-list"></i>
                                Laporan Divisi {{ $divisi->nama }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-2">
                                    <thead class="text-nowrap">
                                        <tr class="text-center">
                                            <th rowspan="2" style="width: 10%; min-width: 120px; padding-bottom: 4.5%;">
                                                Kelas
                                            </th>
                                            <th colspan="3">Murid</th>
                                            <th colspan="4">Keterangan</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Laki - Laki</th>
                                            <th>Perempuan</th>
                                            <th>Total</th>
                                            <th>Tidak Lancar</th>
                                            <th>Kurang Lancar</th>
                                            <th>Lancar</th>
                                            <th>Sangat Lancar</th>
                                        </tr>
                                    </thead>
                                    <thead class="text-nowrap">
                                        @foreach ($listKelas as $kelas)
                                            @php
                                                $muridCount = App\Models\Murid\Murid::where([['divisi_id', $divisi->id], ['kelas_id', $kelas->id], ['status', true]])->selectRaw('
                                                    SUM(CASE WHEN jenis_kelamin = "1" THEN 1 ELSE 0 END) as female,
                                                    SUM(CASE WHEN jenis_kelamin = "0" THEN 1 ELSE 0 END) as male
                                                ')->first();

                                                $female = $muridCount->female <= 0 ? 0 : $muridCount->female;
                                                $male = $muridCount->male <= 0 ? 0 : $muridCount->male;
                                                $totalMurid  = $female + $male;

                                                $listMuridId = App\Models\Murid\Murid::where([['divisi_id', $divisi->id], ['kelas_id', $kelas->id], ['status', true]])->pluck('id')->toArray();

                                                $jadwal = App\Models\Aktivitas\Jadwal::where([['divisi_id', $divisi->id], ['status', true]])->pluck('hari');

                                                $hariLibur = App\Models\Aktivitas\HariLibur::where([['divisi_id', $divisi->id], ['bulan', $bulan], ['tahun', $tahun], ['status', true]])
                                                    ->pluck('tanggal');

                                                $listTanggal = App\Models\MasterData\Tanggal::where([['tahun', $tahun], ['bulan', $bulan], ['status', true]])
                                                    ->whereIn('hari', $jadwal)
                                                    ->whereNotIn('tanggal', $hariLibur)
                                                    ->orderBy('tanggal', 'ASC')->pluck('tanggal')->toArray();

                                                $tidakLancar = 0;
                                                $kurangLancar = 0;
                                                $lancar = 0;
                                                $sangatLancar = 0;

                                                foreach ($listMuridId as $muridId) {
                                                    $absensiCount = App\Models\Absensi\Absensi::where([['murid_id', $muridId], ['kelas_id', $kelas->id]])
                                                        ->whereIn('tanggal', $listTanggal)->selectRaw('
                                                            SUM(CASE WHEN kehadiran = "H" THEN 1 ELSE 0 END) as hadir,
                                                            SUM(CASE WHEN kehadiran IN ("I", "S") THEN 1 ELSE 0 END) as izin
                                                        ')
                                                        ->first();

                                                    $hadir = $absensiCount->hadir <= 0 ? 0 : $absensiCount->hadir;
                                                    $total = count($listTanggal);

                                                    $hadirPers  = ($hadir/$total)*100;

                                                    if ($hadirPers < 40) {
                                                        $tidakLancar++;
                                                    } elseif ($hadirPers >= 40 && $hadirPers < 60) {
                                                        $kurangLancar++;
                                                    } elseif ($hadirPers >= 60 && $hadirPers < 80) {
                                                        $lancar++;
                                                    } elseif ($hadirPers >= 80 && $hadirPers <= 100) {
                                                        $sangatLancar++;
                                                    }
                                                }
                                            @endphp

                                            @if ($totalMurid > 0)
                                                <tr>
                                                    <td>{{ $kelas->nama }}</td>
                                                    <td class="text-center">{{ $female }}</td>
                                                    <td class="text-center">{{ $male }}</td>
                                                    <td class="text-center">{{ $totalMurid }}</td>
                                                    <td class="text-center">{{ $tidakLancar }}</td>
                                                    <td class="text-center">{{ $kurangLancar }}</td>
                                                    <td class="text-center">{{ $lancar }}</td>
                                                    <td class="text-center">{{ $sangatLancar }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-md-12">
                <div class="card card-success">
                    <div class="card-header text-center">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            Laporan Divisi BK
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($listDivisi as $divisi)
                            @php
                                $datas = App\Models\BimbinganKonseling\LaporanKelompok::where([['divisi_id', $divisi->id], ['bulan', $bulan], ['tahun', $tahun], ['status', true]])->pluck('kasus');
                            @endphp

                            @if (count($datas) > 0)
                                <span class="fs-3 text-bold">
                                    <i class="fas fa-file-signature mr-1"></i>  Divisi {{ $divisi->nama }}
                                </span>
                                <ul>
                                    @foreach ($datas as $kasus)
                                        <li class="fs-5">
                                            {{ $kasus }}
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('.select2-tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });

        $('.select2-bulan').select2({
            placeholder: "Pilih Bulan",
            allowClear: true
        });
    });
</script>
@endsection
