<?php

namespace App\Http\Controllers\Kelompok\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Kelompok\MasterData\Pengajian;
use Illuminate\Http\Request;

class PengajianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_data']);
    }

    public function index()
    {
        $datas = Pengajian::orderBy('created_at', 'DESC')->get();

        return view('pages.kelompok.master_data.pengajian.index', compact('datas'));
    }

    // public function create(Request $request)
    // {
    //     $status = "Berhasil";
    //     $action = "menambahkan";
    //     $title  = "Data Materi ".$request->nama;

    //     $this->validate($request, [
    //         'nama' => 'required|string|max:255',
    //     ]);

    //     $checkData = Materi::where('nama', 'LIKE', '%'.$request->nama.'%')->where('id', '!=', $request->id)
    //         ->first();

    //     if (!empty($checkData)) {
    //         $message = "Gagal. " . " " . $action . " " . $title . " sudah ada dan status ". ($checkData->status == true ? "Active" : "Inactive");

    //         toast($message, 'info');
    //         return back();
    //     }

    //     DB::beginTransaction();
    //     try {
    //         if($request->id != null && $request->id != '') {
    //             $data = Materi::findOrFail($request->id);
    //             $action = "memperbarui";
    //         } else {
    //             $data = new Materi();
    //             $data->created_at = Carbon::now();
    //         }

    //         $data->nama       = ucwords(strtolower($request->nama));
    //         $data->status     = true;
    //         $data->updated_at = Carbon::now();
    //         $data->save();

    //         DB::commit();

    //         $message = $status . " " . $action . " " . $title;

    //         toast($message, 'success');
    //         return back();
    //     } catch (\Exception $e) {
    //         DB::rollback();

    //         toast('Gagal. Mohon cek kembali','error');
    //         return back();
    //     }
    // }

    // public function destroy($id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $data = Materi::findOrFail($id);
    //         $data->status = false;
    //         $data->save();

    //         DB::commit();

    //         return response()->json([
    //             'status'     => 'success',
    //             'keterangan' => '',
    //         ]);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();

    //         return response()->json([
    //             'status'     => 'error',
    //             'keterangan' => 'karena ada kesalahan di sistem'
    //         ]);
    //     }
    // }
}
