@extends('layouts.app')

@section('content')
<style>
    .modal-header {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .modal-title {
        margin: 0;
        text-align: center;
        flex-grow: 1;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Rekap Absensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('rekap_absensi.index') }}">Data Rekap Absensi</a></li>
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
                                <form method="GET" action="{{ route('rekap_absensi.index') }}">
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
                            Rekap Absensi {{ $divisiNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <label>Tahun</label>
                        <ul class="nav mt-2">
                            @foreach ($listTahun as $value)
                                <li class="nav-item mx-1">
                                    <form method="GET" action="{{ route('rekap_absensi.index') }}">
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
                                    <form method="GET" action="{{ route('rekap_absensi.index') }}">
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
                        @foreach ($listKelas as $kelas)
                            @php
                                $listMurid = App\Models\Murid\Murid::where([['kelas_id', $kelas->id], ['status', true]])
                                    ->orderBy('jenis_kelamin', 'DESC')->orderBy('nama_lengkap', 'ASC')
                                    ->get();
                            @endphp

                            @if (count($listMurid) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="7" style="font-size: 16px;">{{ $kelas->nama }}</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th style="width: 25%;">Murid</th>
                                                <th style="width: 5%;">Gander</th>
                                                <th>Hadir</th>
                                                <th>Izin</th>
                                                <th>Alfa</th>
                                                <th>Total</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listMurid as $index => $murid)
                                                @php
                                                    $jadwal = App\Models\Aktivitas\Jadwal::where([['divisi_id', $divisiId], ['status', true]])
                                                        ->pluck('hari');

                                                    $hariLibur = App\Models\Aktivitas\HariLibur::where([['divisi_id', $divisiId], ['status', true]])
                                                        ->pluck('tanggal');

                                                    $listTanggal = App\Models\MasterData\Tanggal::where([['tahun', $tahun], ['bulan', $bulan], ['status', true]])
                                                        ->whereIn('hari', $jadwal)
                                                        ->whereNotIn('tanggal', $hariLibur)
                                                        ->orderBy('tanggal', 'ASC')->pluck('tanggal')->toArray();

                                                    $listAbsensi = App\Models\Absensi\Absensi::where([['murid_id', $murid->id], ['kelas_id', $kelas->id]])
                                                        ->whereIn('tanggal', $listTanggal);

                                                    $absensiCount = $listAbsensi->selectRaw('
                                                            SUM(CASE WHEN kehadiran = "H" THEN 1 ELSE 0 END) as hadir,
                                                            SUM(CASE WHEN kehadiran IN ("I", "S") THEN 1 ELSE 0 END) as izin,
                                                            SUM(CASE WHEN kehadiran = "A" THEN 1 ELSE 0 END) as alfa
                                                        ')
                                                        ->first();

                                                    $hadir = $absensiCount->hadir <= 0 ? 0 : $absensiCount->hadir;
                                                    $izin  = $absensiCount->izin <= 0 ? 0 : $absensiCount->izin;
                                                    $alfa  = $absensiCount->alfa <= 0 ? 0 : $absensiCount->alfa;
                                                    $total = count($listTanggal);

                                                    $hadirPers = ($hadir/$total)*100;
                                                    $keterangan = "Nilai tidak valid";

                                                    if ($hadirPers < 40) {
                                                        $keterangan = "Tidak lancar";
                                                    } elseif ($hadirPers >= 40 && $hadirPers < 60) {
                                                        $keterangan = "Kurang lancar";
                                                    } elseif ($hadirPers >= 60 && $hadirPers < 80) {
                                                        $keterangan = "Lancar";
                                                    } elseif ($hadirPers >= 80 && $hadirPers <= 100) {
                                                        $keterangan = "Sangat lancar";
                                                    }
                                                @endphp
                                                <tr class="text-center">
                                                    <td class="text-left">
                                                        <button type="button" class="btn btn-link get-detail"
                                                            data-toggle="modal"
                                                            data-target="#staticBackdrop"
                                                            data-id = "{{ $murid->id }}"
                                                            data-nama_lengkap = "{{ $murid->nama_lengkap }}"
                                                            data-kelas_id = "{{ $murid->kelas_id }}"
                                                            data-kelas_nama = "{{ $kelas->nama }}"
                                                            data-divisi_id = "{{ $murid->divisi_id }}"
                                                        >
                                                            {{ $murid->nama_panggilan }}
                                                        </button>
                                                    </td>
                                                    <td>{{ $murid->jenis_kelamin == 0 ? "P" : "L" }}</td>
                                                    <td>{{ $hadir }}</td>
                                                    <td>{{ $izin }}</td>
                                                    <td>{{ $alfa }}</td>
                                                    <td>{{ $total }}</td>
                                                    <td>{{ $keterangan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="overlay loading">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 100px; height: 100px; margin: 25% 0;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 text-center">
                        <h3 class="text-bold" id="namaLengkap"></h3>
                    </div>
                    <div class="col-12 col-md-12 text-center">
                        <h4 id="kelasNama"></h4>
                    </div>
                    <div class="col-12 col-md-12">
                        <div id="dataDetail"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('.loading').hide();
    });

    $(document).on("click", ".get-detail", function () {
        $('.loading').show();

        let id = $(this).data('id');
        let namaLengkap = $(this).data('nama_lengkap');
        let kelasId = $(this).data('kelas_id');
        let kelasNama = $(this).data('kelas_nama');
        let divisiId = $(this).data('divisi_id');

        $('#namaLengkap').text(namaLengkap);
        $('#kelasNama').text(kelasNama);

        $.ajax({
            type : "GET",
            url  : "{{ url('/rekap-absensi/detail') }}",
            data : {
                id: id,
                kelas_id: kelasId,
                divisi_id: divisiId
            },
            dataType: 'json',
            success: function(responses) {
                $('.loading').hide();

                // Clear the div before appending new data
                $('#dataDetail').empty();

                // Check if data is not empty
                if (responses.datas && Object.keys(responses.datas).length > 0) {
                    // Start the table structure
                    let table = '<table class="table table-bordered table-striped mt-3">';
                    table += '<thead><tr class="text-center">';
                    table += '<th>Bulan</th>';
                    table += '<th class="text-center">H</th>';
                    table += '<th class="text-center">I</th>';
                    table += '<th class="text-center">A</th>';
                    table += '<th class="text-center">%</th>';
                    table += '<th>Keterangan</th>';
                    table += '</tr></thead>';
                    table += '<tbody>';

                    // Loop through the data and append rows
                    for (const key in responses.datas) {
                        if (responses.datas.hasOwnProperty(key)) {
                            let data = responses.datas[key];
                            let row = '';

                            row += '<tr>';
                            row += '<td>' + data.bulan + ' ' + data.tahun + '</td>';
                            row += '<td class="text-center">' + data.hadir + '</td>';
                            row += '<td class="text-center">' + data.izin + '</td>';
                            row += '<td class="text-center">' + data.alfa + '</td>';
                            row += '<td class="text-center">' + data.pers + '%</td>';
                            row += '<td>' + data.ket + '</td>';
                            row += '</tr>';

                            table += row;
                        }
                    }

                    table += '</tbody></table>';

                    // Append the table to the div
                    $('#dataDetail').html(table);
                } else {
                    // If no data, show a message
                    $('#dataDetail').html('<p>No data available</p>');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', status, error);
                $('#dataDetail').html('<p>Error fetching data.</p>');
            }
        });
    });
</script>
@endsection
