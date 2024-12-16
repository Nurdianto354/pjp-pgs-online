<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.aktivitas.jadwal.index');
    }
}
