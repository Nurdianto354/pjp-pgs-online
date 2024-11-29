<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Anggota;
use App\Models\MasterData\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnggotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listKelas = Kelas::where('status', true)->get();
        $datas = Anggota::with('getKelas')->get();

        return view('pages.master_data.anggota.index', compact('listKelas', 'datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Anggota";

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $data = Anggota::findOrFail($request->id);
                $action = "perbarui";
            } else {
                $data = new Anggota();
                $data->created_at = Carbon::now();
            }

            $data->nama_lengkap   = $request->nama_lengkap;
            $data->nama_panggilan = $request->nama_panggilan;
            $data->kelas_id       = $request->kelas_id;
            $data->tempat_lahir   = $request->tempat_lahir;
            $data->tanggal_lahir  = $request->tanggal_lahir;
            $data->status         = true;
            $data->updated_at     = Carbon::now();
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
            $data = Anggota::findOrFail($id);
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
