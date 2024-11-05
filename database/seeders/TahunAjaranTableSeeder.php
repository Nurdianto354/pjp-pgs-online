<?php

namespace Database\Seeders;

use App\Models\MasterData\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TahunAjaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::create([
            'nama' => '2024/2025',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        TahunAjaran::create([
            'nama' => '2025/2026',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
