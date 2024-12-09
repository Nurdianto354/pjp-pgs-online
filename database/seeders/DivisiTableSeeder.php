<?php

namespace Database\Seeders;

use App\Models\MasterData\Divisi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DivisiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Divisi::create([
            'nama' => 'Paud',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Divisi::create([
            'nama' => 'Caberawit',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Divisi::create([
            'nama' => 'Praremaja',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Divisi::create([
            'nama' => 'Remaja',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Divisi::create([
            'nama' => 'Pranikah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
