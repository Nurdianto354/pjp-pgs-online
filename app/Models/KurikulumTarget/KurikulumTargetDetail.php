<?php

namespace App\Models\KurikulumTarget;

use App\Models\MasterData\Karakter;
use App\Models\MasterData\Materi;
use App\Models\MasterData\Satuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumTargetDetail extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'kurikulum_target_detail';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    public function getKarakter()
    {
        return $this->hasOne(Karakter::class, 'id', 'karakter_id');
    }

    public function getMateri()
    {
        return $this->hasOne(Materi::class, 'id', 'materi_id');
    }

    public function getSatuan()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan_id');
    }
}
