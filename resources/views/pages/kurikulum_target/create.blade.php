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

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 9999;  /* Ensure it's above other content */
        display: none;  /* Hidden by default */
    }

    .loading-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px; /* Adjust spinner size if necessary */
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
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                            <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                            <div id="form-data">
                                <div class="row">
                                    <input type="hidden" name="id_detail[]" value="">
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
                                        <button type="button" id="add-form" class="btn btn-success btn-block btn-sm margin-cs">
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

        let id = '{{ $id }}';

        if (id != null && id != '') {
            loadDataKurikulumTarget(id);
        }
    });

    function loadDataKurikulumTarget(id)
    {
        $.ajax({
            url: '{{ route('kurikulum_target.data_detail') }}',
            type: "GET",
            data: {
                id: id,
            },
            beforeSend: function() {
                $('.overlay').show();
            },
            success: function(response) {
                if (response.datas && response.datas.length) {
                    $('#form-data').empty();

                    response.datas.forEach(function(data) {
                        getFormData(index, data);

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

                        index += 1;
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            },
            complete: function() {
                $('.overlay').hide();
            },
        });
    }

    $(document).on("click", "#add-form", function(e) {
        index += 1;

        getFormData(index, null);

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

    function getFormData(index, data) {
        var html = "";

        let id = '';
        let karakter_id = '';
        let materi_id = '';
        let satuan_id = '';
        let target = '';

        // Assign data if it exists
        if (data != null) {
            id = data.id;
            karakter_id = data.karakter_id;
            materi_id = data.materi_id;
            satuan_id = data.satuan_id;
            target = data.target;
        }

        html = `
            <div class="row">
                <input type="hidden" name="id_detail[]" value="${id}">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="karakter" class="col-form-label">Karakter</label>
                        <select name="karakter[]" class="form-control select2-karakter-${index} select2-success" data-dropdown-css-class="select2-success" id="karakter-${index}">
                            ${generateOptions('karakter', karakter_id)}
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="materi" class="col-form-label">Materi</label>
                        <select name="materi[]" class="form-control select2-materi-${index} select2-success" data-dropdown-css-class="select2-success" id="materi-${index}">
                            ${generateOptions('materi', materi_id)}
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-2">
                    <div class="form-group">
                        <label for="target" class="col-form-label">Target</label>
                        <input type="text" name="target[]" value="${target}" class="form-control" placeholder="Target">
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label for="satuan" class="col-form-label">Satuan</label>
                        <select name="satuan[]" class="form-control select2-satuan-${index} select2-success" data-dropdown-css-class="select2-success" id="satuan-${index}">
                            ${generateOptions('satuan', satuan_id)}
                        </select>
                    </div>
                </div>
        `;

        if (index === 1) {
            html += `
                    <div class="col-12 col-sm-12 col-md-1 d-flex justify-content-center align-items-center">
                        <button type="button" id="add-form" class="btn btn-success btn-block btn-sm margin-cs">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            `;
        } else {
            html += `
                    <div class="col-12 col-sm-12 col-md-1 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-success btn-block btn-sm remove-form margin-cs" ${id != '' ? 'disabled': ''}>
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </div>
                </div>
            `;
        }

        $('#form-data').append(html);
    }

    function generateOptions(type, selectedId) {
        let options = '';
        const list = getListData(type);

        list.forEach(item => {
            options += `
                <option value="${item.id}" ${item.id === selectedId ? 'selected' : ''}>
                    ${item.nama}
                </option>
            `;
        });

        return options;
    }

    // Helper function to get the list of data based on type (karakter, materi, or satuan)
    function getListData(type) {
        // Sample data - replace these with the actual data passed from your backend
        const lists = {
            'karakter': @json($listKarakter),
            'materi': @json($listMateri),
            'satuan': @json($listSatuan)
        };

        return lists[type] || [];
    }


    $(document).on("click", ".remove-form", function(e) {
        index -= 1;
        $(this).closest('.row').remove();
    });
</script>
@endsection

