<?php

namespace App\Models\Murid;

use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'murid';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public function getDivisi()
    {
        return $this->hasOne(Divisi::class, 'id', 'divisi_id');
    }

    public function getKelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
