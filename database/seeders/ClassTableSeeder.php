<?php

namespace Database\Seeders;

use App\Models\MasterData\Classes;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClassTableSeeder extends Seeder
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
            Classes::create([
                'name' => 'Paud '.$convertNumToAlpa[$i],
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            Classes::create([
                'name' => 'Tilawati '.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Al-Quran A-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Al-Quran B-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Al-Quran C-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Praremaja A-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Praremaja B-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 2; $i++) {
            Classes::create([
                'name' => 'Praremaja C-'.$i,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        Classes::create([
            'name' => 'Remaja',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Classes::create([
            'name' => 'Pranikah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
