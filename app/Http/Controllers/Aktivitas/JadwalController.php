<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Jadwal;
use App\Models\MasterData\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $divisi = Divisi::where([['status', true], ['nama', 'Paud']])->first();

        $divisiId   = $divisi->id;
        $divisiNama = $divisi->nama;

        if($request->has('divisi_id')) {
            $divisi = Divisi::where([['status', true], ['id', $request->divisi_id]])->first();

            $divisiId   = $divisi->id;
            $divisiNama = $divisi->nama;
        }

        $datas = Jadwal::where([['status', true], ['divisi_id', $divisiId]])->orderBy('hari', 'ASC')->get();
        $listDivisi = Divisi::where('status', true)->orderBy('id', 'ASC')->get();

        return view('pages.aktivitas.jadwal.index', compact('datas', 'listDivisi', 'divisiId', 'divisiNama'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Jadwal Hari " . Jadwal::listDay[$request->hari] . " Waktu " . $request->waktu_mulai . " : " . $request->waktu_selesai;

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $data = Jadwal::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Jadwal();
                $data->created_at = Carbon::now();
            }

            $data->divisi_id     = $request->divisi_id;
            $data->hari          = $request->hari;
            $data->waktu_mulai   = $request->waktu_mulai;
            $data->waktu_selesai = $request->waktu_selesai;
            $data->status        = true;
            $data->updated_at    = Carbon::now();
            $data->save();

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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Jadwal::findOrFail($id);
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
}
