<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::latest()->get();

        return view('pages.master_user.user.index', compact('datas'));
    }

    public function create(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
