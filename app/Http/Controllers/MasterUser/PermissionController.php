<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return view('pages.master_user.permission.index');
    }

    public function create(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
