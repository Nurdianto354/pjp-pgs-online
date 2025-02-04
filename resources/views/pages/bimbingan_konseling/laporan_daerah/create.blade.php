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
                <h1 class="m-0">Laporan Daerah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('bimbingan_konseling.laporan_daerah.index') }}">Laporan Daerah</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="#">{{ $title }} Laporan Daerah</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-user-graduate"></i>
                            {{ $title }} Laporan Daerah
                        </h3>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
