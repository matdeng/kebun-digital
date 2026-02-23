<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Buah Tropika',
                'slug' => 'buah-tropika',
                'description' => 'Buah-buahan tropika segar dari ladang tempatan',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Tempatan',
                'slug' => 'buah-tempatan',
                'description' => 'Buah-buahan tempatan Malaysia yang popular',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Import',
                'slug' => 'buah-import',
                'description' => 'Buah-buahan import berkualiti tinggi',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Bermusim',
                'slug' => 'buah-bermusim',
                'description' => 'Buah-buahan bermusim yang terhad',
                'is_active' => true,
            ],
            [
                'name' => 'Buah Organik',
                'slug' => 'buah-organik',
                'description' => 'Buah-buahan organik tanpa pestisid',
                'is_active' => true,
            ],
            [
                'name' => 'Pek & Bundle',
                'slug' => 'pek-bundle',
                'description' => 'Pakej buah-buahan dengan harga istimewa',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
