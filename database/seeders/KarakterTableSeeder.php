<?php

namespace Database\Seeders;

use App\Models\MasterData\Karakter;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KarakterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Karakter::create([
            'nama' => 'Alim',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Karakter::create([
            'nama' => 'Faqih',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Karakter::create([
            'nama' => 'Akhlakul Karimah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Karakter::create([
            'nama' => 'Mandiri',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
