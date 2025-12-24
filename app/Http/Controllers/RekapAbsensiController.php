<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi\Absensi;
use App\Models\Aktivitas\HariLibur;
use App\Models\Aktivitas\Jadwal;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\MasterData\Tanggal;
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
        $muridId  = $request->id;
        $kelasId  = $request->kelas_id;
        $divisiId = $request->divisi_id;

        // Ambil hari aktif jadwal (1x query)
        $jadwalHari = Jadwal::where('divisi_id', $divisiId)
            ->where('status', true)
            ->pluck('hari')
            ->toArray();

        // Ambil tahun & bulan unik langsung (1x query)
        $periode = Absensi::where('murid_id', $muridId)
            ->selectRaw('tahun, bulan')
            ->distinct()
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        $datas = [];

        foreach ($periode as $row) {
            $tahun = $row->tahun;
            $bulan = $row->bulan;

            // Hari libur (1x per bulan)
            $hariLibur = HariLibur::where([
                    ['divisi_id', $divisiId],
                    ['bulan', $bulan],
                    ['tahun', $tahun],
                    ['status', true],
                ])
                ->pluck('tanggal')
                ->toArray();

            // Tanggal efektif
            $listTanggal = Tanggal::where([
                    ['tahun', $tahun],
                    ['bulan', $bulan],
                    ['status', true],
                ])
                ->whereIn('hari', $jadwalHari)
                ->whereNotIn('tanggal', $hariLibur)
                ->pluck('tanggal')
                ->toArray();

            $total = count($listTanggal);

            if ($total === 0) {
                continue;
            }

            // Hitung absensi (1x query)
            $absensi = Absensi::where([
                    ['murid_id', $muridId],
                    ['kelas_id', $kelasId],
                ])
                ->whereIn('tanggal', $listTanggal)
                ->selectRaw('
                    SUM(kehadiran = "H") as hadir,
                    SUM(kehadiran IN ("I","S")) as izin
                ')
                ->first();

            $hadir = (int) $absensi->hadir;
            $izin  = (int) $absensi->izin;
            $alfa  = $total - ($hadir + $izin);

            $pers  = round(($hadir / $total) * 100, 2);

            $ket = match (true) {
                $pers < 40 => 'Tidak lancar',
                $pers < 60 => 'Kurang lancar',
                $pers < 80 => 'Lancar',
                default   => 'Sangat lancar',
            };

            // Key YYYYMM (frontend sorting jadi super gampang)
            $key = $tahun . str_pad($bulan, 2, '0', STR_PAD_LEFT);

            $datas[$key] = [
                'tahun' => $tahun,
                'bulan' => Tanggal::listBulan[$bulan],
                'hadir' => $hadir,
                'izin'  => $izin,
                'alfa'  => $alfa,
                'pers'  => number_format($pers, 2),
                'ket'   => $ket,
            ];
        }

        return response()->json(['datas' => $datas]);
    }
}
