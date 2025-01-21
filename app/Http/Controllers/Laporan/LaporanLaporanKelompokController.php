<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanLaporanKelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:laporan']);
    }

    public function index(Request $request)
    {
        $divisi = Divisi::where([['status', true], ['nama', 'Paud']])->first();
        $listDivisi = Divisi::where('status', true)->orderBy('id', 'ASC')->get();

        $divisiId   = $divisi->id;
        $divisiNama = $divisi->nama;

        if ($request->has('divisi_id')) {
            $divisi = Divisi::where([['status', true], ['id', $request->divisi_id]])->first();

            $divisiId   = $divisi->id;
            $divisiNama = $divisi->nama;
        }

        $tahun  = $request->has('tahun') ? $request->tahun : Carbon::now()->year;
        $bulan  = $request->has('bulan') ? $request->bulan : Carbon::now()->month;

        $listTahun = Tanggal::where('status', true)->orderBy('tahun', 'DESC')->groupBy('tahun')
                 ->pluck('tahun');
        $listBulan = Tanggal::where([['tahun', $tahun], ['status', true]])->orderBy('bulan', 'ASC')->groupBy('bulan')
                 ->pluck('bulan');

        return view('pages.laporan.laporan_kelompok.index', compact('listTahun', 'tahun', 'listBulan', 'bulan', 'listDivisi', 'divisiId', 'divisiNama'));
    }
}
