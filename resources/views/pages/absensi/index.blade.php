@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Absensi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('absensi.index') }}">Data Absensi</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa-solid fa-bars"></i>
                            Kelas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-tabs h-100">
                            @foreach ($listKelas as $kelas)
                                <form method="GET" action="{{ route('absensi.index') }}">
                                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                    <input type="hidden" name="kelas_nama" value="{{ $kelas->nama }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Absensi\Absensi::getTab($kelas->id, $kelasId) ? 'active' : '' }}">
                                        {{ $kelas->nama }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            Absensi {{ $kelasNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-sm btn-success mx-1 text-right btn-tambah"
                                        data-toggle="modal"
                                        data-target="#modalInput"
                                        data-kelas_id="{{ $kelasId }}"
                                    >
                                        <i class="fa fa-plus"></i> Tambah Tanggal {{ $kelasId }}
                                    </button>
                                    {{-- <button type="button" class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#modalImportData">
                                        <i class="fas fa-file-import"></i> Import Data
                                    </button>
                                    <form method="GET" action="{{ route('kurikulum_target.export_template') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                            <i class="fa fa-download"></i> Download Template
                                        </button>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2" style="padding-right: 0px;">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center" style="height: 20px;">
                                                <th>Aksi</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>Siswa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($listMurid) > 0)
                                                @foreach ($listMurid as $murid)
                                                    <tr>
                                                        <td>{{ $murid->nama_panggilan }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td>Data murid tidak ada</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-10 table-responsive" style="padding-left: 0px;">
                                    <table class="table table-bordered table-striped">
                                        @if (count($listAbsensi) > 0)
                                            <thead>
                                                <tr class="text-center">
                                                    @foreach ($listAbsensi as $data)
                                                        <th style="padding: 8px 0px;">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-outline-warning btn-perbarui"
                                                                    title="perbarui"
                                                                    data-toggle="modal"
                                                                    data-target="#modalInput"
                                                                    data-absensi_id="{{ $data->id }}"
                                                                    data-kelas_id="{{ $kelasId }}"
                                                                    data-tanggal="{{ date('Y-m-d', $data->tanggal) }}"
                                                                >
                                                                    <i class="far fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" title="hapus"
                                                                    data-id="{{ $data->id }}"
                                                                    data-tanggal="{{ date('d-m-Y', $data->tanggal) }}"
                                                                >
                                                                    <i class="far fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                <tr class="text-center">
                                                    @foreach ($listAbsensi as $data)
                                                        <th class="text-nowrap">{{ date('d-m-Y', $data->tanggal) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listMurid as $murid)
                                                    <tr>
                                                        @foreach ($listAbsensi as $data)
                                                            @php
                                                                $id = $listAbsensiDetail[$data->id][$murid->id]['id'] ?? null;
                                                                $absensi = $listAbsensiDetail[$data->id][$murid->id]['absensi'] ?? null;
                                                            @endphp
                                                            <td style="padding: 5px 2px;">
                                                                <div class="form-group" style="margin: 0px;">
                                                                    <select class="form-control kehadiran" name="kehadiran"
                                                                        data-id="{{ $id }}"
                                                                        data-kelas_id="{{ $kelasId }}"
                                                                        data-absensi_id="{{ $data->id }}"
                                                                        data-murid_id="{{ $murid->id }}"
                                                                    >
                                                                        <option value="" {{ $absensi === '' ? 'selected' : '' }}></option>
                                                                        <option value="H" {{ $absensi === 'H' ? 'selected' : '' }}>H</option>
                                                                        <option value="A" {{ $absensi === 'A' ? 'selected' : '' }}>A</option>
                                                                        <option value="I" {{ $absensi === 'I' ? 'selected' : '' }}>I</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>Tanggal absensi belum dibuat</td>
                                                </tr>
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal hide fade in" data-keyboard="false" data-backdrop="static" id="modalInput">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="overlay loading">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 100px; height: 100px; margin: 25% 0;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="title"></span> Tanggal Absensi <br>
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="GET" action="{{ route('absensi.add_attendance_date')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="kelasId" name="kelas_id">
                    <div class="row date-add">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" class="form-control" placeholder="Input tanggal mulai" id="tanggalMulai" name="tanggal_mulai">
                            </div>
                            <small class="form-text text-danger error-tanggal-mulai" style="margin-top: -15px;">Harap masukan tanggal mulai !</small>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" placeholder="Input tanggal akhir" id="tanggalAkhir" name="tanggal_akhir">
                            </div>
                            <small class="form-text text-danger error-tanggal-akhir" style="margin-top: -15px;">Harap masukan tanggal akhir !</small>
                        </div>
                    </div>
                    <div class="row date-update">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" placeholder="Input tanggal" id="tanggal" name="tanggal">
                            </div>
                            <small class="form-text text-danger error-tanggal" style="margin-top: -15px;">Harap masukan tanggal !</small>
                        </div>
                    </div>
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
        $('.select2-kelas').select2({
            placeholder: "Pilih Kelas",
            allowClear: true
        });

        $('.select2-kelas').val(null).trigger('change');

        $('.loading').hide();

        $('.error-tanggal-mulai').hide();
        $('.error-tanggal-akhir').hide();
        $('.error-tanggal').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;
        let id = $('#id').val();

        if (id == null || id == '') {
            const fields = [
                { selector: '#tanggalMulai', errorSelector: '.error-tanggal-mulai' },
                { selector: '#tanggalAkhir', errorSelector: '.error-tanggal-akhir' },
            ];

            fields.forEach(field => {
                const value = $(field.selector).val();

                if (value === null || value === '') {
                    $(field.errorSelector).show();
                    status = false;
                }
            });
        } else {
            const value = $('#tanggal').val();

            if (value === null || value === '') {
                $('#tanggal').show();
                status = false;
            }
        }

        if (!status) {
            $('.loading').hide();
        }

        return status;
    }

    $('.btn-tambah').on('click', function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Tambah');
        $('#title').text('Tambah');

        var kelasId = $(this).data('kelas_id');

        $('#id').val('');
        $('#kelasId').val(kelasId);
        $('#tanggalMulai').val('');
        $('#tanggalAkhir').val('');

        $('.date-add').show();
        $('.date-update').hide();
        $('.error-tanggal-mulai').hide();
        $('.error-tanggal-akhir').hide();
    });

    $('.btn-perbarui').on('click', function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Perbarui');

        var id = $(this).data('id');
        var kelasId = $(this).data('kelas_id');
        var tanggal = $(this).data('tanggal');

        $('#id').val(id);
        $('#kelasId').val(kelasId);
        $('#tanggal').val(tanggal);

        $('.date-add').hide();
        $('.date-update').show();
        $('.error-tanggal-mulai').hide();
        $('.error-tanggal-akhir').hide();
    });

    $(document).on('click', '.btn-hapus', function(e) {
        let id   = $(this).data('id');
        var tanggal = $(this).data('tanggal');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus absensi tanggal "+tanggal+" ini !",
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
                    url     : "{{ url('/absensi/delete-attendance-date') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus absensi tanggal '+tanggal,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus absensi tanggal '+tanggal,
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                return false;
            }
        });
    });

    $('.kehadiran').change(function(){
        var id = $(this).data('id');
        var kelasId = $(this).data('kelas_id');
        var absensiId = $(this).data('absensi_id');
        var anggotaId = $(this).data('murid_id');
        var absensi = $(this).val();

        $.ajax({
            type    : "POST",
            url     : "{{ url('/absensi/store') }}",
            data    : {
                id          : id,
                kelas_id    : kelasId,
                absensi_id  : absensiId,
                murid_id  : anggotaId,
                absensi     : absensi
            },
            success: function(data) {
                if (data.success) {
                    // alert("Data has been saved successfully!");
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred while processing your request.");
            }
        });
    });
</script>
@endsection
