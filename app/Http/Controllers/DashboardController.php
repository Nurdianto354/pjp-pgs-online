<?php

namespace App\Http\Controllers;

use App\Models\MasterData\Divisi;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listDivisi = Divisi::with('listKelas.listMurid')->where([['status', true]])->get();

        return view('pages.dashboard.index', compact('listDivisi'));
    }
}
