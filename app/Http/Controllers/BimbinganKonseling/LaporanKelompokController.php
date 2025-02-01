<?php

namespace App\Http\Controllers\BimbinganKonseling;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling\LaporanKelompok;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanKelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:bimbingan_konseling']);
    }

    public function index()
    {
        $listTahun = Tanggal::where('status', true)->groupBy('tahun')->pluck('tahun');
        $listTahunTemp = [];

        foreach ($listTahun as $tahun) {
            $listTahunTemp[$tahun] = $tahun;
        }

        $listTahun = $listTahunTemp;

        $listBulan = Tanggal::where('status', true)->groupBy('bulan')->pluck('bulan');
        $listBulanTemp = [];

        foreach ($listBulan as $bulan) {
            $listBulanTemp[$bulan] = Tanggal::listBulan[$bulan];
        }

        $listBulan = $listBulanTemp;

        $datas = LaporanKelompok::with('getDivisi', 'getKelas', 'createdBy', 'updatedBy')->where('status', true)->orderBy('created_at', 'ASC')->get();

        return view('pages.bimbingan_konseling.laporan_kelompok.index', compact('listTahun', 'listBulan', 'datas'));
    }

    public function create($id = null)
    {
        $title = "Create";
        $data  = new LaporanKelompok();

        if (!empty($id)) {
            $title = "Update";
            $data = LaporanKelompok::findOrFail($id);
        }

        $listDivisi = Divisi::where('status', true)->orderBy('id', 'ASC')->get();
        $listTahun  = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')->pluck('tahun');
        $listBulan  = Tanggal::listBulan;

        $data->tanggal = $data->tanggal ? date('Y-m-d', $data->tanggal) : null;

        return view('pages.bimbingan_konseling.laporan_kelompok.create', compact('title', 'data', 'listDivisi', 'listTahun', 'listBulan'));
    }

    public function store(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Laporan BK Kelompok";

        DB::beginTransaction();
        try {
            $request->validate([
                'bulan' => 'required|integer',
                'tahun' => 'required|integer',
                'divisi_id'  => 'required|integer',
                'kelas_id'  => 'required|integer',
            ]);

            if ($request->id != null && $request->id != '') {
                $data = LaporanKelompok::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new LaporanKelompok();
                $data->created_at = strtotime(Carbon::now());
                $data->created_by = Auth::id();
            }

            $data->bulan      = $request->bulan;
            $data->tahun      = $request->tahun;
            $data->divisi_id  = $request->divisi_id;
            $data->kelas_id   = $request->kelas_id;
            $data->kasus      = $request->kasus;
            $data->tanggal    = strtotime(Carbon::now());
            $data->status     = true;
            $data->updated_at = strtotime(Carbon::now());
            $data->updated_by = Auth::id();
            $data->save();

            DB::commit();

            toast($status . ' ' . $action . ' ' . $title, 'success');
            return redirect()->route('bimbingan_konseling.laporan_kelompok.index');
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();

            toast('Gagal ' . $action . ' ' . $title, 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = LaporanKelompok::findOrFail($id);
            $data->status = false;
            $data->save();

            DB::commit();

            return response()->json([
                'status'     => 'success',
                'keterangan' => '',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status'     => 'error',
                'keterangan' => 'karena ada kesalahan di sistem'
            ]);
        }
    }

    public function getKelas(Request $request)
    {
        $listKelas = Kelas::where([['divisi_id', $request['divisi_id']], ['status', true]])->get();

        return response()->json($listKelas);
    }

    public function exportPdf()
    {

    }

    public function exportExcel()
    {

    }
}
