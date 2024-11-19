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
                                <form method="GET" action="{{ route('kurikulum_target.index') }}">
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
                                    <button type="button" class="btn btn-sm btn-success mx-1 text-right" data-toggle="modal" data-target="#modalInput" id="tambahData" data-kelas_id="{{ $kelasId }}">
                                        <i class="fa fa-plus"></i> Tambah Tanggal
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success mx-1" data-toggle="modal" data-target="#modalImportData">
                                        <i class="fas fa-file-import"></i> Import Data
                                    </button>
                                    <form method="GET" action="{{ route('kurikulum_target.export_template') }}">
                                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                                        <button type="submit" class="btn btn-sm btn-outline-success ml-1">
                                            <i class="fa fa-download"></i> Download Template
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dataTables" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Aksi</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listAnggota as $anggota)
                                        <tr>
                                            <td>{{ $anggota->nama_panggilan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    <div class="row">
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
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

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

        if (!status) {
            $('.loading').hide();
        }

        return status;
    }

    $('#tambahData').on('click', function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Tambah');
        $('#title').text('Tambah');

        var kelasId = $(this).data('kelas_id');

        $('#id').val('');
        $('#kelasId').val(kelasId);
        $('#tanggalMulai').val('');
        $('#tanggalAkhir').val('');

        $('.error-tanggal-mulai').hide();
        $('.error-tanggal-akhir').hide();
    });
</script>
@endsection
