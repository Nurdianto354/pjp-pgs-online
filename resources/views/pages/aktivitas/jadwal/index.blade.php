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
                <h1 class="m-0">Data Jadwal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Aktivitas</li>
                    <li class="breadcrumb-item active"><a href="{{ route('aktivitas.jadwal.index') }}">Data Jadwal</a></li>
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
                            Divisi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-tabs h-100">
                            @foreach ($listDivisi as $divisi)
                                <form method="GET" action="{{ route('aktivitas.jadwal.index') }}">
                                    <input type="hidden" name="divisi_id" value="{{ $divisi->id }}">
                                    <input type="hidden" name="divisi_nama" value="{{ $divisi->nama }}">
                                    <button type="submit" class="btn btn-outline-success col-sm text-left mb-1 {{ App\Models\Aktivitas\Jadwal::getTab($divisi->id, $divisiId) ? 'active' : '' }}">
                                        {{ $divisi->nama }}
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
                            Jadwal {{ $divisiNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalInput" id="tambahData">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ App\Models\MasterData\Tanggal::listDay[$data->hari] }}</td>
                                        <td class="text-center">
                                            {{ date("H:i", strtotime($data->waktu_mulai)) }} : {{ date("H:i", strtotime($data->waktu_selesai)) }}
                                        </td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}" data-divisi_id="{{ $data->divisi_id }}" data-hari="{{ $data->hari }}"
                                                    data-waktu_mulai="{{ date("H:i", strtotime($data->waktu_mulai)) }}"
                                                    data-waktu_selesai="{{ date("H:i", strtotime($data->waktu_selesai)) }}">
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                @if ($data->status == true)
                                                    <button type="button" class="btn btn-danger btn-sm delete-data"
                                                        data-id="{{ $data->id }}" data-hari="{{ App\Models\MasterData\Tanggal::listDay[$data->hari] }}"
                                                        data-waktu_mulai="{{ date("H:i", strtotime($data->waktu_mulai)) }}"
                                                        data-waktu_selesai="{{ date("H:i", strtotime($data->waktu_selesai)) }}">
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
                <h5 class="modal-title"><span id="title"></span> Data Jadwal {{ $divisiNama }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('aktivitas.jadwal.create')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="divisiId" name="divisi_id">
                    <div class="form-group">
                        <label>Hari</label>
                        <select name="hari" class="form-control select2-hari select2-success" data-dropdown-css-class="select2-success">
                            <option value="0">Minggu</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                        </select>
                    </div>
                    <small class="form-text text-danger error-hari" style="margin-top: -15px;">Harap pilih hari !</small>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input type="time" id="waktuMulai" name="waktu_mulai" class="form-control">
                            </div>
                            <small class="form-text text-danger error-waktu-mulai" style="margin-top: -15px;">Harap input waktu mulai !</small>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input type="time" id="waktuSelesai" name="waktu_selesai" class="form-control">
                            </div>
                            <small class="form-text text-danger error-waktu-selesai" style="margin-top: -15px;">Harap input waktu mulai !</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mb-2 mr-sm-2" data-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2" id="btnSave">Simpan</button>
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
        $('.select2-hari').select2({
            placeholder: "Pilih hari",
            allowClear: true
        });

        $('.loading').hide();

        $('.error-hari').hide();
        $('.error-waktu-mulai').hide();
        $('.error-waktu-selesai').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '.select2-hari', errorSelector: '.error-hari' },
            { selector: '#waktuMulai', errorSelector: '.error-waktu-mulai' },
            { selector: '#waktuSelesai', errorSelector: '.error-waktu-selesai' },
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

        let divisiId = {{ $divisiId }};

        $('#id').val('');
        $('#divisiId').val(divisiId);
        $('.select2-hari').val(null).trigger('change');
        $('#waktuMulai').val('');
        $('#waktuSelesai').val('');

        $('.error-hari').hide();
        $('.error-waktu-mulai').hide();
        $('.error-waktu-selesai').hide();
    });

    $(document).on("click", ".update-data", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        let id           = $(this).data('id');
        let divisiId     = $(this).data('divisi_id');
        let hari         = $(this).data('hari');
        let waktuMulai   = $(this).data('waktu_mulai');
        let waktuSelesai = $(this).data('waktu_selesai');

        $('#id').val(id);
        $('#divisiId').val(divisiId);
        $('.select2-hari').val(hari).trigger('change');
        $('#waktuMulai').val(waktuMulai);
        $('#waktuSelesai').val(waktuSelesai);

        $('.error-hari').hide();
        $('.error-waktu-mulai').hide();
        $('.error-waktu-selesai').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id           = $(this).data('id');
        let hari         = $(this).data('hari');
        let waktuMulai   = $(this).data('waktu_mulai');
        let waktuSelesai = $(this).data('waktu_selesai');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data hari "+hari+" waktu "+waktuMulai+":"+waktuMulai+" ini !",
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
                    url     : "{{ url('/aktivitas/jadwal/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data hari '+hari +" waktu "+waktuMulai+":"+waktuMulai,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data hari '+hari +" waktu "+waktuMulai+":"+waktuMulai,
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
