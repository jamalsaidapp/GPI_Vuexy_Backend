<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalarieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Salary::factory(20)->create();

    }
}
