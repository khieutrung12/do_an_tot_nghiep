<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'customer', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
            ['name' => 'guest', 'created_at' => new DateTime(), 'updated_at' => new DateTime()],
        ]);
    }
}
