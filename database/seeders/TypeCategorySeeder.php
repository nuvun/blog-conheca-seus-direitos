<?php

namespace Database\Seeders;

use App\Models\TypeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeCategorySeeder extends Seeder
{

    use WithoutModelEvents;

    public function run(): void
    {
        $rows = [
            ['name' => 'Notícias'],
            ['name' => 'Blogs'],
        ];

        TypeCategory::upsert($rows, ['name'], ['name']);
    }
}
