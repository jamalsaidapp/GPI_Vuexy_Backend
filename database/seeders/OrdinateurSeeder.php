<?php

namespace Database\Seeders;

use App\Models\Laptop;
use App\Models\Salary;
use Illuminate\Database\Seeder;

class OrdinateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\Laptop::factory(20)->create();
         foreach (Laptop::all() as $Laptop){
             $salary = Salary::inRandomOrder()->take(rand(1,4))->pluck('id');
             $Laptop->salaries()->attach($salary);
         }
    }
}
