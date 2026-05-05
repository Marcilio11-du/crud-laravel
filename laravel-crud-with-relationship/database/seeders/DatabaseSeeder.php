<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        Category::create(['name' => 'Hardware', 'description' => 'Peças e componentes']);
        Category::create(['name' => 'Software', 'description' => 'Programas e aplicações']);
        Category::create(['name' => 'AI', 'description' => 'Inteligência Artificial']);


        User::create(['fst_name' => 'Ana',    'sur_name' => 'Silva',   'birth_date' => '1990-05-10']);
        User::create(['fst_name' => 'Carlos', 'sur_name' => 'Mendes',  'birth_date' => '1985-03-22']);
        User::create(['fst_name' => 'Marta',  'sur_name' => 'Ferreira','birth_date' => '1993-11-01']);
    }
}
