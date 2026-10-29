<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan & Minuman',
            'Kerajinan Tangan',
            'Fashion',
            'Pertanian',
            'Kecantikan',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}