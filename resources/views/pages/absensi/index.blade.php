@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Absensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('absensi.index') }}">Data Absensi</a></li>
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
                                <form method="GET" action="{{ route('absensi.index') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Absensi\Absensi::getTab($kelas->id, $kelasId) ? 'active' : '' }}">
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
                            Absensi {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahun as $value)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('absensi.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                        <input type="hidden" name="tahun" value="{{ $value }}">
                                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success text-left {{ App\Models\Absensi\Absensi::getTab($value, $tahun) ? 'active' : '' }}">
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
                                    <form method="GET" action="{{ route('absensi.index') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                                        <input type="hidden" name="bulan" value="{{ $value }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success text-left {{ App\Models\Absensi\Absensi::getTab($value, $bulan) ? 'active' : '' }}">
                                            {{ App\Models\MasterData\Tanggal::listBulan[$value] }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 col-md-3" style="padding-right: 0px;">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Siswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($listMurid) > 0)
                                            @foreach ($listMurid as $murid)
                                                <tr>
                                                    <td>{{ $murid->nama_panggilan }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td>Data murid tidak ada</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-9 col-md-9 table-responsive" style="padding-left: 0px;">
                                <table class="table table-bordered table-striped">
                                    @if (count($listTanggal) > 0)
                                        <thead>
                                            <tr class="text-center">
                                                @foreach ($listTanggal as $data)
                                                    <th class="text-nowrap">{{ date('d-m-Y', $data->tanggal) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listMurid as $murid)
                                                <tr>
                                                    @foreach ($listTanggal as $data)
                                                        @php
                                                            $id        = $datas[$murid->id][$data->tanggal]['id'] ?? null;
                                                            $kehadiran = $datas[$murid->id][$data->tanggal]['kehadiran'] ?? null;
                                                        @endphp
                                                        <td style="padding: 5px 2px;">
                                                            <div class="form-group" style="margin: 0px;">
                                                                <select class="form-control absensi" name="kehadiran"
                                                                    data-id="{{ $id }}"
                                                                    data-kelas_id="{{ $kelasId }}"
                                                                    data-murid_id="{{ $murid->id }}"
                                                                    data-tanggal="{{ $data->tanggal }}"
                                                                >
                                                                    <option value="" {{ $kehadiran === '' ? 'selected' : '' }}></option>
                                                                    <option value="H" {{ $kehadiran === 'H' ? 'selected' : '' }}>H</option>
                                                                    <option value="A" {{ $kehadiran === 'A' ? 'selected' : '' }}>A</option>
                                                                    <option value="I" {{ $kehadiran === 'I' ? 'selected' : '' }}>I</option>
                                                                    <option value="S" {{ $kehadiran === 'S' ? 'selected' : '' }}>S</option>
                                                                </select>
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
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>Tanggal absensi belum dibuat</td>
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
    $('.absensi').change(function(){
        let id        = $(this).data('id');
        let kelasId   = $(this).data('kelas_id');
        let muridId   = $(this).data('murid_id');
        let tanggal   = $(this).data('tanggal');
        let kehadiran = $(this).val();

        $.ajax({
            type    : "POST",
            url     : "{{ url('/absensi/store') }}",
            data    : {
                id        : id,
                kelas_id  : kelasId,
                murid_id  : muridId,
                tanggal   : tanggal,
                kehadiran : kehadiran
            },
            success: function(data) {
                if (data.success) {
                    // alert("Data has been saved successfully!");
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred while processing your request.");
            }
        });
    });
</script>
@endsection
