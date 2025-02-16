<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {
            Category::create([
                'title' => 'Danh mục ' . $i,
                // views sẽ được cập nhật sau, ban đầu để mặc định 0
            ]);
        }
    }
}

