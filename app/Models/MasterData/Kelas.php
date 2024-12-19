<?php

namespace App\Models\MasterData;

use App\Models\Murid\Murid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'm_kelas';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public function getDivisi()
    {
        return $this->belongsTo(Divisi::class, 'id', 'divisi_id');
    }

    // Relasi ke model Student (Satu Kelas memiliki banyak Murid)
    public function listMurid()
    {
        return $this->hasMany(Murid::class, 'kelas_id', 'id');
    }
}
