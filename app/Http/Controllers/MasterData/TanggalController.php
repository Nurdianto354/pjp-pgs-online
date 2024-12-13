<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TanggalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $datas = TahunAjaran::where('status', true)->orderBy('created_at', 'DESC')->get();

        return view('pages.master_data.tahun_ajaran.index', compact('datas'));
    }
}
