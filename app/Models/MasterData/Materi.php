<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $connection   = 'mysql';
    protected $table        = 'm_materi';
    protected $primaryKey   = 'id';
    protected $keyType      = 'int';
    public $incrementing    = true;
    public $timestamps      = true;
    protected $guarded      = [];

    const listKategori = [
        1 => 'Alim',
        2 => 'Faqih',
        3 => 'Akhlakul Karimah',
        4 => 'Mandiri'
    ];
}
