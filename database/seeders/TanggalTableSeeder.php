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
        // Define the year range (1 year)
        $startDate = Carbon::now()->startOfYear(); // Get the first day of the current year
        $endDate = Carbon::now()->endOfYear(); // Get the last day of the current year

        // Loop through each day within the range
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
