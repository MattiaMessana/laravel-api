<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['HTML', 'CSS', 'SCSS', 'JAVASCRIPT','VUE.JS','NODE.JS', 'VITE', 'BOOTSTRAP', 'PHP', 'LARAVEL'];

        foreach ($technologies as $tech) {
            $newTech = new Technology();
            $newTech->name = $tech;
            $newTech->save();
        }
    }
}
