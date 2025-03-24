@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="accordion" id="divisi">
                <div class="row">
                    @foreach ($listDivisi as $index => $divisi)
                        @php
                            $width = (100 / count($listDivisi)) - 1 . "%";

                            $totalMurid       = 0;
                        @endphp
                        @foreach($divisi->listKelas as $kelas)
                            @php
                                $totalMurid += $kelas->listMurid->where('status', true)->count();
                            @endphp
                        @endforeach
                        <div style="margin: 0.5%; width: {{ $width }};">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalMurid }}<sup style="font-size: 20px"> Siswa</sup></h3>
                                    <h5>{{ $divisi->nama }}</h5>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a class="small-box-footer" data-toggle="collapse" href="#{{ strtolower($divisi->nama) }}" role="button" aria-expanded="{{ $index === 0 ? "true" : "false" }}" aria-controls="{{ strtolower($divisi->nama) }}">
                                    Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach ($listDivisi as $index => $divisi)
                    <div class="collapse {{ $index === 0 ? "show" : "" }}" id="{{ strtolower($divisi->nama) }}" aria-labelledby="{{ strtolower($divisi->nama) }}" data-parent="#divisi">
                        <div class="card card-body m-0 p-0 mb-3">
                            @php
                                $number = 0;

                                $totalMurid       = 0;
                                $totalMuridMale   = 0;
                                $totalMuridFemale = 0;
                            @endphp
                            <div class="small-box m-0 p-0">
                                <div class="inner bg-success">
                                    <h6 class="font-weight-bold"><i class="fa fa-users" aria-hidden="true"></i> {{ $divisi->nama }}</h6>
                                </div>
                                <table class="table table-hover text-nowrap m-0 p-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">No</th>
                                            <th rowspan="2" class="align-middle">Kelas</th>
                                            <th colspan="3">Sensus Siswa</th>
                                        </tr>
                                        <tr>
                                            <th>Laki - Laki</th>
                                            <th>Perempuan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($divisi->listKelas as $index => $kelas)
                                            @php
                                                $totalMurid       += $kelas->listMurid->where('status', true)->count();
                                                $totalMuridMale   += $kelas->listMurid->where('jenis_kelamin', '1')->where('status', true)->count();
                                                $totalMuridFemale += $kelas->listMurid->where('jenis_kelamin', '0')->where('status', true)->count();
                                            @endphp
                                            @if ($kelas->listMurid->where('status', true)->count() > 0)
                                                <tr>
                                                    <td style="width: 5%;">{{ ++$number }}</td>
                                                    <td style="width: 35%;">{{ $kelas->nama }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', '1')->where('status', true)->count() }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', '0')->where('status', true)->count() }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('status', true)->count() }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th class="text-center" colspan="2">Total</th>
                                        <th class="text-center">{{ $totalMuridMale }}</th>
                                        <th class="text-center">{{ $totalMuridFemale }}</th>
                                        <th class="text-center">{{ $totalMurid }}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
