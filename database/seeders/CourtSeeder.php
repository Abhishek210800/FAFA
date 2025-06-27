<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;

class CourtSeeder extends Seeder
{
    public function run()
    {
        Court::insert([
            ['name' => 'Supreme Court'],
            ['name' => 'High Court'],
            ['name' => 'District Court'],
            ['name' => 'Family Court'],
        ]);
    }
}
