<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseModel;

class CaseModelSeeder extends Seeder
{
    public function run()
    {
        CaseModel::insert([
            ['case_number' => 'Case 001'],
            ['case_number' => 'Case 002'],
            ['case_number' => 'Case 003'],
            ['case_number' => 'Case 004'],
            ['case_number' => 'Case 005'],
        ]);
    }
}
