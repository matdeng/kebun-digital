<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $products = [
            // Buah Tropika
            ['category' => 'buah-tropika', 'name' => 'Durian Musang King', 'price' => 65.00, 'unit' => 'kg', 'stock' => 50, 'is_featured' => true, 'description' => 'Durian Musang King premium dari Raub, Pahang. Isi tebal, creamy dan manis.'],
            ['category' => 'buah-tropika', 'name' => 'Mangga Harumanis', 'price' => 18.00, 'unit' => 'kg', 'stock' => 100, 'is_featured' => true, 'description' => 'Mangga Harumanis dari Perlis. Manis, wangi dan isi lembut.'],
            ['category' => 'buah-tropika', 'name' => 'Nanas MD2', 'price' => 8.50, 'unit' => 'pcs', 'stock' => 80, 'is_featured' => false, 'description' => 'Nanas MD2 manis dan tidak masam. Sesuai untuk dimakan segar.'],
            ['category' => 'buah-tropika', 'name' => 'Papaya Eksotika', 'price' => 7.00, 'unit' => 'pcs', 'stock' => 60, 'is_featured' => false, 'description' => 'Papaya Eksotika isi merah, manis dan lembut.'],

            // Buah Tempatan
            ['category' => 'buah-tempatan', 'name' => 'Pisang Berangan', 'price' => 5.50, 'unit' => 'sikat', 'stock' => 120, 'is_featured' => true, 'description' => 'Pisang Berangan manis dan lembut. Sesuai untuk snek.'],
            ['category' => 'buah-tempatan', 'name' => 'Rambutan', 'price' => 8.00, 'unit' => 'kg', 'stock' => 90, 'is_featured' => false, 'description' => 'Rambutan segar dari kebun. Manis dan berair.'],
            ['category' => 'buah-tempatan', 'name' => 'Manggis', 'price' => 15.00, 'unit' => 'kg', 'stock' => 70, 'is_featured' => true, 'description' => 'Manggis — ratu buah. Isi putih, manis masam.'],
            ['category' => 'buah-tempatan', 'name' => 'Langsat', 'price' => 10.00, 'unit' => 'kg', 'stock' => 55, 'is_featured' => false, 'description' => 'Langsat manis dari kebun tempatan.'],
            ['category' => 'buah-tempatan', 'name' => 'Cempedak', 'price' => 12.00, 'unit' => 'kg', 'stock' => 40, 'is_featured' => false, 'description' => 'Cempedak isi tebal dan manis wangi.'],

            // Buah Import
            ['category' => 'buah-import', 'name' => 'Epal Fuji', 'price' => 12.00, 'unit' => 'kg', 'stock' => 100, 'is_featured' => true, 'description' => 'Epal Fuji import dari Jepun. Rangup dan manis.'],
            ['category' => 'buah-import', 'name' => 'Anggur Merah Seedless', 'price' => 18.00, 'unit' => 'kg', 'stock' => 80, 'is_featured' => false, 'description' => 'Anggur merah tanpa biji. Import dari Australia.'],
            ['category' => 'buah-import', 'name' => 'Kiwi Hijau', 'price' => 3.50, 'unit' => 'pcs', 'stock' => 90, 'is_featured' => false, 'description' => 'Kiwi hijau segar dari New Zealand. Kaya vitamin C.'],
            ['category' => 'buah-import', 'name' => 'Pear Hijau', 'price' => 3.00, 'unit' => 'pcs', 'stock' => 100, 'is_featured' => false, 'description' => 'Pear hijau rangup dan menyegarkan.'],
            ['category' => 'buah-import', 'name' => 'Oren Mandarin', 'price' => 14.00, 'unit' => 'kg', 'stock' => 75, 'is_featured' => false, 'description' => 'Oren Mandarin manis dari China.'],

            // Buah Bermusim
            ['category' => 'buah-bermusim', 'name' => 'Durian D24', 'price' => 35.00, 'unit' => 'kg', 'stock' => 30, 'is_featured' => true, 'description' => 'Durian D24 pahit manis. Kegemaran rakyat Malaysia.'],
            ['category' => 'buah-bermusim', 'name' => 'Duku', 'price' => 12.00, 'unit' => 'kg', 'stock' => 45, 'is_featured' => false, 'description' => 'Duku manis dari Johor. Musim terhad.'],

            // Buah Organik
            ['category' => 'buah-organik', 'name' => 'Betik Organik', 'price' => 10.00, 'unit' => 'pcs', 'stock' => 40, 'is_featured' => false, 'description' => 'Betik organik tanpa pestisid. Isi merah dan manis.'],
            ['category' => 'buah-organik', 'name' => 'Pisang Organik', 'price' => 8.00, 'unit' => 'sikat', 'stock' => 50, 'is_featured' => false, 'description' => 'Pisang organik dari ladang tempatan.'],

            // Pek & Bundle
            ['category' => 'pek-bundle', 'name' => 'Pek Buah Campuran', 'price' => 45.00, 'unit' => 'pack', 'stock' => 25, 'is_featured' => true, 'description' => 'Pakej buah campuran — Epal, Oren, Anggur, Kiwi. 1kg setiap jenis.'],
            ['category' => 'pek-bundle', 'name' => 'Pek Buah Tropika', 'price' => 55.00, 'unit' => 'pack', 'stock' => 20, 'is_featured' => true, 'description' => 'Pakej buah tropika — Mangga, Nanas, Papaya, Pisang. Segar dari ladang.'],
        ];

        foreach ($products as $productData) {
            $categorySlug = $productData['category'];
            unset($productData['category']);

            $category = $categories->get($categorySlug);
            if ($category) {
                Product::updateOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($productData['name'])],
                    array_merge($productData, [
                        'category_id' => $category->id,
                        'slug' => \Illuminate\Support\Str::slug($productData['name']),
                        'is_active' => true,
                    ])
                );
            }
        }
    }
}
