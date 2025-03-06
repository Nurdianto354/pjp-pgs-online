<?php

namespace App\Http\Controllers\BimbinganKonseling;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling\LaporanDaerah;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanDaerahController extends Controller
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

        $datas = LaporanDaerah::where([['tahun', $tahun], ['bulan', $bulan], ['status', true]])->with('createdBy', 'updatedBy')
            ->orderBy('created_at', 'ASC')->get();

        return view('pages.bimbingan_konseling.laporan_daerah.index', compact('listTahun', 'tahun', 'listBulan', 'bulan', 'datas'));
    }

    public function create($id = null)
    {
        $title = "Create";
        $data  = new LaporanDaerah();

        $tahun  = Carbon::now()->year;
        $bulan  = Carbon::now()->month;

        if (!empty($id)) {
            $title = "Update";
            $data = LaporanDaerah::findOrFail($id);

            $tahun  = $data->tahun;
            $bulan  = $data->bulan;
        }

        $listTahun  = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')->pluck('tahun');
        $listBulan  = Tanggal::listBulan;

        $data->tanggal = $data->tanggal ? date('Y-m-d', $data->tanggal) : null;

        return view('pages.bimbingan_konseling.laporan_daerah.create', compact('title', 'data', 'listTahun', 'tahun', 'listBulan', 'bulan'));
    }

    public function store(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Laporan Desa Periode ";

        $this->validate($request, [
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'nama' => 'required|string',
            'usia' => 'required|integer',
            'masalah' => 'required|string',
            'penyelesaian' => 'required|string',
            'kondisi_terakhir' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $periode = Tanggal::listBulan[$request->bulan] . " " . $request->tahun;

            if ($request->id != null && $request->id != '') {
                $data = LaporanDaerah::findOrFail($request->id);
                $action = "memperbarui";

                if (($data->bulan.$data->tahun) != ($request->bulan.$request->tahun)) {
                    $periode = Tanggal::listBulan[$data->bulan] . " " . $data->tahun . " ke " . Tanggal::listBulan[$request->bulan] . " " . $request->tahun;
                }
            } else {
                $data = new LaporanDaerah();
                $data->created_at = strtotime(Carbon::now());
                $data->created_by = Auth::id();
            }

            $data->tahun            = $request->tahun;
            $data->bulan            = $request->bulan;
            $data->nama             = $request->nama;
            $data->usia             = $request->usia;
            $data->masalah          = $request->masalah;
            $data->penyelesaian     = $request->penyelesaian;
            $data->kondisi_terakhir = $request->kondisi_terakhir;
            $data->status           = true;
            $data->updated_at       = strtotime(Carbon::now());
            $data->updated_by       = Auth::id();
            $data->save();

            DB::commit();

            $message = $status . " " . $action . " " . $title . " " . $periode;

            toast($message, 'success');
            return redirect()->route('bimbingan_konseling.laporan_daerah.index');
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
            $data = LaporanDaerah::findOrFail($id);
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
