<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class user extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'ahmed',
            'email' => 'ahmedaou@example.com',
            'password' => bcrypt('123'),
            'date_debut_session' =>'2024-06-06',
            'id_employe' =>1,
            'id_role' =>1,
            'id_user_createure' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
