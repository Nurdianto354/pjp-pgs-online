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
                <h1 class="m-0">Data Murid</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item active"><a href="{{ route('murid.index') }}">Data Murid</a></li>
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
                            <i class="fas fa-table"></i>
                            Data Murid
                        </h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalInput" id="tambahData">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Panggilan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Divisi</th>
                                    <th>Kelas</th>
                                    <th>TTL</th>
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
                                        <td>{{ $data->nama_lengkap }}</td>
                                        <td>{{ $data->nama_panggilan }}</td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Laki - laki' : 'Perempuan' }}</td>
                                        <td>{{ $data->getDivisi->nama }}</td>
                                        <td>{{ $data->getKelas->nama }}</td>
                                        <td>
                                            {{ !empty($data->tempat_lahir) ? $data->tempat_lahir .", " : '' }}
                                            {{ !empty($data->tanggal_lahir) ? date("d-m-Y", strtotime($data->tanggal_lahir)) : ''}}
                                        </td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}"
                                                    data-nama_lengkap="{{ $data->nama_lengkap }}"
                                                    data-nama_panggilan="{{ $data->nama_panggilan }}"
                                                    data-jenis_kelamin="{{ $data->jenis_kelamin }}"
                                                    data-kelas_id="{{ $data->kelas_id }}"
                                                    data-tempat_lahir="{{ $data->tempat_lahir }}"
                                                    data-tanggal_lahir="{{ $data->tanggal_lahir }}"
                                                    data-alamat="{{ $data->alamat }}"
                                                    data-no_telp="{{ $data->no_telp }}"
                                                >
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                @if ($data->status == 1)
                                                    <button type="button" class="btn btn-danger btn-sm delete-data" data-id="{{ $data->id }}" data-nama_lengkap="{{ $data->nama_lengkap }}">
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
                <h5 class="modal-title"><span id="title"></span> Data Murid</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('murid.create')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Input nama lengkap" id="namaLengkap" name="nama_lengkap">
                    </div>
                    <small class="form-text text-danger error-nama-lengkap" style="margin-top: -15px;">Harap masukan nama lengkap !</small>
                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" class="form-control" placeholder="Input nama panggilan" id="namaPanggilan" name="nama_panggilan">
                    </div>
                    <small class="form-text text-danger error-nama-panggilan" style="margin-top: -15px;">Harap masukan nama panggilan !</small>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control select2-jenis-kelamin select2-success" data-dropdown-css-class="select2-success">
                            <option value="0">Perempuan</option>
                            <option value="1">Laki - laki</option>
                        </select>
                    </div>
                    <small class="form-text text-danger error-jenis-kelamin" style="margin-top: -15px;">Harap pilih jenis kelamin !</small>
                    <div class="form-group">
                        <label>Nama Divisi</label>
                        <select name="divisi_id" class="form-control select2-divisi select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listDivisi as $divisi)
                                <option value="{{ $divisi->id }}">
                                    {{ $divisi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="form-text text-danger error-divisi-id" style="margin-top: -15px;">Harap pilih divisi !</small>
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <select name="kelas_id" class="form-control select2-kelas select2-success" data-dropdown-css-class="select2-success">
                            @foreach ($listKelas as $kelas)
                                <option value="{{ $kelas->id }}">
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" placeholder="Input tempat lahir" id="tempatLahir" name="tempat_lahir">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" placeholder="Input tanggal lahir" id="tanggalLahir" name="tanggal_lahir">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" placeholder="Input alamat" id="alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label>No Telp.</label>
                        <input type="text" class="form-control" placeholder="Input No Telp." id="noTelp" name="no_telp">
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
        $('.select2-jenis-kelamin').select2({
            placeholder: "Pilih Jenis Kelamin",
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

        $('.loading').hide();

        $('.error-nama-lengkap').hide();
        $('.error-nama-panggilan').hide();
        $('.error-jenis-kelamin').hide();
        $('.error-divisi-id').hide();
        $('.error-kelas-id').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '#namaLengkap', errorSelector: '.error-nama-lengkap' },
            { selector: '#namaPanggilan', errorSelector: '.error-nama-panggilan' },
            { selector: '#jenisKelamin', errorSelector: '.error-jenis-kelamin' },
            { selector: '#divisiId', errorSelector: '.error-divisi-id' },
            { selector: '#kelasId', errorSelector: '.error-kelas-id' },
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
        $('#namaLengkap').val('');
        $('#namaPanggilan').val('');
        $('.select2-jenis-kelamin').val(null).trigger('change');
        $('.select2-kelas').val(null).trigger('change');
        $('.select2-divisi').val(null).trigger('change');
        $('#tempatLahir').val('');
        $('#tanggalLahir').val('');
        $('#alamat').val('');
        $('#noTelp').val('');

        $('.error-nama-lengkap').hide();
        $('.error-nama-panggilan').hide();
        $('.error-jenis-kelamin').hide();
        $('.error-divisi-id').hide();
        $('.error-kelas-id').hide();
    });

    $('.update-data').on("click", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        var id = $(this).data('id');
        var namaLengkap   = $(this).data('nama_lengkap');
        var namaPanggilan = $(this).data('nama_panggilan');
        var jenisKelamin  = $(this).data('jenis_kelamin');
        var divisiId      = $(this).data('divisi_id');
        var kelasId       = $(this).data('kelas_id');
        var tempatLahir   = $(this).data('tempat_lahir');
        var tanggalLahir  = $(this).data('tanggal_lahir');
        var alamat        = $(this).data('alamat');
        var noTelp        = $(this).data('no_telp');

        $('#id').val(id);
        $('#namaLengkap').val(namaLengkap);
        $('#namaPanggilan').val(namaPanggilan);
        $('.select2-jenis-kelamin').val(jenisKelamin).trigger('change');
        $('.select2-divisi').val(divisiId).trigger('change');
        $('.select2-kelas').val(kelasId).trigger('change');
        $('#tempatLahir').val(tempatLahir);
        $('#tanggalLahir').val(tanggalLahir);
        $('#alamat').val(alamat);
        $('#noTelp').val(noTelp);

        $('.error-nama-lengkap').hide();
        $('.error-nama-panggilan').hide();
        $('.error-jenis-kelamin').hide();
        $('.error-divisi-id').hide();
        $('.error-kelas-id').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id   = $(this).data('id');
        var namaLengkap = $(this).data('nama_lengkap');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data murid "+namaLengkap+" ini !",
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
                    url     : "{{ url('/murid/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data murid '+namaLengkap,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data murid '+namaLengkap,
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
