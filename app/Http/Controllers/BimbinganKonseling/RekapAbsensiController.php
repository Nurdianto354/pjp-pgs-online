<?php

namespace App\Http\Controllers\BimbinganKonseling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index()
    {
        return view('pages.bimbingan_konseling.rekap_absensi.index');
    }
}
