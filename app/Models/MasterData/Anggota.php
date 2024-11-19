<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'm_anggota';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public function getKelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
