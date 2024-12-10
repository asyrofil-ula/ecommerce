<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Category 1',
                'description' => 'Description 1',
            ],
            [
                'name' => 'Category 2',
                'description' => 'Description 2',
            ],
            [
                'name' => 'Category 3',
                'description' => 'Description 3',
            ],
            [
                'name' => 'Category 4',
                'description' => 'Description 4',
            ],
            [
                'name' => 'Category 5',
                'description' => 'Description 5',
            ],
            [
                'name' => 'Category 1',
                'description' => 'Description 1',
            ],
            [
                'name' => 'Category 2',
                'description' => 'Description 2',
            ],
            [
                'name' => 'Category 3',
                'description' => 'Description 3',
            ],
            [
                'name' => 'Category 4',
                'description' => 'Description 4',
            ],
            [
                'name' => 'Category 5',
                'description' => 'Description 5',
            ],

        ]);
    }
}
