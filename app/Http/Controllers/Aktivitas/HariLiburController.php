<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.aktivitas.hari_libur.index');
    }
}
