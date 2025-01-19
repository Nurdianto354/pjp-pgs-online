<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_user|master_user.role']);
    }

    public function index()
    {
        $datas = Role::orderBy('name', 'ASC')->get();

        return view('pages.master_user.role.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Role";

        $this->validate($request, [
            'nama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            if($request->id != null && $request->id != '') {
                $data = Role::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $data = new Role();
                $data->created_at = Carbon::now();
            }

            $data->name       = $request->nama;
            $data->updated_at = Carbon::now();
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
            $data = Role::findOrFail($id);
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

    public function setAkses($id)
    {
        $role = Role::findById($id);
        $listPermission = Permission::orderBy('name', 'ASC')->get();

        return view('pages.master_user.role.edit', compact('role', 'listPermission'));
    }

    public function store(Request $request)
    {
        $role = Role::findById($request->id);

        $role->syncPermissions($request->input('permissions'));

        if ($role) {
            return redirect()->route('master_user.role.index')->with(['success' => 'Set Akses role user berhasil']);
        } else {
            return redirect()->route('master_user.role.index')->with(['error' => 'Set Akses role user gagal, mohon coba kembali']);
        }
    }
}
