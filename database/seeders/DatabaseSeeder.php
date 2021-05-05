<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;

use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        
        $platform_admin_id = DB::table('users')->insertGetId([
            'email' => 'admin@zambezi.edu.ng',
            'password' => Hash::make('password'),
            'name' => 'Zambezi Admin',
            'is_platform_admin' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        $department_id = DB::table('departments')->insertGetId([
            'code' => 'EE',
            'name' => 'Department of Electrical Engineering',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $manager_id = DB::table('managers')->insertGetId([
            'job_title' => 'Prof',
            'email' => 'manager@zambezi.edu.ng',
            'telephone' => '07063321245',
            'first_name' => 'M.O.',
            'last_name' => 'Johnson',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $department_admin_id = DB::table('users')->insertGetId([
            'email' => 'manager@zambezi.edu.ng',
            'password' => Hash::make('password'),
            'name' => 'M.O. Johnson',
            'telephone' => '07063321245',
            'is_platform_admin' => false,
            'department_id' => $department_id,
            'manager_id' => $manager_id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

    }
}
