<?php

namespace Database\Seeders;

use App\Models\MasterData\Kelas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $convertNumToAlpa = [
            1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D',
            5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H',
            9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L'
        ];

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Paud '.$convertNumToAlpa[$i],
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            Kelas::create([
                'nama' => 'Tilawati '.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Al-Quran A-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Al-Quran B-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Al-Quran C-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Praremaja A-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Praremaja B-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Kelas::create([
                'nama' => 'Praremaja C-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        Kelas::create([
            'nama' => 'Remaja',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Kelas::create([
            'nama' => 'Pranikah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
