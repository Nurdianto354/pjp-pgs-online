<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Materi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MateriController extends Controller
{
    public function index()
    {
        $listKategories = Materi::listKategori;
        $datas = Materi::where('status', true)->orderBy('created_at', 'DESC')->get();

        return view('pages.master_data.materi.index', compact('datas', 'listKategories'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Materi";

        DB::beginTransaction();
        try {
            if($request->id != null && $request->id != '') {
                $data = Materi::findOrFail($request->id);
                $action = "perbarui";
            } else {
                $data = new Materi();
                $data->created_at = Carbon::now();
                $data->status     = true;
            }

            $data->nama         = $request->nama;
            $data->kategori     = $request->kategori;
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
            $data = Materi::findOrFail($id);
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
