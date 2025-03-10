<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'm_divisi';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public function listKelas()
    {
        return $this->hasMany(Kelas::class, 'divisi_id', 'id');
    }
}
