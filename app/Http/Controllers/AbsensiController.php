<?php

namespace App\Http\Controllers;

use App\Models\Absensi\Absensi;
use App\Models\Absensi\AbsensiDetail;
use App\Models\MasterData\Anggota;
use App\Models\MasterData\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $listKelas   = Kelas::where('status', true)->get();
        $listAnggota = Anggota::select('id', 'nama_panggilan', 'kelas_id')->where([['kelas_id', $kelasId], ['status', true]])->orderBy('nama_panggilan', 'ASC')->get();
        $listAbsensi = Absensi::where([['kelas_id', $kelasId], ['status', true]])->orderBy('tanggal', 'DESC')->get();

        $listAbsensiDetail = [];

        foreach ($listAbsensi as $data) {
            $listDetail = AbsensiDetail::select('id', 'anggota_id', 'absensi')->where('absensi_id', $data->id)->get()->toArray();

            foreach ($listDetail as $value) {
                $listAbsensiDetail[$data->id][$value['anggota_id']] = $value;
            }
        }

        return view('pages.absensi.index', compact('kelasId', 'kelasNama', 'listKelas', 'listAnggota', 'listAbsensi', 'listAbsensiDetail'));
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
                $tanggal = strtotime($request->tanggal);

                $check = Absensi::where([['id', '!=', $request->id], ['tanggal', $tanggal], ['status', true]])->first();

                if (empty($check)) {
                    $data = Absensi::findOrFail($request->id);
                    $dateCurrent = $data->tanggal;

                    $data->tanggal    = strtotime($request->tanggal);
                    $data->status     = true;
                    $data->updated_at = Carbon::now();
                    $data->save();

                    $title .= " dari tanggal ".date('d-m-Y', $dateCurrent)." sampai ".date('d-m-Y', strtotime($request->tanggal));
                } else {
                    toast('Gagal '.$action.' karena tanggal absensi '.date('d-m-Y', $tanggal).' sudah ada.','error');
                    return back();
                }
            } else {
                $tanggalMulai = strtotime($request->tanggal_mulai);
                $tanggalAkhir = strtotime($request->tanggal_akhir);

                if ($tanggalMulai > $tanggalAkhir) {
                    toast('Gagal. menambahkan tanggal absensi, karena tanggal akhir lebih kecil dari tanggal mulai','error');
                    return back();
                }

                while ($tanggalMulai <= $tanggalAkhir) {
                    $data = Absensi::where([['tanggal', $tanggalMulai], ['status', '1']])->first();

                    if (empty($data)) {
                        $data = new Absensi();
                        $data->kelas_id   = $request->kelas_id;
                        $data->tanggal    = $tanggalMulai;
                        $data->status     = true;
                        $data->created_at = Carbon::now();
                        $data->updated_at = Carbon::now();
                        $data->save();
                    }

                    $tanggalMulai = strtotime('+1 day', $tanggalMulai);
                }

                $title .= " dari tanggal ".date('d-m-Y', strtotime($request->tanggal_mulai))." ke ".date('d-m-Y', strtotime($request->tanggal_akhir));
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

    public function deleteAttendanceDate($id)
    {
        DB::beginTransaction();
        try {
            $data = Absensi::findOrFail($id);
            $data->status = false;
            $data->save();

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

    public function store(Request $request)
    {
        $success = true;
        $message = "Data has been saved successfully";

        DB::beginTransaction();
        try {
            $request->validate([
                'kelas_id'   => 'required|integer',
                'absensi_id' => 'required|integer',
                'anggota_id' => 'required|integer',
                'absensi'    => 'required|string',
            ]);

            if ($request->id != null && $request->id != '') {
                $data = AbsensiDetail::findOrFail($request->id);
            } else {
                $data = new AbsensiDetail();
                $data->created_at = Carbon::now();
            }

            $data->kelas_id   = $request->kelas_id;
            $data->absensi_id = $request->absensi_id;
            $data->anggota_id = $request->anggota_id;
            $data->absensi    = $request->absensi;
            $data->updated_at = Carbon::now();
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