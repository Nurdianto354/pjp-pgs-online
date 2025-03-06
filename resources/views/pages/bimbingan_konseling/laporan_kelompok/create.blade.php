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
                <h1 class="m-0">{{ $title }} Laporan Kelompok</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('bimbingan_konseling.laporan_kelompok.index') }}">Laporan Kelompok</a>
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
                            {{ $title }} Laporan Kelompok
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bimbingan_konseling.laporan_kelompok.store') }}" onsubmit="return validateForm()">
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
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="divisi" class="col-form-label">Divisi</label>
                                        <select id="divisi" name="divisi_id" class="form-control select2-divisi select2-success" data-placeholder="Pilih Divisi" data-dropdown-css-class="select2-success">
                                            @foreach ($listDivisi as $divisi)
                                                <option value="{{ $divisi->id }}" @if ($data->divisi_id == $divisi->id) selected @endif>{{ $divisi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="form-text text-danger error-divisi" style="margin-top: -15px;">Harap pilih divisi !</small>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="form-group">
                                        <label for="kelas" class="col-form-label">Kelas</label>
                                        <select id="kelas" name="kelas_id" class="form-control select2-kelas select2-success" data-placeholder="Pilih Kelas" data-dropdown-css-class="select2-success">
                                            <option value="" disabled>Pilih Divisi Dahulu</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-danger error-kelas" style="margin-top: -15px;">Harap pilih kelas !</small>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="kasus" class="col-form-label">Kasus</label>
                                        <textarea class="form-control" placeholder="Input Kasus" name="kasus" rows="4">{{ $data->kasus }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label>Tanggal Konseling / Bimbingan</label>
                                        <input type="date" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" class="form-control">
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

        $('.select2-divisi').select2({
            placeholder: "Pilih Divisi",
            allowClear: true
        });

        $('.select2-kelas').select2({
            placeholder: "Pilih Kelas",
            allowClear: true
        });

        let id = '{{ $data->id }}';

        if (id === null || id === '' || id === undefined) {
            $('.select2-divisi').val(null).trigger('change');
            $('.select2-kelas').val(null).trigger('change');
        } else{
            $('#divisi').change();
        }

        $('.error-periode').hide();
        $('.error-divisi').hide();
        $('.error-kelas').hide();
    });

    $('#divisi').change(function() {
        let divisiId = $(this).val();
        let kelasId = '{{ $data->kelas_id }}';

        $('#kelas').empty();
        $('#kelas').html('<option value="" disabled>Pilih Kelas</option>');

        if (divisiId) {
            $.ajax({
                url: "{{ url('/bimbingan-konseling/laporan-kelompok/get-kelas') }}",
                type: 'GET',
                data: {
                    divisi_id: divisiId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        $('#kelas').append('<option value="">Pilih Kelas</option>');

                        $.each(response, function(index, kelas) {
                            let selected = (kelas.id == kelasId) ? 'selected' : '';

                            $('#kelas').append('<option value="' + kelas.id + '" ' + selected + '>' + kelas.nama + '</option>');
                        });
                    } else {
                        $('#kelas').html('<option value="" disabled>Tidak ada kelas</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        } else {
            $('#kelas').html('<option value="" disabled>Pilih Divisi Dahulu</option>');
        }
    });

    function validateForm() {
        let status = true;

        const fields = [
            { selector: '.select2-bulan', errorSelector: '.error-periode' },
            { selector: '.select2-tahun', errorSelector: '.error-periode' },
            { selector: '.select2-divisi', errorSelector: '.error-divisi' },
            { selector: '.select2-kelas', errorSelector: '.error-kelas' }
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
