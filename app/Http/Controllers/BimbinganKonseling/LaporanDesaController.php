<?php

namespace App\Http\Controllers\BimbinganKonseling;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling\LaporanDesa;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanDesaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:bimbingan_konseling']);
    }

    public function index(Request $request)
    {
        $tahun  = $request->has('tahun') ? $request->tahun : Carbon::now()->year;
        $bulan  = $request->has('bulan') ? $request->bulan : Carbon::now()->month;

        $listTahun = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')
                 ->pluck('tahun');
        $listBulan = Tanggal::where([['tahun', $tahun], ['status', true]])->orderBy('bulan', 'ASC')->groupBy('bulan')
                 ->pluck('bulan');

        $listKategori  = LaporanDesa::listKategori;
        $listRealisasi = LaporanDesa::listRealisasi;

        $datas = LaporanDesa::where([['tahun', $tahun], ['bulan', $bulan], ['status', true]])
                    ->with('createdBy', 'updatedBy')->orderBy('created_at', 'ASC')->get();

        return view('pages.bimbingan_konseling.laporan_desa.index', compact('listTahun', 'tahun', 'listBulan', 'bulan', 'listKategori', 'listRealisasi', 'datas'));
    }

    public function create($id = null)
    {
        $title = "Create";
        $data  = new LaporanDesa();

        $tahun  = Carbon::now()->year;
        $bulan  = Carbon::now()->month;

        if (!empty($id)) {
            $title = "Update";
            $data = LaporanDesa::findOrFail($id);

            $tahun  = $data->tahun;
            $bulan  = $data->bulan;
        }

        $listTahun  = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')->pluck('tahun');
        $listBulan  = Tanggal::listBulan;
        $listKategori  = LaporanDesa::listKategori;
        $listRealisasi = LaporanDesa::listRealisasi;

        $data->tanggal = $data->tanggal ? date('Y-m-d', $data->tanggal) : null;

        return view('pages.bimbingan_konseling.laporan_desa.create', compact('title', 'data', 'listTahun', 'tahun', 'listBulan', 'bulan', 'listKategori', 'listRealisasi'));
    }

    public function store(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Laporan Desa Periode ";

        $this->validate($request, [
            'program' => 'required|string',
            'tahun' => 'required|integer',
            'bulan' => 'required|integer',
            'kategori' => 'required|integer',
            'realisasi' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $periode = Tanggal::listBulan[$request->bulan] . " " . $request->tahun;

            if ($request->id != null && $request->id != '') {
                $data = LaporanDesa::findOrFail($request->id);
                $action = "memperbarui";

                if (($data->bulan.$data->tahun) != ($request->bulan.$request->tahun)) {
                    $periode = Tanggal::listBulan[$data->bulan] . " " . $data->tahun . " ke " . Tanggal::listBulan[$request->bulan] . " " . $request->tahun;
                }
            } else {
                $data = new LaporanDesa();
                $data->created_at = strtotime(Carbon::now());
                $data->created_by = Auth::id();
            }

            $data->tahun      = $request->tahun;
            $data->bulan      = $request->bulan;
            $data->program    = $request->program;
            $data->kategori   = $request->kategori;
            $data->realisasi  = $request->realisasi;
            $data->status     = true;
            $data->updated_at = strtotime(Carbon::now());
            $data->updated_by = Auth::id();
            $data->save();

            DB::commit();

            $message = $status . " " . $action . " " . $title . " " . $periode;

            toast($message, 'success');
            return redirect()->route('bimbingan_konseling.laporan_desa.index');
        } catch (\Exception $e) {
            DB::rollback();

            toast('Gagal. Mohon cek kembali','error');
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = LaporanDesa::findOrFail($id);
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
}
