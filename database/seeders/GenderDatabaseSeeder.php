<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            ['gender' => 'male', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['gender' => 'female', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['gender' => 'other', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
        ]);
    }
}
