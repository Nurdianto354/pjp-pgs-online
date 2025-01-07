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
                    <li class="breadcrumb-item active"><a href="{{ route('bimbingan_konseling.laporan_daerah.index') }}">Laporan Daerah</a></li>
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
                            Laporan Daerah
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
                                    <th>Periode</th>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Masalah</th>
                                    <th>Penyelesaian</th>
                                    <th>Kondisi Terakhir</th>
                                    <th>di Buat</th>
                                    <th>di Perbarui</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td class="text-center">{{ App\Models\MasterData\Tanggal::listBulan[$data->bulan] . " " . $data->tahun }}</td>
                                        <td class="text-center">{{ $data->nama }}</td>
                                        <td class="text-center">{{ $data->usia }}</td>
                                        <td>{!! $data->masalah !!}</td>
                                        <td>{!! $data->penyelesaian !!}</td>
                                        <td>{!! $data->kondisi_terakhir !!}</td>
                                        <td class="text-center">{{ $data->status == 1 ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $data->createdBy->nama }}</td>
                                        <td>{{ $data->updatedBy->nama }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm update-data"
                                                    data-toggle="modal" data-target="#modalInput"
                                                    data-id="{{ $data->id }}"
                                                    data-tahun="{{ $data->tahun }}"
                                                    data-bulan="{{ $data->bulan }}"
                                                    data-nama="{{ $data->nama }}"
                                                    data-usia="{{ $data->usia }}"
                                                    data-masalah="{{ $data->masalah }}"
                                                    data-penyelesaian="{{ $data->penyelesaian }}"
                                                    data-kondisi_terakhir="{{ $data->kondisi_terakhir }}"
                                                >
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                                @if ($data->status == 1)
                                                    <button type="button" class="btn btn-danger btn-sm delete-data"
                                                        data-id="{{ $data->id }}"
                                                        data-tahun="{{ $data->tahun }}"
                                                        data-bulan="{{ App\Models\MasterData\Tanggal::listBulan[$data->bulan] }}"
                                                        data-nama="{{ $data->nama }}"
                                                        data-usia="{{ $data->usia }}"
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="overlay loading">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 100px; height: 100px; margin: 25% 0;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title"><span id="title"></span> Laporan Daerah</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="input-data" method="POST" action="{{ route('bimbingan_konseling.laporan_daerah.create')}}" onsubmit="return validateForm()">
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
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Nama (inisial)</label>
                                <input type="text" class="form-control" placeholder="Input inisial nama" id="nama" name="nama">
                            </div>
                            <small class="form-text text-danger error-nama" style="margin-top: -15px;">Nama tidak boleh kosong !</small>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Usia</label>
                                <div class="row">
                                    <div class="col-8 col-md-10">
                                        <input type="number" min="0" max="99" class="form-control" placeholder="Input usia" id="usia" name="usia">
                                    </div>
                                    <div class="col-4 col-md-2 d-flex justify-content-center align-items-center">
                                        Tahun
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-danger error-usia" style="margin-top: -15px;">Usia tidak boleh kosong !</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Masalah</label>
                        <textarea class="form-control" placeholder="Input Masalah" id="masalah" name="masalah"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Penyelesaian</label>
                        <textarea class="form-control" placeholder="Input Penyelesaian" id="penyelesaian" name="penyelesaian"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kondisi Terakhir</label>
                        <textarea class="form-control" placeholder="Input Kondisi Terakhir" id="kondisiTerakhir" name="kondisi_terakhir"></textarea>
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
        $('.select2-tahun').select2({
            placeholder: "Pilih Tahun",
            allowClear: true
        });

        $('.select2-bulan').select2({
            placeholder: "Pilih Bulan",
            allowClear: true
        });

        $('.loading').hide();

        $('.error-periode').hide();
        $('.error-nama').hide();
        $('.error-usia').hide();
    });

    function validateForm() {
        $('.loading').show();
        let status = true;

        const fields = [
            { selector: '.select2-bulan', errorSelector: '.error-periode' },
            { selector: '.select2-tahun', errorSelector: '.error-periode' },
            { selector: '#nama', errorSelector: '.error-nama' },
            { selector: '#usia', errorSelector: '.error-usia' },
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
        $('.select2-tahun').val(null).trigger('change');
        $('.select2-bulan').val(null).trigger('change');
        $('#nama').val('');
        $('#usia').val('');
        $('#masalah').val('');
        $('#penyelesaian').val('');
        $('#kondisiTerakhir').val('');

        $('.error-periode').hide();
        $('.error-nama').hide();
        $('.error-usia').hide();
    });

    $(document).on("click", ".update-data", function () {
        $('.loading').hide();

        $('#btnSave').html('<i class="fa-solid fa-check"></i> Perbarui');
        $('#title').text('Update')

        let id = $(this).data('id');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');
        let nama = $(this).data('nama');
        let usia = $(this).data('usia');
        let masalah = $(this).data('masalah');
        let penyelesaian = $(this).data('penyelesaian');
        let kondisiTerakhir = $(this).data('kondisi_terakhir');

        $('#id').val(id);
        $('.select2-tahun').val(tahun).trigger('change');
        $('.select2-bulan').val(bulan).trigger('change');
        $('#nama').val(nama);
        $('#usia').val(usia);
        $('#masalah').val(masalah);
        $('#penyelesaian').val(penyelesaian);
        $('#kondisiTerakhir').val(kondisiTerakhir);

        $('.error-periode').hide();
        $('.error-nama').hide();
        $('.error-usia').hide();
    });

    $(document).on('click', '.delete-data', function(e) {
        let id    = $(this).data('id');
        let tahun = $(this).data('tahun');
        let bulan = $(this).data('bulan');
        let nama  = $(this).data('nama');
        let usia  = $(this).data('usia');

        e.preventDefault();

        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Ingin menghapus data laporan daerah periode "+bulan+" "+tahun+" nama inisial "+nama+" usia "+ usia +" tahun ini !",
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
                    url     : "{{ url('/bimbingan-konseling/laporan-daerah/delete') }}/" + id,
                    success: function(data) {
                        if(data.status == "success") {
                            toastMixin.fire({
                                icon: 'success',
                                title: 'Berhasil menghapus data laporan daerah periode '+bulan+' '+tahun+' nama inisial '+nama+' usia '+ usia +' tahun',
                            });

                            location.reload();
                        } else if(data.status == "error") {
                            toastMixin.fire({
                                icon: 'error',
                                title: 'Gagal, menghapus data laporan daerah periode '+bulan+' '+tahun+' nama inisial '+nama+' usia '+ usia +' tahun',
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
