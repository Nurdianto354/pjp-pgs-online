@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }} Kurikulum</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Master Data</li>
                    <li class="breadcrumb-item"><a href="{{ route('kurikulum.index') }}">Data Kurikulum</a></li>
                    <li class="breadcrumb-item active">{{ $title }} Kurikulum</li>
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
                            <i class="fas fa-book"></i>
                            {{ $title }} Kelas
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('kurikulum.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="karakter">Pilih Karakter</label>
                                        <select name="karakter" id="karakter" data-placeholder="Pilih Karakter" style="width: 100%;">
                                            @foreach ($listKarakter as $karakter)
                                                <option value="{{ $karakter->id }}">
                                                    {{ $karakter->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="karakter">Pilih Materi</label>
                                        <select name="materi" id="materi" data-placeholder="Pilih Materi" style="width: 100%;">
                                            @foreach ($listMateri as $materi)
                                                <option value="{{ $materi->id }}">
                                                    {{ $materi->nama }}
                                                </option>
                                            @endforeach
                                        </select>
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
    $(document).ready(function() {
        $('#karakter').select2({
           theme: 'bootstrap4'
        });
        $('#materi').select2({
           theme: 'bootstrap4'
        });
    });
</script>
@endsection

