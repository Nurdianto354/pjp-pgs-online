<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_user|master_user.permission']);
    }

    public function index()
    {
        $datas = Permission::orderBy('name', 'ASC')->get();

        return view('pages.master_user.permission.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Permission";

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            if($request->id != null && $request->id != '') {
                $data = Permission::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Permission();
                $data->created_at = Carbon::now();
            }

            $data->name         = $request->name;
            $data->updated_at   = Carbon::now();
            $data->save();

            DB::commit();

            $message = $status . " " . $action . " " . $title;

            toast($message, 'success');
            return back();
        } catch (\Exception $e) {
            DB::rollback();

            toast('Gagal. Mohon cek kembali','error');
            return back();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Permission::findOrFail($id);
            $data->delete();

            DB::commit();

            return response()->json([
                'status'     => 'success',
                'keterangan' => '',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status'     => 'error',
                'keterangan' => 'karena ada kesalahan di sistem'
            ]);
        }
    }
}
