<?php

namespace App\Http\Controllers;

use App\Models\Absensi\Absensi;
use App\Models\MasterData\Anggota;
use App\Models\MasterData\Kelas;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
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

        $listKelas = Kelas::where('status', true)->get();
        $listAnggota = Anggota::select('id', 'nama_panggilan', 'kelas_id')->where([['kelas_id', $kelasId], ['status', true]])->orderBy('nama_panggilan', 'ASC')->get();

        return view('pages.absensi.index', compact('kelasId', 'kelasNama', 'listKelas', 'listAnggota'));
    }

    public function addAttendanceDate(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "tanggal absensi";

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $action = "perbarui";

                $data = Absensi::findOrFail($request->id);
                $tanggalSebelumnya = $data->tanggal;

                $data->tanggal    = strtotime($request->tanggal);
                $data->status     = true;
                $data->updated_at = Carbon::now();
                $data->save();

                $title .= " dari tanggal ".date('d-m-Y', $tanggalSebelumnya)." ke ".date('d-m-Y', $request->tanggal);
            } else {
                $tanggalMulai = strtotime($request->tanggal_mulai);
                $tanggalAkhir = strtotime($request->tanggal_akhir);

                if (strtotime($tanggalMulai) > strtotime($tanggalAkhir)) {
                    toast('Gagal. menambahkan tanggal absensi, karena tanggal akhir lebih kecil dari tanggal mulai','error');
                    return back();
                }

                while ($tanggalMulai <= $tanggalAkhir) {
                    $data = Absensi::findOrFail($request->id);
                    $data->kelas_id   = $request->kelas_id;
                    $data->tanggal    = strtotime($tanggalMulai);
                    $data->status     = true;
                    $data->created_at = Carbon::now();
                    $data->updated_at = Carbon::now();
                    $data->save();

                    $tanggalMulai = strtotime('+1 day', $tanggalMulai);
                }

                $title .= " dari tanggal ".date('d-m-Y', $request->tanggal_mulai)." sampai ".date('d-m-Y', $request->tanggal_akhir);
            }

            DB::commit();

            $message = $status . " " . $action . " " . $title;

            toast($message, 'success');
            return back();
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            toast('Gagal. Mohon cek kembali','error');
            return back();
        }
    }

    public function create(Request $request)
    {
        $title = !empty($request['id']) ? "Perbarui" : "Tambah";

        $id = $request['id'];
        $kelasId = $request['kelas_id'];

        $kelasNama = Kelas::where([['status', true], ['id', $kelasId]])->pluck('nama')->first();
        $listAnggota = Anggota::where([['status', true], ['kelas_id', $kelasId]])->get();

        return view('pages.absensi.create', compact('title', 'id', 'kelasId', 'kelasNama', 'listAnggota'));
    }

    public function store(Request $request)
    {

    }
}
