<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.master_user.role.index');
    }

    public function create(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
