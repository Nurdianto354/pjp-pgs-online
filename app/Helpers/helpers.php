<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('setActiveMenu')) {

    /**
     * setActive
     *
     * @param  mixed $path
     * @return void
     */
    function setActiveMenu($path)
    {
        return Request::is($path . '*') ? ' menu-open' :  '';
    }

}

if (! function_exists('setActive')) {

    /**
     * setActive
     *
     * @param  mixed $path
     * @return void
     */
    function setActive($path)
    {
        return Request::is($path . '*') ? ' active' :  '';
    }

}

if (! function_exists('TanggalID')) {

    /**
     * TanggalID
     *
     * @param  mixed $tanggal
     * @return void
     */
    function TanggalID($tanggal) {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}
