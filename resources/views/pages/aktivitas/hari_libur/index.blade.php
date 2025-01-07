@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Hari Libur</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Aktivitas</li>
                    <li class="breadcrumb-item active"><a href="{{ route('aktivitas.hari_libur.index') }}">Data Hari Libur</a></li>
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
                                <form method="GET" action="{{ route('aktivitas.hari_libur.index') }}">
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
                            Hari Libur {{ $divisiNama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalInput" id="tambahData">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <table id="dataTables" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Keterangan</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td class="text-center">{{ date("d-m-Y", $data->tanggal) }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->dayName }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('MMMM') }}</td>
                                        <td class="text-center">{{ date("Y", $data->tanggal) }}</td>
                                        <td class="text-center">{{ $data->keterangan }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                                        <td class="text-center">{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}"
                                                    data-divisi_id="{{ $data->divisi_id }}"
                                                    data-tanggal="{{ date("Y-m-d", $data->tanggal) }}"
                                                    data-keterangan="{{ $data->keterangan }}">
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                @if ($data->status == true)
                                                    <button type="button" class="btn btn-danger btn-sm delete-data"
                                                        data-id="{{ $data->id }}" data-tanggal="{{ date("d-m-Y", $data->tanggal) }}">
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
                <h5 class="modal-title"><span id="title"></span> Data Hari Libur {{ $divisiNama }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('aktivitas.hari_libur.create')}}" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="divisiId" name="divisi_id">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control">
                    </div>
                    <small class="form-text text-danger error-tanggal" style="margin-top: -15px;">Harap input tanggal !</small>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan">
                    </div>
                    <small class="form-text text-danger error-keterangan" style="margin-top: -15px;">Harap input keterangan !</small>
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
        $('.loading').hide();

        $('.error-tanggal').hide();
        $('.error-keterangan').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '#tanggal', errorSelector: '.error-tanggal' },
            { selector: '#keterangan', errorSelector: '.error-keterangan' },
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
        $('#tanggal').val('');
        $('#keterangan').val('');

        $('.error-tanggal').hide();
        $('.error-keterangan').hide();
    });

    $(document).on("click", ".update-data", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        let id         = $(this).data('id');
        let divisiId   = $(this).data('divisi_id');
        let tanggal    = $(this).data('tanggal');
        let keterangan = $(this).data('keterangan');

        $('#id').val(id);
        $('#divisiId').val(divisiId);
        $('#tanggal').val(tanggal);
        $('#keterangan').val(keterangan);

        $('.error-tanggal').hide();
        $('.error-keterangan').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id      = $(this).data('id');
        let tanggal = $(this).data('tanggal');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data hari libur tanggal "+tanggal+" ini !",
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
                    url     : "{{ url('/aktivitas/hari-libur/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data hari libur tanggal '+tanggal,
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data hari libur tanggal '+tanggal,
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
