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
            'kategori' => 3,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Bacaan Al-Quran',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Buku Tilawati',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Faham Agama',
            'kategori' => 2,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Asmaul Husnah',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Dalil',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Doa',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Hafalan Surat',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Keilmuan',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Kemandirian',
            'kategori' => 4,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Kitabaty/Pegon/Memaknai',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Makna Hadist',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Makna Quran',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Peraga Paud/Tilawati',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Praktik Ibadah',
            'kategori' => 2,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Tajwid',
            'kategori' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Materi::create([
            'nama' => 'Tata Krama',
            'kategori' => 3,
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
