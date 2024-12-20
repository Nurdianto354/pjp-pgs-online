<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\Murid\Murid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MuridController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:murid']);
    }

    public function index()
    {
        $listKelas = Kelas::where('status', true)->get();
        $listDivisi = Divisi::where('status', true)->get();

        $datas = Murid::with('getKelas')->get();

        return view('pages.murid.index', compact('listKelas', 'listDivisi', 'datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Murid";

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $data = Murid::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Murid();
                $data->created_at = Carbon::now();
            }

            $data->nama_lengkap   = ucwords(strtolower($request->nama_lengkap));
            $data->nama_panggilan = ucwords(strtolower($request->nama_panggilan));
            $data->jenis_kelamin  = $request->jenis_kelamin;
            $data->divisi_id      = $request->divisi_id;
            $data->kelas_id       = $request->kelas_id;
            $data->tempat_lahir   = $request->tempat_lahir;
            $data->tanggal_lahir  = $request->tanggal_lahir;
            $data->alamat         = $request->alamat;
            $data->no_telp        = $request->no_telp;
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
            $data = Murid::findOrFail($id);
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
