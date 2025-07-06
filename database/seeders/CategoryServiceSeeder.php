<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_services')->insert([
            'category' => 'Peluqueria',
        ]);

        DB::table('category_services')->insert([
            'category' => 'Estetica Facial',
        ]);

        DB::table('category_services')->insert([
            'category' => 'Estetica Corporal',
        ]);

        DB::table('category_services')->insert([
            'category' => 'Manicura y Pedicura',
        ]);

        DB::table('category_services')->insert([
            'category' => 'Maquillaje',
        ]);
    }
}
