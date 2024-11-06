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

    @media (max-width: 576px) {
        .margin-cs {
            margin-top: 0;
        }
    }

    @media (max-width: 768px) {
        .margin-cs {
            margin-top: 0;
        }
    }

</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }} Kurikulum & Target</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item"><a href="{{ route('kurikulum_target.index') }}">Data Kurikulum & Target</a></li>
                    <li class="breadcrumb-item active">{{ $title }} Kurikulum & Target</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            {{ $title }} Kurikulum & Target
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kurikulum_target.store') }}">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                            <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                            <div id="form-data">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="karakter" class="col-form-label">Karakter</label>
                                            <select name="karakter[]" class="form-control select2-karakter-1 select2-success" data-dropdown-css-class="select2-success">
                                                @foreach ($listKarakter as $karakter)
                                                    <option value="{{ $karakter->id }}">
                                                        {{ $karakter->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="materi" class="col-form-label">Materi</label>
                                            <select name="materi[]" class="form-control select2-materi-1 select2-success" data-dropdown-css-class="select2-success">
                                                @foreach ($listMateri as $materi)
                                                    <option value="{{ $materi->id }}">
                                                        {{ $materi->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <label for="target" class="col-form-label">Target</label>
                                            <input type="text" name="target[]" class="form-control" placeholder="Target">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="satuan" class="col-form-label">Satuan</label>
                                            <select name="satuan[]" class="form-control select2-satuan-1 select2-success" data-dropdown-css-class="select2-success">
                                                @foreach ($listSatuan as $satuan)
                                                    <option value="{{ $satuan->id }}">
                                                        {{ $satuan->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-1 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-success btn-block btn-sm add-form margin-cs">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-sm btn-success" type="submit">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                                </button>
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
    var index = 1;
    $(document).ready(function() {
        $('.select2-karakter-1').select2({
            placeholder: "Pilih Karater",
            allowClear: true
        });
        $('.select2-materi-1').select2({
            placeholder: "Pilih Materi",
            allowClear: true
        });
        $('.select2-satuan-1').select2({
            placeholder: "Pilih Satuan",
            allowClear: true
        });

        $('.select2-karakter-1').val(null).trigger('change');
        $('.select2-materi-1').val(null).trigger('change');
        $('.select2-satuan-1').val(null).trigger('change');
    });

    $(".add-form").on("click", function (e) {
        index += 1;
        var html = "";

        html = `
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="karakter" class="col-form-label">Karakter</label>
                        <select name="karakter[]" class="form-control select2-karakter-`+index+` select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listKarakter as $karakter)
                                <option value="{{ $karakter->id }}">
                                    {{ $karakter->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="materi" class="col-form-label">Materi</label>
                        <select name="materi[]" class="form-control select2-materi-`+index+` select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listMateri as $materi)
                                <option value="{{ $materi->id }}">
                                    {{ $materi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-2">
                    <div class="form-group">
                        <label for="target" class="col-form-label">Target</label>
                        <input type="text" name="target[]" class="form-control" placeholder="Target">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="satuan" class="col-form-label">Satuan</label>
                        <select name="satuan[]" class="form-control select2-satuan-`+index+` select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listSatuan as $satuan)
                                <option value="{{ $satuan->id }}">
                                    {{ $satuan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-1 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-success btn-block btn-sm remove-form margin-cs">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
            </div>
        `;

        $('#form-data').append(html);

        $('.select2-karakter-'+index).select2({
            placeholder: "Pilih Karater",
            allowClear: true
        });
        $('.select2-materi-'+index).select2({
            placeholder: "Pilih Materi",
            allowClear: true
        });
        $('.select2-satuan-'+index).select2({
            placeholder: "Pilih Satuan",
            allowClear: true
        });

        $('.select2-karakter-'+index).val(null).trigger('change');
        $('.select2-materi-'+index).val(null).trigger('change');
        $('.select2-satuan-'+index).val(null).trigger('change');
    });

    $(document).on("click", ".remove-form", function(e) {
        index -= 1;
        $(this).closest('.row').remove();
    });
</script>
@endsection

