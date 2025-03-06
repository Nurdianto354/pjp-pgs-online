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
                <h1 class="m-0">{{ $title }} Laporan Desa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('bimbingan_konseling.laporan_desa.index') }}">Laporan Desa</a>
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
                            {{ $title }} Laporan Desa
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bimbingan_konseling.laporan_desa.store') }}" onsubmit="return validateForm()">
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
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="program" class="col-form-label">Program</label>
                                        <textarea class="form-control" placeholder="Input Program" id="program" name="program" rows="4">{{ $data->program }}</textarea>
                                    </div>
                                    <small class="form-text text-danger error-program" style="margin-top: -15px;">Harap pilih program !</small>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="kategori" class="col-form-label">Kategori</label>
                                        <select id="kategori" name="kategori" class="form-control select2-kategori select2-success" data-placeholder="Pilih Kategori" data-dropdown-css-class="select2-success">
                                            @foreach ($listKategori as $code => $kategori)
                                                <option value="{{ $code }}" @if ($data->kategori == $kategori) selected @endif>{{ $kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="form-text text-danger error-kategori" style="margin-top: -15px;">Harap pilih kategori !</small>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="realisasi" class="col-form-label">Realisasi</label>
                                        <select id="realisasi" name="realisasi" class="form-control select2-realisasi select2-success" data-placeholder="Pilih Realisasi" data-dropdown-css-class="select2-success">
                                            @foreach ($listRealisasi as $code => $realisasi)
                                                <option value="{{ $code }}" @if ($data->realisasi == $realisasi) selected @endif>{{ $realisasi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="form-text text-danger error-realisasi" style="margin-top: -15px;">Harap pilih realisasi !</small>
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

        $('.select2-kategori').select2({
            placeholder: "Pilih Kategori",
            allowClear: true
        });

        $('.select2-realisasi').select2({
            placeholder: "Pilih Realisasi",
            allowClear: true
        });

        let id = '{{ $data->id }}';

        if (id === null || id === '' || id === undefined) {
            $('.select2-kategori').val(null).trigger('change');
            $('.select2-realisasi').val(null).trigger('change');
        }

        $('.error-periode').hide();
        $('.error-program').hide();
        $('.error-kategori').hide();
        $('.error-realisasi').hide();
    });

    function validateForm() {
        let status = true;

        const fields = [
            { selector: '.select2-bulan', errorSelector: '.error-periode' },
            { selector: '.select2-tahun', errorSelector: '.error-periode' },
            { selector: '#program', errorSelector: '.error-program' },
            { selector: '.select2-kategori', errorSelector: '.error-kategori' },
            { selector: '.select2-realisasi', errorSelector: '.error-realisasi' }
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
