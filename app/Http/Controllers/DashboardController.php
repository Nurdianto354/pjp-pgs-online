<?php

namespace App\Http\Controllers;

use App\Models\MasterData\Divisi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();

        if (array_intersect($roles, ['paud', 'caberawit', 'praremaja', 'remaja', 'pranikah'])) {
            $divisiIds = [];

            foreach ($roles as $role) {
                $divisi = Divisi::select('id')
                    ->where([['nama', ucfirst(strtolower($role))], ['status', true]])
                    ->first();

                if ($divisi) {
                    $divisiIds[] = $divisi->id;
                }
            }

            $listDivisi = Divisi::with('listKelas.listMurid')->where([['status', true]])->whereIn('id', $divisiIds)->get();
        } else {
            $listDivisi = Divisi::with('listKelas.listMurid')->where([['status', true]])->get();
        }


        return view('pages.dashboard.index', compact('listDivisi'));
    }
}
