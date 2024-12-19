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
                        <div class="small-box" style="background-color: white;">
                            <div class="inner bg-success text-center">
                                <h4 class="font-weight-bold">{{ $divisi->nama }}</h4>
                            </div>
                            <table class="table table-bordered table-sm table-striped">
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
                                        <tr>
                                            <td style="width: 40%;">{{ $kelas->nama }}</td>
                                            <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->count() }}</td>
                                            <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', 'Laki - laki')->count() }}</td>
                                            <td style="width: 20%;" class="text-center">{{ $kelas->listMurid->where('jenis_kelamin', 'Perempuan')->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
