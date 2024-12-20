<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTarget\KurikulumTarget;
use App\Models\KurikulumTarget\KurikulumTargetDetail;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tahun;
use App\Models\Murid\Murid;
use App\Models\PencapaianTarget\PencapaianTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PencapaianTargetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:pencapaian_target']);
    }

    public function index(Request $request)
    {
        $kelas = Kelas::where([['status', true], ['nama', 'Paud A']])->first();

        $kelasId   = $kelas->id;
        $kelasNama = $kelas->nama;

        if ($request->has('kelas_id')) {
            $kelasId   = $request->kelas_id;
        }

        if ($request->has('kelas_nama')) {
            $kelasNama = $request->kelas_nama;
        }

        $tahun = Tahun::where('status', true)->orderBy('id', 'DESC')->first();
        $tahunId = $tahun->id;

        if ($request->has('tahun_id')) {
            $tahunId = $request->tahun_id;
        }

        $listKelas = Kelas::where('status', true)->get();
        $listTahun = Tahun::where('status', true)->orderBy('id', 'DESC')->get();

        $listMurid = Murid::select('id', 'nama_panggilan', 'kelas_id')->where([['kelas_id', $kelasId], ['status', true]])->orderBy('nama_panggilan', 'ASC')->get();

        $id = KurikulumTarget::where([['kelas_id', $kelasId], ['tahun_id', $tahunId]])->pluck('id')->first();
        $listTargetKurikulum = KurikulumTargetDetail::with('getKarakter', 'getMateri', 'getSatuan')
            ->where('kurikulum_target_id', $id)
            ->orderBy('karakter_id', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->get();


        $listPencapaianTarget = [];

        foreach ($listMurid as $murid) {
            $datas = PencapaianTarget::select('id', 'kurikulum_target_detail_id', 'target')
                ->where([['kelas_id', $kelasId], ['tahun_id', $tahunId], ['murid_id', $murid->id]])->get()->toArray();

            foreach ($datas as $data) {
                $listPencapaianTarget[$murid->id][$data['kurikulum_target_detail_id']] = $data;
            }
        }

        return view('pages.pencapaian_target.index', compact('listKelas', 'listTahun', 'listMurid', 'listTargetKurikulum', 'listPencapaianTarget', 'id', 'kelasId', 'kelasNama', 'tahunId'));
    }

    public function store(Request $request)
    {
        $success = true;
        $message = "";

        $data = new PencapaianTarget();
        $data->kelas_id                   = $request->kelas_id;
        $data->tahun_id            = $request->tahun_id;
        $data->murid_id                   = $request->murid_id;
        $data->kurikulum_target_detail_id = $request->kurikulum_target_detail_id;
        $data->target                     = $request->target;
        $data->created_at                 = Carbon::now();
        $data->updated_at                 = Carbon::now();
        $data->save();

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
