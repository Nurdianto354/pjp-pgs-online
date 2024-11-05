<?php

namespace App\Http\Controllers;

use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KurikulumController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::where([['status', true], ['nama', 'Paud A']])->first();

        $kelasId   = $kelas->id;
        $kelasNama = $kelas->nama;

        if($request->has('kelas_id')) {
            $kelasId   = $request->kelas_id;
        }

        if($request->has('kelas_nama')) {
            $kelasNama = $request->kelas_nama;
        }

        $tahunAjaran = TahunAjaran::where('status', true)->orderBy('id', 'DESC')->first();
        $tahunAjaranId = $tahunAjaran->id;

        if($request->has('tahun_ajaran_id')) {
            $tahunAjaranId = $request->tahun_ajaran_id;
        }

        $listTahunAjaran = TahunAjaran::where('status', true)->orderBy('id', 'DESC')->get();
        $listKelas = Kelas::where('status', true)->get();

        return view('pages.kurikulum.index', compact('listKelas', 'listTahunAjaran', 'kelasId', 'kelasNama', 'tahunAjaranId'));
    }

    public function create(Request $request)
    {
        $title = "Tambah";
        $kelasId = $request['kelas_id'];
        $tahunAjaranId = $request['tahun_ajaran_id'];

        return view('pages.kurikulum.create', compact('title', 'kelasId', 'tahunAjaranId'));
    }
}
