<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi\Absensi;
use App\Models\Aktivitas\HariLibur;
use App\Models\Aktivitas\Jadwal;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tanggal;
use App\Models\Murid\Murid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function detail(Request $request)
    {
        $listTahun = Absensi::where('murid_id', $request['id'])->orderBy('tahun', 'DESC')->groupBy('tahun')->pluck('tahun')->toArray();
        $jadwal = Jadwal::where([['divisi_id', $request['divisi_id']], ['status', true]])->pluck('hari');

        foreach ($listTahun as $tahun) {
            $listBulan = Absensi::where([['murid_id', $request['id']], ['tahun', $tahun]])->groupBy('bulan')
                ->orderBy('bulan', 'DESC')->pluck('bulan')->toArray();

            foreach ($listBulan as $bulan) {
                $hariLibur = HariLibur::where([['divisi_id', $request['divisi_id']], ['bulan', $bulan], ['tahun', $tahun], ['status', true]])
                    ->pluck('tanggal');

                $listTanggal = Tanggal::where([['tahun', $tahun], ['bulan', $bulan], ['status', true]])
                    ->whereIn('hari', $jadwal)
                    ->whereNotIn('tanggal', $hariLibur)
                    ->orderBy('tanggal', 'ASC')->pluck('tanggal')->toArray();

                $listAbsensi = Absensi::where([['murid_id', $request['id']], ['kelas_id', $request['kelas_id']]])
                    ->whereIn('tanggal', $listTanggal);

                $absensiCount = $listAbsensi->selectRaw('
                        SUM(CASE WHEN kehadiran = "H" THEN 1 ELSE 0 END) as hadir,
                        SUM(CASE WHEN kehadiran IN ("I", "S") THEN 1 ELSE 0 END) as izin
                    ')
                    ->first();

                $hadir = $absensiCount->hadir <= 0 ? 0 : $absensiCount->hadir;
                $izin  = $absensiCount->izin <= 0 ? 0 : $absensiCount->izin;
                $total = count($listTanggal);

                $hadirPers  = ($hadir/$total)*100;
                $keterangan = "Nilai tidak valid";

                if ($hadirPers < 40) {
                    $keterangan = "Tidak lancar";
                } elseif ($hadirPers >= 40 && $hadirPers < 60) {
                    $keterangan = "Kurang lancar";
                } elseif ($hadirPers >= 60 && $hadirPers < 80) {
                    $keterangan = "Lancar";
                } elseif ($hadirPers >= 80 && $hadirPers <= 100) {
                    $keterangan = "Sangat lancar";
                }

                $datas[$tahun.$bulan]['tahun'] = $tahun;
                $datas[$tahun.$bulan]['bulan'] = Tanggal::listBulan[$bulan];
                $datas[$tahun.$bulan]['hadir'] = $hadir;
                $datas[$tahun.$bulan]['izin'] = $izin;
                $datas[$tahun.$bulan]['alfa'] = $total - ($hadir + $izin);
                $datas[$tahun.$bulan]['pers'] = $hadirPers;
                $datas[$tahun.$bulan]['ket'] = $keterangan;

            }
        }

        return response()->json(['datas' => $datas]);
    }
}
