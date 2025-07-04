<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'advocate'],
            ['id' => 2, 'name' => 'mediator'],
            ['id' => 3, 'name' => 'appellant'],
            ['id' => 4, 'name' => 'respondent'],
        ]);
    }
}
