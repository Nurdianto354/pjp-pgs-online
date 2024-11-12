<?php

namespace App\Http\Controllers\MasterUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.master_user.user.index');
    }

    public function create(Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
