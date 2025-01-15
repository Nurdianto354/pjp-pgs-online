<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapAbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:rekap_absensi']);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();

        if (array_intersect($roles, ['paud', 'caberawit', 'praremaja', 'remaja', 'pranikah'])) {
            $divisiIds = [];

            foreach ($roles as $role) {
                $divisi = Divisi::select('id')
                    ->where([['nama', ucfirst(strtolower($role))], ['status', true]])
                    ->first();

                // Pastikan divisi ditemukan sebelum melanjutkan
                if ($divisi) {
                    $divisiIds[] = $divisi->id; // Simpan ID Divisi
                }
            }

            $divisi = Divisi::where('status', true)->whereIn('id', $divisiIds)->first();

            $listDivisi = Divisi::where('status', true)->whereIn('id', $divisiIds)->orderBy('id', 'ASC')->get();
        } else {
            $listDivisi = Divisi::where('status', true)->orderBy('id', 'ASC')->get();

            $divisi = Divisi::where([['status', true], ['nama', 'Paud']])->first();
        }

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

        $listKelas = Kelas::where([['divisi_id', $divisiId], ['status', true]])->get();

        return view('pages.rekap_absensi.index', compact('listTahun', 'tahun', 'listBulan', 'bulan', 'listDivisi', 'divisiId', 'divisiNama', 'listKelas'));
    }
}
