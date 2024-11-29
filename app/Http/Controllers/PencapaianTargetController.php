<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTarget\KurikulumTarget;
use App\Models\KurikulumTarget\KurikulumTargetDetail;
use App\Models\MasterData\Anggota;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\TahunAjaran;
use Illuminate\Http\Request;

class PencapaianTargetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $listAnggota = Anggota::select('id', 'nama_panggilan', 'kelas_id')->where([['kelas_id', $kelasId], ['status', true]])->orderBy('nama_panggilan', 'ASC')->get();

        $id = KurikulumTarget::where([['kelas_id', $kelasId], ['tahun_ajaran_id', $tahunAjaranId]])->pluck('id')->first();
        $datas = KurikulumTargetDetail::with('getKarakter', 'getMateri', 'getSatuan')->where('kurikulum_target_id', $id)->orderBy('created_at', 'ASC')->get();

        return view('pages.pencapaian_target.index', compact('listKelas', 'listTahunAjaran', 'listAnggota', 'id', 'kelasId', 'kelasNama', 'tahunAjaranId', 'datas'));
    }
}
