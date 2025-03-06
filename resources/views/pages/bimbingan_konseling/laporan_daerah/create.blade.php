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

    .margin-cs {
        margin-top: 21%;
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }} Laporan Daerah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('bimbingan_konseling.laporan_daerah.index') }}">Laporan Daerah</a>
                    </li>
                    <li class="breadcrumb-item">{{ $title }}</li>
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
                        <form method="POST" action="{{ route('bimbingan_konseling.laporan_daerah.store') }}" onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <label for="periode" class="col-form-label">Periode</label>
                                </div>
                                <div class="col-6 col-md-8">
                                    <div class="form-group">
                                        <select name="bulan" class="form-control select2-bulan select2-success" data-placeholder="Pilih Bulan" data-dropdown-css-class="select2-success">
                                            @foreach ($listBulan as $code => $value)
                                                <option value="{{ $code }}" @if ($bulan == $code) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="form-group">
                                        <select name="tahun" class="form-control select2-tahun select2-success" data-placeholder="Pilih Tahun" data-dropdown-css-class="select2-success">
                                            @foreach ($listTahun as $value)
                                                <option value="{{ $value }}" @if ($tahun == $value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <small class="form-text text-danger error-periode" style="margin-top: -15px;">Harap pilih periode !</small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama (inisial)</label>
                                        <input type="text" class="form-control" placeholder="Input inisial nama" id="nama" name="nama" value="{{ $data->nama }}">
                                    </div>
                                    <small class="form-text text-danger error-nama" style="margin-top: -15px;">Nama tidak boleh kosong !</small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="usia">Usia</label>
                                        <div class="row">
                                            <div class="col-8 col-md-10">
                                                <input type="number" min="0" max="99" class="form-control" placeholder="Input usia" id="usia" name="usia" value="{{ $data->usia }}">
                                            </div>
                                            <div class="col-4 col-md-2 d-flex justify-content-center align-items-center">
                                                Tahun
                                            </div>
                                        </div>
                                    </div>
                                    <small class="form-text text-danger error-usia" style="margin-top: -15px;">Usia tidak boleh kosong !</small>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="masalah" class="col-form-label">Masalah</label>
                                        <textarea class="form-control" placeholder="Input Masalah" id="masalah" name="masalah" rows="4">{{ $data->masalah }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="penyelesaian" class="col-form-label">Penyelesaian</label>
                                        <textarea class="form-control" placeholder="Input Penyelesaian" id="penyelesaian" name="penyelesaian" rows="4">{{ $data->penyelesaian }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="kondisi_terakhir" class="col-form-label">Kondisi Terakhir</label>
                                        <textarea class="form-control" placeholder="Input Kondisi Terakhir" id="kondisiTerakhir" name="kondisi_terakhir" rows="4">{{ $data->kondisi_terakhir }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 d-flex justify-content-end">
                                <button id="submitButton" class="btn btn-sm btn-success" type="submit">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span id="buttonText">{{ $title == "Create" ? "Simpan" : $title }}</span>
                                    <span id="spinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="overlay" style="display: none;">
                                <div class="loading-img">
                                    <i class="fa fa-spinner fa-spin" style="font-size: 50px;"></i>
                                </div>
                            </div>
                        </form>
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
        $('.loading').hide();

        $('.select2-bulan').select2({
            placeholder: "Pilih Bulan",
            allowClear: true
        });

        $('.select2-tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });

        $('.error-periode').hide();
        $('.error-program').hide();
        $('.error-nama').hide();
        $('.error-usia').hide();
    });

    function validateForm() {
        let status = true;

        const fields = [
            { selector: '.select2-bulan', errorSelector: '.error-periode' },
            { selector: '.select2-tahun', errorSelector: '.error-periode' },
            { selector: '#nama', errorSelector: '.error-nama' },
            { selector: '#usia', errorSelector: '.error-usia' },
        ];

        fields.forEach(field => {
            const value = $(field.selector).val();

            if (value === null || value === '') {
                $(field.errorSelector).show();
                status = false;
            } else {
                $(field.errorSelector).hide();
            }
        });

        return status;
    }

    // Form submission handling
    $('form').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();

            return false;
        }

        let $button = $('#submitButton');
        let $spinner = $('#spinner');
        let $buttonText = $('#buttonText');

        $button.prop('disabled', true);
        $spinner.show();
        $buttonText.hide();
    });
</script>
@endsection
