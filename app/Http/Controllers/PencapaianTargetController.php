<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTarget\KurikulumTarget;
use App\Models\KurikulumTarget\KurikulumTargetDetail;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tanggal;
use App\Models\Murid\Murid;
use App\Models\PencapaianTarget\PencapaianTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PencapaianTargetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:pencapaian_target']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();

        if (array_intersect($roles, ['paud', 'caberawit', 'praremaja', 'remaja', 'pranikah'])) {
            $divisiIds = [];
            // Loop untuk mengambil divisi dan kelas berdasarkan peran
            foreach ($roles as $role) {
                $divisi = Divisi::select('id')
                    ->where([['nama', ucfirst(strtolower($role))], ['status', true]])
                    ->first();

                // Pastikan divisi ditemukan sebelum melanjutkan
                if ($divisi) {
                    $divisiIds[] = $divisi->id; // Simpan ID Divisi
                }
            }

            $kelas = Kelas::whereIn('divisi_id', $divisiIds)->where('status', true)->first();

            $listKelas = Kelas::whereIn('divisi_id', $divisiIds)->where('status', true)->get();
        } else {
            $kelas = Kelas::where([['status', true], ['nama', 'Paud A']])->first();
            $listKelas = Kelas::where('status', true)->get();
        }

        $kelasId   = $kelas->id;
        $kelasNama = $kelas->nama;

        if ($request->has('kelas_id')) {
            $kelasId   = $request->kelas_id;
        }

        if ($request->has('kelas_nama')) {
            $kelasNama = $request->kelas_nama;
        }

        $listMurid = Murid::select('id', 'nama_panggilan', 'kelas_id', 'jenis_kelamin')->where([['kelas_id', $kelasId], ['status', true]])
            ->orderBy('jenis_kelamin', 'DESC')->orderBy('nama_panggilan', 'ASC')->get();

        $tahun  = $request->has('tahun') ? $request->tahun : Carbon::now()->year;
        $bulan  = $request->has('bulan') ? $request->bulan : Carbon::now()->month;

        $listTahun = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')
                 ->pluck('tahun');
        $listBulan = Tanggal::where([['tahun', $tahun], ['status', true]])->orderBy('bulan', 'ASC')->groupBy('bulan')
                 ->pluck('bulan');

        $id = KurikulumTarget::where([['kelas_id', $kelasId]])->pluck('id')->first();
        $listTargetKurikulum = KurikulumTargetDetail::with('getKarakter', 'getMateri', 'getSatuan')
            ->where('kurikulum_target_id', $id)
            ->orderBy('karakter_id', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->get();

        $listPencapaianTarget = [];

        foreach ($listMurid as $murid) {
            $datas = PencapaianTarget::select('id', 'kurikulum_target_detail_id', 'target')
                ->where([['kelas_id', $kelasId], ['murid_id', $murid->id], ['tahun', $tahun], ['bulan', $bulan]])
                ->get()->toArray();

            foreach ($datas as $data) {
                $listPencapaianTarget[$murid->id][$data['kurikulum_target_detail_id']] = $data;
            }
        }

        return view('pages.pencapaian_target.index', compact('listKelas', 'listMurid', 'listTahun', 'listBulan', 'listTargetKurikulum', 'listPencapaianTarget', 'id', 'kelasId', 'kelasNama', 'tahun', 'bulan'));
    }

    public function store(Request $request)
    {
        $success = true;
        $message = "Data has been saved successfully";

        DB::beginTransaction();
        try {
            $request->validate([
                'kelas_id'  => 'required|integer',
                'murid_id'  => 'required|integer',
                'kurikulum_target_detail_id' => 'required|integer',
                'target' => 'required|integer',
                'bulan' => 'required|integer',
                'tahun' => 'required|integer',
            ]);

            if ($request->id != null && $request->id != '') {
                $data = PencapaianTarget::findOrFail($request->id);
            } else {
                $data = new PencapaianTarget();
                $data->created_at = Carbon::now();
            }

            $data->kelas_id                   = $request->kelas_id;
            $data->murid_id                   = $request->murid_id;
            $data->kurikulum_target_detail_id = $request->kurikulum_target_detail_id;
            $data->target                     = $request->target;
            $data->bulan                      = $request->bulan;
            $data->tahun                      = $request->tahun;
            $data->updated_at                 = Carbon::now();
            $data->save();

            DB::commit();
        } catch (\Exception $e) {
            $success = false;
            $message = $e;

            DB::rollback();
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
