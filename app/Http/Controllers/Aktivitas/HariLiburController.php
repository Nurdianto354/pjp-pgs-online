<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\HariLibur;
use App\Models\MasterData\Divisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HariLiburController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:aktivitas']);
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

        $datas = HariLibur::where([['status', true], ['divisi_id', $divisiId]])->orderBy('hari', 'ASC')->get();
        $listDivisi = Divisi::where('status', true)->orderBy('id', 'ASC')->get();

        return view('pages.aktivitas.hari_libur.index', compact('datas', 'listDivisi', 'divisiId', 'divisiNama'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Hari Libur tanggal " . date("d-m-Y", strtotime($request->tanggal));

        DB::beginTransaction();
        try {
            if ($request->id != null && $request->id != '') {
                $data = HariLibur::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new HariLibur();
            }

            $tanggal = Carbon::parse($request->tanggal);

            $data->divisi_id  = $request->divisi_id;
            $data->tanggal    = strtotime($tanggal);
            $data->hari       = $tanggal->dayOfWeek;
            $data->bulan      = $tanggal->month;
            $data->tahun      = $tanggal->year;
            $data->keterangan = $request->keterangan;
            $data->status     = true;
            $data->updated_at = Carbon::now();
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
            $data = HariLibur::findOrFail($id);
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
