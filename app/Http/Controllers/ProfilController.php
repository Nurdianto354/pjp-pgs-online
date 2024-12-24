<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = Auth::user();

        return view('pages.profil.index', compact('data'));
    }

    public function update($id)
    {
        $data = User::findById($id);

        return view('pages.profil.edit', compact('data'));
    }

    public function store(Request $request)
    {

    }
}
