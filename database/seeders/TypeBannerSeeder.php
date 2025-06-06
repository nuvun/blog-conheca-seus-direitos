<?php

namespace Database\Seeders;

use App\Models\TypeBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeBannerSeeder extends Seeder
{

    use WithoutModelEvents;

    public function run(): void
    {
        $rows = [
            ['name' => 'Full Banner 1'],
            ['name' => 'Full Banner 2'],
            ['name' => 'Quadrado 1'],
        ];

        TypeBanner::upsert($rows, ['name'], ['name']);
    }
}
