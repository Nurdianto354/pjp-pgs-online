<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:master_user.user']);
    }

    public function index()
    {
        $datas = User::latest()->get();

        return view('pages.master_user.user.index', compact('datas'));
    }

    public function create()
    {
        $title = "Tambah";
        $data = null;
        $listRole = Role::orderBy('name', 'ASC')->get();

        return view('pages.master_user.user.create', compact('title', 'data', 'listRole'));
    }

    public function update($id)
    {
        $title = "Perbarui";
        $data = User::findOrFail($id);
        $listRole = Role::orderBy('name', 'ASC')->get();

        return view('pages.master_user.user.create', compact('title', 'data', 'listRole'));
    }

    public function store(Request $request)
    {
        $status = "Berhasil";
        $action = "menambahkan";
        $title  = "Data Username ".$request->username." Nama ".$request->nama;

        DB::beginTransaction();
        try {
            $this->validate($request, [
                'username'  => 'required',
                'email'     => 'required|email',
                'nama'      => 'required',
            ]);

            if ($request->id != null && $request->id != '') {
                $data = User::findOrFail($request->id);
                $action = "memperbarui";
            } else {
                $this->validate($request, [
                    'username'  => 'required|unique:users',
                    'email'     => 'required|email|unique:users',
                    'password'  => 'required|confirmed'
                ]);

                $data = new User();
                $data->created_at = Carbon::now();
            }

            $data->username = $request->username;
            $data->nama     = $request->nama;
            $data->email    = $request->email;
            $data->no_telp  = $request->no_telp;
            $data->status   = true;

            if ($request->password != null && $request->password != '') {
                $data->password = bcrypt($request->password);
            }

            $data->updated_at = Carbon::now();
            $data->save();

            if ($request->id != null && $request->id != '') {
                 $data->syncRoles($request->input('roles'));
            }  else {
                foreach ($request->input('roles') as $role) {
                    $data->assignRole($role);
                }
            }

            DB::commit();

            $message = $status . " " . $action . " " . $title;

            return redirect()->route('master_user.user.index')->with(['success' => $message]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();

            return back()->with('error', 'Gagal ' . " " . $action . " " . $title);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = User::findOrFail($id);
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
