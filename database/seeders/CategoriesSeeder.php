<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik'],
            ['name' => 'Fashion Pria'],
            ['name' => 'Fashion Wanita'],
            ['name' => 'Handphone & Tablet'],
            ['name' => 'Olahraga'],
        ];

        Category::insert($categories);
    }
}
