<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Judge;

class JudgeSeeder extends Seeder
{
    public function run()
    {
        Judge::insert([
            ['name' => 'Judge Amarjeet'],
            ['name' => 'Judge Abhishek'],
            ['name' => 'Judge Yash'],
            ['name' => 'Judge Ketan'],
            ['name' => 'Judge Parish'],
        ]);
    }
}
