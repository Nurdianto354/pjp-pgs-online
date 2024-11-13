<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $datas = Role::latest()->get();

        return view('pages.master_user.role.index', compact('datas'));
    }

    public function create(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
