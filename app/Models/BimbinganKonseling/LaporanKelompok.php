<?php

namespace App\Models\BimbinganKonseling;

use App\Models\MasterData\Divisi;
use App\Models\MasterData\Kelas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKelompok extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'bk_laporan_kelompok';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = false;
    protected $guarded      = [];

    public function getDivisi()
    {
        return $this->hasOne(Divisi::class, 'id', 'divisi_id');
    }

    public function getKelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
