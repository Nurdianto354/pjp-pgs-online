<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanggalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $startDate = Carbon::now()->startOfYear();
        // $endDate = Carbon::now()->endOfYear();

        $startDate = Carbon::createFromDate(2025, 1, 1)->startOfYear();
        $endDate = Carbon::createFromDate(2025, 12, 31)->endOfYear();

        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            DB::table('m_tanggal')->insert([
                'tanggal'    => strtotime($currentDate->format('Y-m-d')),
                'hari'       => $currentDate->dayOfWeek,
                'bulan'      => $currentDate->month,
                'tahun'      => $currentDate->year,
                'status'     => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Increment the current date by one day
            $currentDate->addDay();
        }
    }
}
