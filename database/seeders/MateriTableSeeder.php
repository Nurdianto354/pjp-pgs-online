<?php

namespace Database\Seeders;

use App\Models\MasterData\Materi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MateriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materi::create([
            'nama' => 'Akhlaq',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Bacaan Al-Quran',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Buku Tilawati',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Faham Agama',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Asmaul Husnah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Dalil',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Doa',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Surat',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Keilmuan',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Kemandirian',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Kitabaty/Pegon/Memaknai',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Makna Hadist',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Makna Quran',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Peraga Paud/Tilawati',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Praktik Ibadah',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Tajwid',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Tata Krama',
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
