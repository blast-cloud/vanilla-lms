<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Semester;
use DB;
use Carbon\Carbon;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semesters_id = DB::table('semesters')->insertGetId([
            'code' => 'First Semester, 2021/2022',
            'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),  
        ]);
    }
}
