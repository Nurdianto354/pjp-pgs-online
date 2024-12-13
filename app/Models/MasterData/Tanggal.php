<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggal extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'm_tanggal';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];
}
