<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'aktivitas_jadwal';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public static function getTab($tab, $nTab, $isFade = false)
    {
        $active = "";

        if ($isFade) {
            $active = "fade";
        }

        if ($tab == $nTab) {
            $active = 'active';
        }

        return $active;
    }

    const listDay = [
        '1' => 'Senin',
        '2' => 'Selasa',
        '3' => 'Rabu',
        '4' => 'Kamis',
        '5' => 'Jumat',
        '6' => 'Sabtu',
        '7' => 'Minggu',
    ];
}
