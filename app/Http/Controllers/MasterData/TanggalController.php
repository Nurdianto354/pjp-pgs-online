<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Tanggal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TanggalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $datas = Tanggal::orderBy('tanggal', 'ASC')->get();

        return view('pages.master_data.tanggal.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Tanggal ".date("d-m-Y", strtotime($request->tanggal));

        $checkData = Tanggal::where('tanggal', 'LIKE', '%'.strtotime($request->tanggal).'%')
            ->where('id', '!=', $request->id)
            ->first();

        if (!empty($checkData)) {
            $message = "Gagal. " . " " . $action . " " . $title . " sudah ada dan status ". ($checkData->status == true ? "Active" : "Inactive");

            toast($message, 'info');
            return back();
        }

        DB::beginTransaction();
        try {
            $tanggal = Carbon::parse($request->tanggal);

            if ($request->id != null && $request->id != '') {
                $data = Tanggal::findOrFail($request->id);
                $action = "perbarui";
            } else {
                $data = new Tanggal();
                $data->created_at = Carbon::now();
                $data->status     = true;
            }

            $data->tanggal      = strtotime($tanggal);
            $data->hari         = $tanggal->day;
            $data->bulan        = $tanggal->month;
            $data->tahun        = $tanggal->year;
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
            $data = Tanggal::findOrFail($id);
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
