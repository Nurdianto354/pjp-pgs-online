<?php

namespace App\Models\BimbinganKonseling;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDesa extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'bk_laporan_desa';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = false;
    protected $guarded      = [];

    const listKategori = [
        1 => "Bimbingan",
        2 => "Konseling"
    ];

    const listRealisasi = [
        0 => "Belum",
        1 => "Proses",
        2 => "Sudah"
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
