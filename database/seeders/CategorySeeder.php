<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // DB::table('categories')->insert([
        //    'name' => 'category 1',
        //    'slug' => Str::slug('category 1'),
        //    'description' => "Category Description Text",

        // ]);

        Category::factory(5)->create();
    }
}
