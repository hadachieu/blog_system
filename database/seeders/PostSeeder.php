<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Lấy toàn bộ danh mục
        $categories = Category::all();

        // Tạo 10.000 bài viết
        for ($i = 1; $i <= 10000; $i++) {
            $post = Post::create([
                'title'   => $faker->sentence(6),
                'content' => $faker->paragraph(5),
                'views'   => $faker->numberBetween(0, 1000),
            ]);

            // Gán ngẫu nhiên 1 đến 3 danh mục cho mỗi bài viết
            $randomCategories = $categories->random(rand(1, 3))->pluck('id')->toArray();
            $post->categories()->attach($randomCategories);
        }
    }
}

