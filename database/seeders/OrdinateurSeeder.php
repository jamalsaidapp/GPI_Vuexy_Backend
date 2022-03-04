<?php

namespace Database\Seeders;

use App\Models\Ordinateur;
use App\Models\Salarie;
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
         \App\Models\Ordinateur::factory(20)->create();
         foreach (Ordinateur::all() as $Ordinateur){
             $salarie = Salarie::inRandomOrder()->take(rand(1,4))->pluck('id');
             $Ordinateur->salaries()->attach($salarie);
         }
    }
}
