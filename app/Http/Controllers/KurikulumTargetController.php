<?php

namespace App\Http\Controllers;

use App\Models\KurikulumTarget\KurikulumTarget;
use App\Models\KurikulumTarget\KurikulumTargetDetail;
use App\Models\MasterData\Karakter;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Materi;
use App\Models\MasterData\Satuan;
use App\Models\MasterData\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KurikulumTargetController extends Controller
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

        $id = KurikulumTarget::where([['kelas_id', $kelasId], ['tahun_ajaran_id', $tahunAjaranId]])->pluck('id')->first();
        $datas = KurikulumTargetDetail::with('getKarakter', 'getMateri', 'getSatuan')->where('kurikulum_target_id', $id)->orderBy('created_at', 'DESC')->get();

        return view('pages.kurikulum_target.index', compact('listKelas', 'listTahunAjaran', 'id', 'kelasId', 'kelasNama', 'tahunAjaranId', 'datas'));
    }

    public function create(Request $request)
    {
        $title = "Tambah";

        $id = $request['id'];
        $kelasId = $request['kelas_id'];
        $tahunAjaranId = $request['tahun_ajaran_id'];

        $listKarakter = Karakter::where('status', true)->orderBy('nama', 'ASC')->get();
        $listMateri   = Materi::where('status', true)->orderBy('nama', 'ASC')->get();
        $listSatuan   = Satuan::where('status', true)->orderBy('nama', 'ASC')->get();

        return view('pages.kurikulum_target.create', compact('title', 'id', 'kelasId', 'tahunAjaranId', 'listKarakter', 'listMateri', 'listSatuan'));
    }

    public function store(Request $request)
    {
        if ($request->has('id')) {
            $data = KurikulumTarget::findOrFail($request['id']);
            $data->created_at = Carbon::now();

            $action = "memperbarui kurikulum target";
        } else {
            $data = new KurikulumTarget();

            $action = "menambahkan kurikulum target";
        }

        $kelasNama = Kelas::where([['id', $request['kelas_id']], ['status', true]])->pluck('nama')->first();
        $tahunAjaranNama = TahunAjaran::where([['id', $request['tahun_ajaran_id']], ['status', true]])->pluck('nama')->first();

        DB::beginTransaction();
        try {
            $data->kelas_id = $request['kelas_id'];
            $data->tahun_ajaran_id = $request['tahun_ajaran_id'];
            $data->updated_at = Carbon::now();
            $data->save();

            foreach ($request['karakter'] as $index => $karakter) {
                $dataDetail = new KurikulumTargetDetail();
                $dataDetail->kurikulum_target_id = $data->id;
                $dataDetail->karakter_id         = $karakter;
                $dataDetail->materi_id           = $request['materi'][$index];
                $dataDetail->target              = $request['target'][$index];
                $dataDetail->satuan_id           = $request['satuan'][$index];
                $dataDetail->save();
            }

            DB::commit();

            toast('Berhasil ' . $action . ' kelas ' . $kelasNama . ' tahun ajaran ' . $tahunAjaranNama, 'success');
            return redirect(route('kurikulum_target.index'));
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();

            toast('Gagal ' . $action . ' kelas ' . $kelasNama . ' tahun ajaran ' . $tahunAjaranNama, 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = KurikulumTargetDetail::findOrFail($id);
            $data->delete();

            DB::commit();

            return response()->json([
                'status'     => 'success',
                'keterangan' => '',
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();

            return response()->json([
                'status'     => 'error',
                'keterangan' => 'karena ada kesalahan di sistem'
            ]);
        }
    }
}
