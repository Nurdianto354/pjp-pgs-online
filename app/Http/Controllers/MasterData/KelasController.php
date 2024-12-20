<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_data']);
    }

    public function index()
    {
        $datas = Kelas::orderBy('created_at', 'DESC')->get();

        return view('pages.master_data.kelas.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Kelas ".$request->nama;

        $this->validate($request, [
            'nama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            if($request->id != null && $request->id != '') {
                $data = Kelas::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Kelas();
                $data->created_at = Carbon::now();
                $data->status     = true;
            }

            $data->nama         = $request->nama;
            $data->updated_at   = Carbon::now();
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
            $data = Kelas::findOrFail($id);
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
