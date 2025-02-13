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
            <div class="row">
                @foreach ($listDivisi as $divisi)
                    <div class="col-12 col-lg-12">
                        <div class="card">
                            <div class="card-body m-0 p-0">
                                @php
                                    $totalMurid       = 0;
                                    $totalMuridMale   = 0;
                                    $totalMuridFemale = 0;
                                @endphp
                                <div class="small-box mb-0" style="background-color: white;">
                                    <div class="inner bg-success text-center">
                                        <h4 class="font-weight-bold">{{ $divisi->nama }}</h4>
                                    </div>
                                    <table class="table table-bordered table-sm table-striped mb-0">
                                        <thead>
                                            <tr class="text-center" style="font-size: 10x;">
                                                <th>Kelas</th>
                                                <th>Jumlah Siswa</th>
                                                <th>Laki-laki</th>
                                                <th>Perempuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($divisi->listKelas as $kelas)
                                                @php
                                                    $totalMurid       += $kelas->listMurid->where('status', true)->count();
                                                    $totalMuridMale   += $kelas->listMurid->where('jenis_kelamin', '1')->where('status', true)->count();
                                                    $totalMuridFemale += $kelas->listMurid->where('jenis_kelamin', '0')->where('status', true)->count();
                                                @endphp
                                                <tr>
                                                    <td style="width: 40%;">{{ $kelas->nama }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('status', true)->count() }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', '1')->where('status', true)->count() }}</td>
                                                    <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', '0')->where('status', true)->count() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">{{ $totalMurid }}</th>
                                            <th class="text-center">{{ $totalMuridMale }}</th>
                                            <th class="text-center">{{ $totalMuridFemale }}</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
