<?php

namespace App\Models\PencapaianTarget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencapaianTarget extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'pencapaian_target';
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
}
