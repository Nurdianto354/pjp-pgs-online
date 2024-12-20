<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DivisiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_data']);
    }

    public function index()
    {
        $datas = Divisi::orderBy('created_at', 'DESC')->get();

        return view('pages.master_data.divisi.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Divisi ".$request->nama;

        $this->validate($request, [
            'nama' => 'required|string|max:255',
        ]);

        $checkData = Divisi::where('nama', 'LIKE', '%'.$request->nama.'%')->where('id', '!=', $request->id)
            ->first();

        if (!empty($checkData)) {
            $message = "Gagal. " . " " . $action . " " . $title . " sudah ada dan status ". ($checkData->status == true ? "Active" : "Inactive");

            toast($message, 'info');
            return back();
        }

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $data = Divisi::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Divisi();
                $data->created_at = Carbon::now();
                $data->status     = true;
            }

            $data->nama         = ucwords(strtolower($request->nama));
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
            $data = Divisi::findOrFail($id);
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
