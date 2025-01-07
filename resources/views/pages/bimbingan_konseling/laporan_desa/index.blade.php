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
                <h1 class="m-0">Laporan Desa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Bimbingan Konseling</li>
                    <li class="breadcrumb-item active"><a href="{{ route('bimbingan_konseling.laporan_desa.index') }}">Laporan Desa</a></li>
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
                            Laporan Desa
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalInput" id="tambahData">
                                    <i class="fa fa-plus"></i> Tambah
                                </button>
                                <form method="GET" action="#">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa-regular fa-file-excel"></i> Export Excel
                                    </button>
                                </form>
                                <form method="GET" action="#">
                                    <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                        <i class="fa-regular fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%;">No</th>
                                    <th>Program</th>
                                    <th>Periode</th>
                                    <th>Kategori</th>
                                    <th>Realisasi</th>
                                    <th>Status</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td style="width: 30%;">{{ $data->program }}</td>
                                        <td class="text-center">{{ App\Models\MasterData\Tanggal::listBulan[$data->bulan] . " " . $data->tahun }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                {{ App\Models\BimbinganKonseling\LaporanDesa::listKategori[$data->kategori] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                if ($data->realisasi == 0) {
                                                    $badgeColor = "badge-info";
                                                } else if ($data->realisasi == 1) {
                                                    $badgeColor = "badge-warning";
                                                } else {
                                                    $badgeColor = "badge-success";
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeColor }}">
                                                {{ App\Models\BimbinganKonseling\LaporanDesa::listRealisasi[$data->realisasi] }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $data->createdBy->nama }}</td>
                                        <td>{{ $data->updatedBy->nama }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}"
                                                    data-program="{{ $data->program }}"
                                                    data-tahun="{{ $data->tahun }}"
                                                    data-bulan="{{ $data->bulan }}"
                                                    data-kategori="{{ $data->kategori }}"
                                                    data-realisasi="{{ $data->realisasi }}"
                                                >
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                @if ($data->status == 1)
                                                    <button type="button" class="btn btn-danger btn-sm delete-data"
                                                        data-id="{{ $data->id }}"
                                                        data-tahun="{{ $data->tahun }}"
                                                        data-bulan="{{ App\Models\MasterData\Tanggal::listBulan[$data->bulan] }}"
                                                        data-program="{{ $data->program }}"
                                                    >
                                                        <i class="far fa-trash-alt"></i> Hapus
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal hide fade in" data-keyboard="false" data-backdrop="static" id="modalInput">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="overlay loading">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 100px; height: 100px; margin: 25% 0;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title"><span id="title"></span> Laporan Desa</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('bimbingan_konseling.laporan_desa.create')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label>Periode</label>
                        <div class="row">
                            <div class="col-8 col-md-8">
                                <select name="bulan" class="form-control select2-bulan select2-success" data-dropdown-css-class="select2-success">
                                    @foreach ($listBulan as $code => $bulan)
                                        <option value="{{ $code }}">
                                            {{ $bulan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 col-md-4">
                                <select name="tahun" class="form-control select2-tahun select2-success" data-dropdown-css-class="select2-success">
                                    @foreach ($listTahun as $code => $tahun)
                                        <option value="{{ $code }}">
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <small class="form-text text-danger error-periode" style="margin-top: -15px;">Harap pilih bulan dan tahun !</small>
                    <div class="form-group">
                        <label>Program</label>
                        <textarea class="form-control" placeholder="Input Program" id="program" name="program"></textarea>
                    </div>
                    <small class="form-text text-danger error-program" style="margin-top: -15px;">Harap pilih program !</small>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control select2-kategori select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listKategori as $code => $kategori)
                                <option value="{{ $code }}">
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="form-text text-danger error-kategori" style="margin-top: -15px;">Harap pilih kategori !</small>
                    <div class="form-group">
                        <label>Realisasi</label>
                        <select name="realisasi" class="form-control select2-realisasi select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listRealisasi as $code => $realisasi)
                                <option value="{{ $code }}">
                                    {{ $realisasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="form-text text-danger error-realisasi" style="margin-top: -15px;">Harap pilih realisasi !</small>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mb-2 mr-sm-2" data-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2" id="btnSave"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('.select2-tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });

        $('.select2-bulan').select2({
            placeholder: "Pilih Bulan",
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

        $('.loading').hide();

        $('.error-periode').hide();
        $('.error-program').hide();
        $('.error-kategori').hide();
        $('.error-realisasi').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '.select2-bulan', errorSelector: '.error-periode' },
            { selector: '.select2-tahun', errorSelector: '.error-periode' },
            { selector: '#program', errorSelector: '.error-program' },
            { selector: '.select2-kategori', errorSelector: '.error-kategori' },
            { selector: '.select2-realisasi', errorSelector: '.error-realisasi' },
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

        if (!status) {
            $('.loading').hide();
        }

        return status;
    }

    $('#tambahData').on('click', function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Tambah');
        $('#title').text('Tambah');

        $('#id').val('');
        $('#program').val('');
        $('.select2-tahun').val(null).trigger('change');
        $('.select2-bulan').val(null).trigger('change');
        $('.select2-kategori').val(null).trigger('change');
        $('.select2-realisasi').val(null).trigger('change');

        $('.error-periode').hide();
        $('.error-program').hide();
        $('.error-kategori').hide();
        $('.error-realisasi').hide();
    });

    $(document).on("click", ".update-data", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        let id = $(this).data('id');
        let program = $(this).data('program');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');
        let kategori = $(this).data('kategori');
        let realisasi = $(this).data('realisasi');

        $('#id').val(id);
        $('#program').val(program);
        $('.select2-tahun').val(tahun).trigger('change');
        $('.select2-bulan').val(bulan).trigger('change');
        $('.select2-kategori').val(kategori).trigger('change');
        $('.select2-realisasi').val(realisasi).trigger('change');

        $('.error-periode').hide();
        $('.error-program').hide();
        $('.error-kategori').hide();
        $('.error-realisasi').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id   = $(this).data('id');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');
        let program = $(this).data('program');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data laporan desa periode "+bulan+" "+tahun+" program "+program+" ini !",
            icon: "warning",
            showDenyButton: true,
            cancelButtonColor: "#DC3741",
            confirmButtonColor: "#007BFF",
            confirmButtonText: '<i class="fa-solid fa-check"></i> Iya',
            denyButtonText: '<i class="fa-solid fa-xmark"></i> Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type    : "POST",
                    url     : "{{ url('/bimbingan-konseling/laporan-desa/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data laporan desa periode '+bulan+' '+tahun+' program '+program,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data laporan desa periode '+bulan+' '+tahun+' program '+program,
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                return false;
            }
        });
    });
</script>
@endsection
