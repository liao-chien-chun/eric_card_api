<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('categories')->insert([
            ['category_name' => '科技', 'created_at' => now()],
            ['category_name' => '生活', 'created_at' => now()],
            ['category_name' => '美食', 'created_at' => now()],
            ['category_name' => '財金', 'created_at' => now()],
            ['category_name' => '工作', 'created_at' => now()],
            ['category_name' => '娛樂', 'created_at' => now()],
            ['category_name' => '心情', 'created_at' => now()],
            ['category_name' => '感情', 'created_at' => now()]
        ]);
    }
}
